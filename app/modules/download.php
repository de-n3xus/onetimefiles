<?
include $_SERVER['DOCUMENT_ROOT'].'/app/config.php';
include $_SERVER['DOCUMENT_ROOT'].'/app/modules/db.php';

$file = $link->query("SELECT * FROM `files` WHERE `name`='$id'")->fetch(PDO::FETCH_ASSOC);

if($file == false) {
    header('Location: /404');
    exit();
}

if($file['lim'] <= 0) {
    unlink($realname);
    $sql = "DELETE FROM files WHERE name = :name";
    $query = $link->prepare($sql);
    $query->bindValue(":name", $file['name']);
    $query->execute();
    header('Location: /end');
    exit();
}
else {
    $lim = $file['lim'] - 1;
    $sql = "UPDATE files SET lim=? WHERE name=?";
    $query = $link->prepare($sql);
    $query->execute([$lim, $id]);
    $realname = $_SERVER['DOCUMENT_ROOT'].'/app/uploads/'.$file['real'];
    header('Content-Disposition: attachment; filename="'.$file['real'].'"');
    readfile($realname);
    if($lim <= 0) {
        unlink($realname);
        $sql = "DELETE FROM files WHERE name = :name";
        $query = $link->prepare($sql);
        $query->bindValue(":name", $file['name']);
        $query->execute();
    }
    header('Location: /download/'.$id.'?c=1');
}
?>