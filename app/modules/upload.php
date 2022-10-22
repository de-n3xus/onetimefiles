<?php
include $_SERVER['DOCUMENT_ROOT'].'/app/config.php';
include $_SERVER['DOCUMENT_ROOT'].'/app/modules/db.php';
$lim = filter_var(trim($_POST['lim']), FILTER_SANITIZE_STRING);
$input_name = 'file';
$allow = array();
$deny = array();
// Директория куда будут загружаться файлы.
$path = $_SERVER['DOCUMENT_ROOT'].'/app/uploads/';
$error = $success = '';
if (!isset($_FILES[$input_name])) {
	$error = 'Файл не загружен.';
} else {
	$file = $_FILES[$input_name];
	// Проверим на ошибки загрузки.
	if($_POST['lim'] <= 0) {
		$error = 'Лимит загрузок файла не может быть меньше или равен 0';
	}
	if($_POST['lim'] >= 101) {
		$error = 'Лимит загрузок файла не может быть больше 100';
	}
	elseif (!empty($file['error']) || empty($file['tmp_name'])) {
		$error = 'Не удалось загрузить файл.';
	} elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
		$error = 'Не удалось загрузить файл.';
	} elseif($file['size'] > 314572800) {
		$error = 'Размер файла не может превышать 300 мб!';
	} else {
		// Оставляем в имени файла только буквы, цифры и некоторые символы.
		$permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
		$rand = substr(str_shuffle($permitted_chars), 7, 24);
		$pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
		$name1 = mb_eregi_replace($pattern, '-', $file['name']);
		$name = mb_eregi_replace($pattern, '-', $file['name']);
		$name = mb_ereg_replace('[-]+', '-', $name);
		$name = $rand.''.$name;
		$parts = pathinfo($name);

		$parts = pathinfo($name);
		if (empty($name) || empty($parts['extension'])) {
			$error = 'Недопустимый тип файла';
		} elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
			$error = 'Недопустимый тип файла';
		} else {
			// Перемещаем файл в директорию.
			if (move_uploaded_file($file['tmp_name'], $path . $name)) {
				$real = $name;
				$query = "INSERT INTO `files` (`real`, `name`, `lim`) VALUES (:real, :name, :lim)" or die("SQL insert error");
				$result = $link->prepare($query);
				$result->bindValue(':real', $real, PDO::PARAM_STR);
				$result->bindValue(':name', $rand, PDO::PARAM_STR);
				$result->bindValue(':lim', $lim, PDO::PARAM_STR);
				$result->execute();

				$success = '<p style="color: #f33b48;">Успешно!</p><meta http-equiv="refresh" content="0;/download/'.$rand.'">';
			} else {
				$error = 'Не удалось загрузить файл.';
			}
		}
	}
}
// Вывод сообщения о результате загрузки.
if (!empty($error)) {
	$error = '<p class="text-warning">'.$error.'</p>';  
}
$data = array(
	'error'   => $error,
	'success' => $success,
);
header('Content-Type: application/json');
echo json_encode($data, JSON_UNESCAPED_UNICODE);
exit();