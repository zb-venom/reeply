<?php 

session_start();

date_default_timezone_set('Asia/Tomsk'); 

if (!$_SESSION["online"]) {
    header('Location: /index.php ');
}

$login = $_SESSION['login'];
$name = $_SESSION['name'];
$id = $_SESSION['id'];


require_once "/actions/db/db.php";
require_once "/actions/db/messages_db.php";
$sql = "SELECT * FROM users WHERE login='$login'";
$result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
$myrow = mysqli_fetch_array($result);
$user_status = $myrow['status'];

$sqli = "SELECT * FROM users_about WHERE id_user='$id'";
$resulti = mysqli_query($link, $sqli) or die("Ошибка " . mysqli_error($link));
$myrowi = mysqli_fetch_array($resulti);
$dof = $myrowi['dof'];
$_monthsList = array("-01-" => "января", "-02-" => "февраля", 
"-03-" => "марта", "-04-" => "апреля", "-05-" => "мая", "-06-" => "июня", 
"-07-" => "июля", "-08-" => "августа", "-09-" => "сентября",
"-10-" => "октября", "-11-" => "ноября", "-12-" => "декабря");
$_mD = date("-m-", strtotime ($dof));
$dof = str_replace($_mD, " ".$_monthsList[$_mD]." ", $dof);
$country = $myrowi['country'];
$city = $myrowi['city'];
$sqlr = "SELECT * FROM $login WHERE readme=1";
$resultr = mysqli_query($linkm, $sqlr) or die("Ошибка " . mysqli_error($link));
$readers = mysqli_num_rows($resultr);
$sqlr = "SELECT * FROM $login WHERE readit=1";
$resultr = mysqli_query($linkm, $sqlr) or die("Ошибка " . mysqli_error($link));
$read = mysqli_num_rows($resultr);
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Neucha&display=swap" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="lib/emoji-picker/lib/css/emoji.css" rel="stylesheet">
        <link rel="stylesheet" media="screen,projection" href="css/bootstrap.css">  
        <link rel="stylesheet" media="screen,projection" href="css/main.css">
		<link href="/lib/jquery-emoji/css/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="/img/logo.png" type="image/png">
    </head>
    <body><div class="container">
            <div class="row">    
                <?php require_once 'left_menu.php';?>
                <div class="col" id="content" style="padding-left: 0; padding-right: 0; max-width: 975px; width: 975px; min-width: 500px;">
                    <div class="card">
                        <div class="card-header">
                            <div class="row" style="margin-left: -45px;"> 
                                <div class="col-2"><a href="news.php"><button class="btn" style="margin: -5px 10px;" disabled><img src="https://img.icons8.com/wired/64/000000/back.png" width="30px" height="30px"> Назад</button></a></div>
                                <div class="col-10" style="margin-left: -15px;"><h4><b><?echo $name?></b></h4></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <button type="button" class="btn new-photo" data-toggle="modal" data-target=".bd-example-modal-lg"><img src="img/users/<?php if(empty($myrowi['photo'])) echo 'anon.png'; else echo $myrowi['photo'];?>" width="200px" height="200px" class="rounded-circle" ></button>
                                </div>
                                <div class="col-3"> 
                                    <p>Логин:</p>
                                    <p>Страна, город:</p>                                    
                                    <p>Читателей:</p>
                                    <p>Читатает:</p>
                                    <p>Последняя активность:</p>
                                </div>                                
                                <div class="col-6">
                                    <p>@<?echo $login;?></p>
                                    <p><i><?echo $myrowi['country']; echo ", ".$myrowi['city'];?></i></p>
                                    <p><?echo $readers;?></p>
                                    <p><?echo $read;?></p>
                                    <?php 
                                        date_default_timezone_set('Asia/Tomsk'); 
                                        $diff = strtotime (date("H:i")) - strtotime (date ("H:i", strtotime ($user_status)));
                                        if ($diff >= -120 && $diff <= 120) {echo '
                                        <div class="row">
                                            <div class="col-1">
                                                <div id="circle" style="margin-top: 5px;"></div>
                                            </div>
                                            <i style="margin-left: -5px;">online</i>
                                        </div>';} else {
                                            echo '<i style="font-size: 13px;">был(-а) в сети ';
                                            echo date ("H:i", strtotime ($user_status));
                                            echo '</i>';  
                                        }?> <p></p>  
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 style="color: rgb(95, 202, 238);"><b>Мои мысли</b></h4>
                        </div>
                    </div>
                    <div id="Dok"></div>
                </div>
            </div>
        </div>
        <form action="actions/new_photo.php" method="post" enctype="multipart/form-data">
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Изменить фотографию</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <center>Загружайте только фотграфии 1:1</center>
                            <center id="btn"><span class="btn btn-primary btn-file">Выбрать<input type="file" name="photoInput" onchange="readURL(this);"></span></center><br>                                
                            <center id="imgOp">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="lib/emoji-picker/lib/js/config.js"></script>
        <script src="lib/emoji-picker/lib/js/util.js"></script>
        <script src="lib/emoji-picker/lib/js/jquery.emojiarea.js"></script>
        <script src="lib/emoji-picker/lib/js/emoji-picker.js"></script>
        <script src="/lib/jquery-emoji/js/jQueryEmoji.js"></script>
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
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        imgOp.innerHTML= '<img id="img" src="#" width="600"></center>';
                        $('#img')
                            .attr('src', e.target.result)
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            update();
            setInterval("update()", 300000);

            function update() {
                $.post("/actions/activity.php?status=1");
            }   
            check_posts();
            setInterval("check_posts()", 1000000);
            function check_posts() {
                $.ajax({
                url:"actions/check_posts.php",
                method:"POST",
                data:"id=<?php echo $id;?>"
                }).done(function(data){
                    $('#Dok').html(data);
                })

            }
        </script>
        <script src="js/bootstrap.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>