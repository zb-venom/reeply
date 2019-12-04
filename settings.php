<?php 

session_start();
if (!$_SESSION["online"]) {
    header('Location: /index.php ');
}
$photo = $_SESSION['photo'];
if (empty($photo)) $photo = "anon.png";
$name = $_SESSION['name'];
$login = $_SESSION['login'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Настройки</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Neucha&display=swap" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="lib/emoji-picker/lib/css/emoji.css" rel="stylesheet">
        <link rel="stylesheet" media="screen,projection" href="css/bootstrap.css">  
        <link rel="stylesheet" media="screen,projection" href="css/main.css">
		<link href="/lib/jquery-emoji/css/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="/img/logo.png" type="image/png">
    </head>
    <body class="scroll" style="padding: 0px;">
        <div class="container">
            <div class="row">    
                <?php require_once 'left_menu.php';?>
                <div class="col" id="content" style="padding-left: 0; padding-right: 0; max-width: 675px; width: 675px; min-width: 500px;">
                    <div class="card">
                        <div class="card-header">
                            <div class="row" style="margin-left: 5px;">                           
                                <div class="spinner-grow" style="color: rgb(14, 143, 143);" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <h4><b>&#8194;Настройки</b></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="/actions/new_password.php" method="POST" class="was-validated">
                                <?php if ($_GET['error']==22) echo '<p class="error">Пароли не совпадают. Повторите попытку.</p>'; 
                                if ($_GET['error']==11) echo '<p class="error">Некорректные данные. Повторите попытку.</p>'; 
                                if ($_GET['error']==44) echo '<p class="error">Старый пароль введён не верно.</p>'; 
                                if ($_GET['error']==33) echo '<p class="error">Новый пароль не должен совпадать со старым.</p>'; 
                                if ($_GET['error']==200) echo '<p class="success">Пароль успешно изменён!</p>'; 
                                ?>
                                <h5 class="card-title">Изменить пароль</h5>
                                <p></p>
                                <input class="btn btn-rep form-control is-invalid" type="password" name="passOld" placeholder="Старый пароль" required> 
                                <p></p>
                                <input class="btn btn-rep form-control is-invalid" type="password" name="passInput" placeholder="Повторите пароль" required> 
                                <p></p>
                                <input class="btn btn-rep form-control is-invalid" type="password" name="passInput2" placeholder="Повторите пароль" required> 
                                <p></p>
                                <button class="btn btn-success">Продолжить</button>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div>          
        <div id="top"><small style="position: fixed; top: 5%; left: 18px">Наверх</small></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="lib/emoji-picker/lib/js/config.js"></script>
        <script src="lib/emoji-picker/lib/js/util.js"></script>
        <script src="lib/emoji-picker/lib/js/jquery.emojiarea.js"></script>
        <script src="lib/emoji-picker/lib/js/emoji-picker.js"></script>
        <script src="/lib/jquery-emoji/js/jQueryEmoji.js"></script>
        <script>
        // Google Analytics
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-49610253-3', 'auto');
        ga('send', 'pageview');
        </script>
        <script>
            $(function() {
                // Initializes and creates emoji set from sprite sheet
                window.emojiPicker = new EmojiPicker({
                emojiable_selector: '[data-emojiable=true]',
                assetsPath: 'lib/emoji-picker/lib/img/',
                popupButtonClasses: 'fa fa-smile-o'
                });
                // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
                // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
                // It can be called as many times as necessary; previously converted input fields will not be converted again
                window.emojiPicker.discover();

                $('.apple').Emoji({
                    path:  'lib/jquery-emoji/img/apple40/',
                    class: 'emoji',
                    ext:   'png'
                });
            });
        </script>
        <script> 
            update();
            setInterval("update()", 300000);
            function update() {
                $.post("/actions/activity.php?status=1");
            } 
            var top_show = 150; // В каком положении полосы прокрутки начинать показ кнопки "Наверх"
            var delay = 1000; // Задержка прокрутки
            $(document).ready(function() {
                document.getElementById("content").style.height = window.innerHeight;
                $(window).scroll(function () { // При прокрутке попадаем в эту функцию
                /* В зависимости от положения полосы прокрукти и значения top_show, скрываем или открываем кнопку "Наверх" */
                if ($(this).scrollTop() > top_show) $('#top').fadeIn();
                else $('#top').fadeOut();
                });
                $('#top').click(function () { // При клике по кнопке "Наверх" попадаем в эту функцию
                /* Плавная прокрутка наверх */
                $('body, html').animate({
                    scrollTop: 0
                }, delay);
                });
            });
        </script>
        <script src="js/main.js"></script>
    </body>
</html>