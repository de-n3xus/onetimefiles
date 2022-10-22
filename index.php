<?
require_once("{$_SERVER['DOCUMENT_ROOT']}/app/router.php");

any('/', '/app/public/main.php');
any('/index', '/app/public/main.php');
any('/main', '/app/public/main.php');
any('/download', '/app/public/main.php');
any('/download/$id', '/app/public/download.php');
any('/download/go/$id', '/app/modules/download.php');

any('/upload', '/app/modules/upload.php');
any('/get', '/app/public/get.php');

any('/test', '/app/public/test.php');

any('/404', '/app/public/404.php');
