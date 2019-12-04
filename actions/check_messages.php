<?php 
require_once "/db/messages_db.php";
require_once "/db/db.php";
        session_start();
        $chat = $_GET['chat'];
        $id = $_SESSION['id'];
        $sqli = "SELECT * FROM $chat";
        $resulti = mysqli_query($linkm, $sqli) or die("Ошибка " . mysqli_error($linkm));
        $temp_id = 0;
        $full = '<div class="txt apple">';
        while($rowi = mysqli_fetch_array($resulti)){
            if ($rowi['read'] == 0) {
                $sqli = "UPDATE $chat SET `read` = 1 WHERE id_user != $id";
                mysqli_query($linkm, $sqli) or die("Ошибка " . mysqli_error($linkm));
            }
            $text = hex2bin($rowi['text']);
            $text = str_replace('\"', '"', $text);
            if (!empty($rowi['file']))
                $full .= '<center><img src="img/'.$rowi['file'].'" width="700" style="margin-bottom: 20px; margin-top: -10px;"></center>';
            if($rowi['id_user'] === $temp_id) {
                date_default_timezone_set('Asia/Tomsk'); 
                $diff = strtotime ($date) - strtotime ($rowi['date']);
                if ($diff < -1000 && !empty($text)) {                    
                    $date = $rowi['date']; 
                    date_default_timezone_set('Asia/Tomsk'); 
                    $diff = strtotime (date("Y-m-d H:i:s")) - strtotime (date ("Y-m-d H:i:s", strtotime ($date)));
                    if ($diff >= 86400){
                        $_monthsList = array("-01" => "января", "-02" => "февраля", 
                        "-03" => "марта", "-04" => "апреля", "-05" => "мая", "-06" => "июня", 
                        "-07" => "июля", "-08" => "августа", "-09" => "сентября",
                        "-10" => "октября", "-11" => "ноября", "-12" => "декабря");
                        $_mD = date("-m", strtotime ($date));
                        $date = date ("d-m в H:m", strtotime ($date));
                        $date = str_replace($_mD, " ".$_monthsList[$_mD], $date);
                    }
                    else                                             
                        $date = date ("H:i", strtotime ($date));
                    $full .= '<br><div class="row justify-content-between"><div class="col-1"><a href="page.php?id='.$idi.'"><img src="img/users/'.$photo.'" width="65px" height="65px" class="rounded-circle"></a></div><div class="col-9"><a href="page.php?id='.$idi.'"><b>'.$rowi['name'].'</b></a></div><div class="col-2" style="text-align: right;"><i style="font-size: 12px;">'.$date.'</i></div></div><p style="margin-left: 77px; margin-top: -40px;"  class="txt apple">'.$text.'</p>';
                }
                else
                    $full .= '<p style="margin-left: 77px;" class="txt apple">'.$text.'</p>';
            }
            else {
                $idi = $rowi['id_user'];
                $sql3 = "SELECT * FROM users_about WHERE id_user=$idi";
                $result3 = mysqli_query($link, $sql3) or die("Ошибка " . mysqli_error($link));
                $row3 = mysqli_fetch_array($result3);
                $date = $rowi['date']; 
                date_default_timezone_set('Asia/Tomsk'); 
                $diff = strtotime (date("Y-m-d H:i:s")) - strtotime (date ("Y-m-d H:i:s", strtotime ($date)));
                if ($diff >= 86400){
                    $_monthsList = array("-01" => "января", "-02" => "февраля", 
                    "-03" => "марта", "-04" => "апреля", "-05" => "мая", "-06" => "июня", 
                    "-07" => "июля", "-08" => "августа", "-09" => "сентября",
                    "-10" => "октября", "-11" => "ноября", "-12" => "декабря");
                    $_mD = date("-m", strtotime ($date));
                    $date = date ("d-m в H:m", strtotime ($date));
                    $date = str_replace($_mD, " ".$_monthsList[$_mD], $date);
                }
                else                                             
                    $date = date ("H:i", strtotime ($date));
                $photo = $row3['photo'];
                if (empty($photo)) $photo = "anon.png";
                $full .= '<br><div class="row justify-content-between"><div class="col-1"><a href="page.php?id='.$idi.'"><img src="img/users/'.$photo.'" width="65px" height="65px" class="rounded-circle"></a></div><div class="col-9"><a href="page.php?id='.$idi.'"><b>'.$rowi['name'].'</b></a></div><div class="col-2" style="text-align: right;"><i style="font-size: 12px;">'.$date.'</i></div></div><p style="margin-left: 77px; margin-top: -40px;" class="txt apple">'.$text.'</p>';
            }
            $temp_id = $rowi['id_user'];
        }
        echo $full.'</div>';
?>