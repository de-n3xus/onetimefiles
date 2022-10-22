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
            <h5>Временное хранилище файлов</h5>
        </div>
    </div>    
</div>

<div class="container text-center">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-3 col-xs-1">
                <label for="js-file" class="mb-3"><i class="bx bxs-cloud-upload me-2 bx-sm"></i>Выберите файл</label>
                <center><input class="form-control" type="file" id="js-file" name="file" required style="width: 35%;"></center>
            </div>
            <div class="mb-3 col-xs-1">
                <p>Лимит загрузок</p>
                <center><input type="number" name="lim" class="text-primary text-center mb-1 form-control" id="lim" required style="width: 35%;"></center>
            </div>
            <div class="mb-3 col-xs-1">
                <button type="submit" class="btn btn-primary" onclick="submit()">Загрузить</button>
            </div>
            <div class="mb-3 col-xs-2">
                <div id="result"></div>
            </div>
        </div>
    </div>    
</div>

<script>
function submit(){
    if (window.FormData === undefined) {
        alert('В вашем браузере FormData не поддерживается');
    } else {
        var formData = new FormData();
        formData.append('lim', document.getElementsByName("lim")[0].value);
        formData.append('file', $("#js-file")[0].files[0]);

        $.ajax({
            type: "POST",
            url: '/upload',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            dataType : 'json',
            success: function(msg){
                if (msg.error == '') {
                    $('#result').html(msg.success);
                } else {
                    $('#result').html(msg.error);
                }
            }
        });
    }
}
</script>
</body>
</html>