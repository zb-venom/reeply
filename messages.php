<?php

session_start();

if (!$_SESSION["online"]) {
    header('Location: /index.php ');
}

$login = $_SESSION['login'];
$id = $_SESSION['id'];
$chat = $_GET['chat'];

require_once "/actions/db/db.php";
require_once "/actions/db/messages_db.php";

if (!empty($chat)) {      
    $pagem = true;                                                  
    $sql = "SELECT * FROM $login WHERE chat='$chat'";
    $result = mysqli_query($linkm, $sql) or die("Ошибка " . mysqli_error($link));
    $row = mysqli_fetch_array($result);
    if (empty($row['id'])) {        
        header('Location: /404.php ');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reeply</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Underdog" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href="lib/emoji-picker/lib/css/emoji.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css">  
		<link href="lib/jquery-emoji/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <link rel="shortcut icon" href="/img/logo.png" type="image/png">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="lib/emoji-picker/lib/js/config.js"></script>
        <script src="lib/emoji-picker/lib/js/util.js"></script>
        <script src="lib/emoji-picker/lib/js/jquery.emojiarea.js"></script>
        <script src="lib/emoji-picker/lib/js/emoji-picker.js"></script>
        <script src="/lib/jquery-emoji/js/jQueryEmoji.js"></script>
    </head>
    <body class="scroll" id="mess" style="padding: 0px;">
        <div class="container">                
            <div class="row">                   
                <?php require_once 'left_menu.php';
                if ($pagem) require_once 'mes_page.php';
                else require_once 'mes_list.php';
                ?>
            </div>
        </div>
        <script>
            $(function() {
                $('.apple').Emoji({
                    path:  'lib/jquery-emoji/img/apple40/',
                    class: 'emoji',
                    ext:   'png'
                });
            });
            update();
            setInterval("update()", 10000);
            function update() { $.post("/actions/activity.php?status=1"); }         
            document.getElementById("hide").onclick = function () { left(); };
            function left() {
                if(dis0.innerHTML!=""){ 
                    document.getElementById("left_menu").style.width = "75px"; 
                    document.getElementById("content").style.width = "1125px"; 
                    document.getElementById("content").style.maxWidth = "1125px"; 
                    dis0.innerHTML = "";           
                    dis1.innerHTML = "";           
                    dis2.innerHTML = "";           
                    dis3.innerHTML = "";           
                    dis4.innerHTML = "";           
                    dis5.innerHTML = "";           
                    dis6.innerHTML = "";        
                    dis7.innerHTML = "";
                } else {
                    document.getElementById("left_menu").style.width = "225px"; 
                    document.getElementById("content").style.width = "975px";
                    document.getElementById("content").style.maxWidth = "975px";            
                    dis0.innerHTML = "eeply<i style='font-size: 15px; margin-left: -7px;'>inc.</i>"; 
                    dis1.innerHTML = "Новости";           
                    dis2.innerHTML = "Профиль";           
                    dis3.innerHTML = "Сообщения";           
                    dis4.innerHTML = "Настройки";           
                    dis5.innerHTML = "Сервисы";           
                    dis6.innerHTML = "Выход";       
                    dis7.innerHTML = "Скрыть";
                }
            }         
        </script>
    </body>
</html>