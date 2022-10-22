<?
include $_SERVER['DOCUMENT_ROOT'].'/app/config.php';
include $_SERVER['DOCUMENT_ROOT'].'/app/modules/db.php';
$id = htmlspecialchars($_GET['id']);

$file = $link->query("SELECT * FROM `files` WHERE `name`='$id'")->fetch(PDO::FETCH_ASSOC);
if($file == false) {
    $id = 'Не найден';
}

if($_GET['do'] == 1) {
	if($file == false) {
		echo '<h5 class="filename">Файл: '.$id.'</h5>';
	}
	else{echo '<h5 class="filename">Файл: '.$id.'</h5><p class="text-white downsal">Загрузок еще: '.$file['lim'].'</p>';}
}
if($_GET['do'] == 2) {
	if($file == false) {}
	else{echo '<button type="submit" class="btn btn-primary" onclick="setInterval(load,1000);">Скачать файл</button>';}
}