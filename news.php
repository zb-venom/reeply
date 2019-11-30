<?php 

session_start();
if (!$_SESSION["online"]) {
    header('Location: /index.php ');
}
$photo = $_SESSION['photo'];
if (empty($photo)) $photo = "anon.png";
$name = $_SESSION['name'];
$login = $_SESSION['login'];
$tab = $_GET['tab'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Новости</title>
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
                                <h4><b>&#8194;Новости</b></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="boxm" style="background-color: lightgray; border: 0px">                        
                        <div class="" style="padding: 0px;">
                            <div class="card" style="padding: 35px;  border-top: 0px">  
                                <form action="actions/new_post.php" method="post" enctype="multipart/form-data">
                                    <div class="row">                           
                                        <img src="img/users/<?php echo $photo; ?>" width="60px" height="60px" class="rounded-circle"  style="margin: 0px 10px;">
                                        <div class="col-10">
                                            <p class="lead emoji-picker-container">
                                                <textarea maxlength="1024" id="text" name="text" class="form-control textarea-control" 
                                                          rows="4" placeholder="Есть чем поделиться?" data-emojiable="true"></textarea>
                                            </p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row justify-content-between">
                                        <div class="col-2">
                                        <label style="width:40px; height:40px; cursor: pointer;">
                                            <input id="file" type="file" name="file" style="outline:0;opacity:0;pointer-events:none;user-select:none;" accept=".jpg, .jpeg, .png">
                                            <img src="img/img.png" style="margin-top: -45px;" width="40px" height="40px">    
                                        </label>
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-outline-secondary" type="button" id="send" style="border-radius: 30px;">Отправить</button>
                                        </div>
                                    </div>
                                </form>
                            </div>  
                            <div style="background-color: white;"><br></div>
                            <div id="Dok"></div> 
                        </div>
                    </div>
                </div>                
                <div class="card" id="right" style="padding-left: 0; padding-right: 0; border: 0px;  max-width: 350px; width: 350px; min-width: 0px;">
                    <?php require_once 'right_menu.php';?>
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
        function delete_post(post_id) {
            $.ajax({
                url:"actions/delete_post.php",
                method:"POST",
                data:{post_id: post_id}
                })
            check_posts();
        }
        function like(post_id) {
            $.ajax({
                url:"actions/like.php",
                method:"POST",
                data:{post_id: post_id}
                })
            check_posts();
        }
        function dislike(post_id) {
            $.ajax({
                url:"actions/dislike.php",
                method:"POST",
                data:{post_id: post_id}
                })
            check_posts();
        }
        $('#text').keydown(function (e) {
            if (e.ctrlKey && e.keyCode == 13) {
                send();
            }
        });
        document.getElementById("send").onclick = function() { 
            send(); 
        };
        function send_solo() {
        text = document.getElementById("text").value;
        text = text.replace(/ {1,}/g," ");
        text = text.replace(/\n+$/g,'\n');
        $.post("/actions/new_post.php", 
        {
            id_user: <?php echo $id;?>,
            name: "<?php echo $name; ?>",
            text: text
        });
        document.getElementById("text").value = "";
        $('.emoji-wysiwyg-editor').html("");
        check_posts();
        setTimeout(check_posts, 1000);
        };
    var files;
    $('input[type=file]').on('change', function(){
        files = this.files;
    });

    function send() { 
        // ничего не делаем если files пустой
        if( typeof files == 'undefined' ) { send_solo();}
        else {
        // создадим объект данных формы
        var data = new FormData();

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each( files, function( key, value ){
            data.append( key, value );
        });

        // добавим переменную для идентификации запроса
        data.append( 'my_file_upload', 1 );
        data.append('id_user', <?php echo $id;?>);
        data.append('login_fd', "<?php echo $login_fd; ?>");
        text = document.getElementById("text").value;
        text = text.replace(/ {1,}/g," ");
        text = text.replace(/\n+/g,'\n');
        data.append('text', text);
        $.ajax({
            url: "/actions/new_post.php",
            type: 'POST',
            data: data,
            cache       : false,
		    dataType    : 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData : false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType : false, 
            // функция успешного ответа сервера
            success     : function( respond, status, jqXHR ){

                // ОК - файлы загружены
                if( typeof respond.error === 'undefined' ){
                    // выведем пути загруженных файлов в блок '.ajax-reply'
                    var files_path = respond.files;
                    var html = '';
                    $.each( files_path, function( key, val ){
                        html += val +'<br>';
                    } )

                    $('.ajax-reply').html( html );
                }
                // ошибка
                else {
                    console.log('ОШИБКА: ' + respond.error );
                }
            },
            // функция ошибки ответа сервера
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }

        });
        check_posts();
        setTimeout(check_posts, 1000);
        document.getElementById("text").value = "";
        $('.emoji-wysiwyg-editor').html("");
        $("#file").val('');
        }
    };
            function left() {
                if(dis0.innerHTML!=""){ 
                    right.innerHTML = "";
                    document.getElementById("left_menu").style.width = "75px"; 
                    document.getElementById("right").style.width = "0px"; 
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
                    $.post("right_menu.php", function( data ) {
                        right.innerHTML = data;
                        });
                    document.getElementById("left_menu").style.width = "225px"; 
                    document.getElementById("right").style.width = "350px"; 
                    document.getElementById("content").style.width = "675px";
                    document.getElementById("content").style.maxWidth = "675px"; 
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
            document.getElementById("hide").onclick = function () {left();};
            check_posts();
            setInterval("check_posts()", 1000000);
            function check_posts() {
                $.ajax({
                url:"actions/check_posts.php",
                method:"POST",
                data:"tab=<?php echo $_GET['tab'];?>"
                }).done(function(data){
                    $('#Dok').html(data);
                })

            }
            update();
            setInterval("update()", 10000);
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