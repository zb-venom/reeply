<?php 
session_start();
require_once "db/posts_db.php";
require_once "db/messages_db.php";
$login = $_SESSION['login'];
$id = $_SESSION['id'];
require_once "db/db.php";
    if ($_POST['tab']=='friends')
    {
        $sqli = "SELECT * FROM $login WHERE readit=1";
        $resulti = mysqli_query($linkm, $sqli) or die("Ошибка " . mysqli_error($linkm));  
        $id_friend .= "WHERE id_user=".$id;
        while($rowi = mysqli_fetch_array($resulti)){
            $id_friend.= " OR id_user=".$rowi['id_friend'];
        }
        $sqli = "SELECT * FROM news $id_friend ORDER BY id DESC";
    }
    else if ($_POST['id']) {
        $idi = $_POST['id'];
        $sqli = "SELECT * FROM news WHERE id_user=$idi ORDER BY id DESC";
    }
    else
        $sqli = "SELECT * FROM news ORDER BY id DESC";
    $resulti = mysqli_query($linkp, $sqli) or die("Ошибка " . mysqli_error($linkp));
    $none = 0;
    while($rowi = mysqli_fetch_array($resulti)){
        $none++;
        $idi = $rowi['id_user'];
        $post_id = $rowi['id'];
        $sql3 = "SELECT * FROM users_about WHERE id_user=$idi";
        $result3 = mysqli_query($link, $sql3) or die("Ошибка " . mysqli_error($link));
        $row3 = mysqli_fetch_array($result3);
        $sql2 = "SELECT * FROM users WHERE id=$idi";
        $result2 = mysqli_query($link, $sql2) or die("Ошибка " . mysqli_error($link));
        $row2 = mysqli_fetch_array($result2);
        $photo = $row3['photo'];
        $text = hex2bin($rowi['text']);
        $text = str_replace('\"', '"', $text);
        $picture = $rowi['picture'];
        $date = $rowi['date'];
        date_default_timezone_set('Asia/Tomsk'); 
        $diff = strtotime (date("Y-m-d H:i:s")) - strtotime (date ("Y-m-d H:i:s", strtotime ($date)));
        if ($diff >= 86400){
            $_monthsList = array("-01" => "января", "-02" => "февраля", "-03" => "марта", "-04" => "апреля", "-05" => "мая", "-06" => "июня", "-07" => "июля", "-08" => "августа", "-09" => "сентября", "-10" => "октября", "-11" => "ноября", "-12" => "декабря");
            $_mD = date ("-m", strtotime ($date));
            $date = date ("d-m в H:m", strtotime ($date));
            $date = str_replace($_mD, " ".$_monthsList[$_mD], $date);
        }
        else                                             
            $date = date ("H:i", strtotime ($date));
        $s = "SELECT * FROM rating WHERE post_id=$post_id AND status=1";
        $sa = "SELECT * FROM rating WHERE post_id=$post_id AND status=1 AND user_id=$id";
        $r = mysqli_query($linkp, $s) or die("Ошибка " . mysqli_error($linkp));
        $ra = mysqli_query($linkp, $sa) or die("Ошибка " . mysqli_error($linkp));
        $like = mysqli_num_rows($r) !=0 ? mysqli_num_rows($r) : "";
        $la = mysqli_num_rows($ra) !=0 ? 'class="active"' : "";
        $s = "SELECT * FROM rating WHERE post_id=$post_id AND status=2";
        $sa = "SELECT * FROM rating WHERE post_id=$post_id AND status=2 AND user_id=$id";
        $r = mysqli_query($linkp, $s) or die("Ошибка " . mysqli_error($linkp));
        $ra = mysqli_query($linkp, $sa) or die("Ошибка " . mysqli_error($linkp));
        $dislike = mysqli_num_rows($r) !=0 ? mysqli_num_rows($r) : "";
        $da = mysqli_num_rows($ra) !=0 ? 'class="active"' : "";
        if (empty($photo)) $photo = "anon.png";
        echo '<div class="card" id="post" style="padding: 35px 35px 10px 35px;">  
                <div class="row">                           
                    <a href="page.php?id='.$idi.'"><img src="img/users/'.$photo.'" width="60px" height="60px" class="rounded-circle"  style="margin: 0px 10px;"></a>
                    <div class="col">
                        <a href="page.php?id='.$idi.'"><b>'.$rowi['name'].' &#183; </b></a>
                        <a href="page.php?id='.$idi.'"><i><small>@'.$row2['login'].' <b>&#183;</b> </small></i></a>
                        <a href="?post='.$rowi['id'].'"><small class="text-muted">'.$date.'</a></small>
                        <div>
                            <div class="card-body txt apple" style="margin-left: -20px; margin-top: -10px;">'; //word-wrap: break-word; word-break: break-all;
                if (empty($text) && !empty($picture)) echo '<i><small>'.$rowi['name'].' поделился(-ась) фотографией</small></i>'; 
                if (strlen($text) <= 300) echo '<h4>'.$text.'</h4>';                    
                else if (strlen($text) <= 600) echo '<h5>'.$text.'</h5>';  
                else echo '<h6>'.$text.'</h6>';
                            echo '</div></div></div></div>';
                if (!empty($picture))
                    { 
                        echo '<center><img src="img/'.$picture.'" width="550" style="margin-bottom: 20px; margin-top: -10px;"></center>';
                    }
                    echo '
                </div>
                <div class="card" style="background-color: white; border-top: 0px;">
                    <div style="margin-left: auto; margin-right: auto; padding: 5px;">
                    <a href="javascript:;" id="'.$post_id.'" '.$la.' onclick="like(this.id)"><i class="fa fa-thumbs-up"></i> '.$like.'</a>
                    <a href="javascript:;" id="'.$post_id.'" '.$da.' onclick="dislike(this.id)"><i class="fa fa-thumbs-down"></i> '.$dislike.'</a>';
                    if ($idi === $_SESSION['id']) echo '<a href="javascript:;" id="'.$post_id.'" onclick="delete_post(this.id)">&nbsp;<i class="fa fa-trash"></i></a>';
        echo '</div></div>
        <div style="background-color: white;"><br></div>';
    }
    if($none == 0) {
        echo '<div class="card" style="padding: 35px;">  
                <img src="img/empty.png" width="30%" height="30%" style="margin-left: auto; margin-right:auto;">
                </div>'; 

    }

?>
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
