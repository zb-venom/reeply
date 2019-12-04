<?php

session_start();

require_once "db/messages_db.php";
require_once "salt.php";

$login = $_SESSION['login'];
$cid =  $_POST['cid'];
$id_user = $_POST['id_user'];
$login_fd = $_POST['login_fd'];
$name = $_POST['name'];
$text = $_POST['text'];
$text = mysqli_real_escape_string($linkm, $text);
$text = str_replace('\n', '<br>', $text);
$text = preg_replace("/\s{2,}/"," ",$text);
$text = str_replace("&lt;br&gt;","<br>",$text);


if ((empty($text) || $text==' ') && empty( $_FILES['0']['name'])){ 
    exit();
}
if ($text=="[object HTMLTextAreaElement]")
    $text = "";
if(isset($_FILES['0']) && $_FILES['0']['name'] != '') {
	$salt = generateSalt();
	$_FILES['0']['name'] = $salt.$_FILES['0']['name'];
    $check = can_upload($_FILES['0']);
    
    if($check === true){
      // загружаем изображение на сервер
      make_upload($_FILES['0']);
    }
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $_FILES['0']['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// формируем уникальное имя картинки: случайное число и name
    $nameP = hash('md2', $_FILES['0']['name']).'.'.$mime;
  }
function can_upload($file){
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return $file['name'];
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
	
	return true;
  }
  
  function make_upload($file){	
	$path = '../img/';      
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// формируем уникальное имя картинки: случайное число и name
    $nameP = hash('md2', $file['name']).'.'.$mime;
	$targetPath = $path . $nameP;
	move_uploaded_file($file['tmp_name'], $targetPath);
  }


$text = bin2hex($text);
$sql = "INSERT INTO $cid (`id`, `id_user`, `name`, `text`, `date`, `file`) VALUES (NULL, $id_user, '$name', '$text', NOW(), '$nameP')";
$result = mysqli_query($linkm, $sql) or die("Ошибка " . mysqli_error($link));

$sql = "UPDATE `$login` SET `last_mes` = NOW() WHERE `$login`.`chat` = '$cid'";
$result = mysqli_query($linkm, $sql) or die("Ошибка " . mysqli_error($link));

$sql = "UPDATE `$login_fd` SET `last_mes` = NOW() WHERE `$login_fd`.`chat` = '$cid'";
$result = mysqli_query($linkm, $sql) or die("Ошибка " . mysqli_error($link));


?>