<?
include $_SERVER['DOCUMENT_ROOT'].'/app/config.php';
include $_SERVER['DOCUMENT_ROOT'].'/app/modules/db.php';

$file = $link->query("SELECT * FROM `files` WHERE `name`='$id'")->fetch(PDO::FETCH_ASSOC);
if($file == false) {
    $id = 'Не найден';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>1timeFile</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link href="/main.css" rel="stylesheet" type="text/css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="http://cdn.breadhost.net/logo2.png">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>
<body>

<div class="container text-center">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>1timeFile</h2>
            <div class="didi"><p style="color: #fff;">load...</p></div>
        </div>
    </div>    
</div>

<div class="container text-center">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-3 col-xs-2">
                <button type="submit" class="btn btn-primary" onclick="document.location='/download/go/<?=$id?>'">Скачать файл</button>
            </div>
        </div>
    </div>    
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
function load2()
{
  $.ajax({
    url: '/get?do=1&id=<?=$id?>',
    success: function(data) {
      $('.didi').html(data);
    }
  });
}
$(document).ready ( function(){
 load2()
});
</script>
</body>
</html>