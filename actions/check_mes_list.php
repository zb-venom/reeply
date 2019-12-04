    
                            <?php 
                                session_start();
                                require_once "/db/db.php";
                                require_once "/db/messages_db.php";
                                $login = $_SESSION['login'];
                                $search = $_POST['search'];
                                $id = $_SESSION['id'];
                                if (empty($search)){
                                    $sql = "SELECT * FROM $login ORDER BY last_mes DESC";
                                    $result = mysqli_query($linkm, $sql) or die("Ошибка " . mysqli_error($link));  
                                    while ($row = mysqli_fetch_array($result)) {
                                        $chat = $row['chat'];  
                                        $sql2 = "SELECT * FROM $chat ORDER BY id DESC";   
                                        $result2 = mysqli_query($linkm, $sql2) or die("Ошибка " . mysqli_error($link));  
                                        $row2 = mysqli_fetch_array($result2);
                                        $idi = $row['id_friend'];
                                        $sql3 = "SELECT * FROM users_about WHERE id_user=$idi";
                                        $result3 = mysqli_query($link, $sql3) or die("Ошибка " . mysqli_error($link));
                                        $row3 = mysqli_fetch_array($result3);
                                        $photo = $row3['photo'];
                                        $date = $row2['date']; 
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
                                        if (empty($row2['text']) && empty($row2['file'])) {continue;}
                                        if (!empty($row2['file'])) $text = "<i><b>Файл</b></i>";
                                        else {                                   
                                            $text = $row2['text'];
                                            $text = hex2bin($text); 
                                            $text = str_replace('<br>', ' ', $text);
                                            $text = str_replace('\"', '"', $text);
                                            if (strlen($text) >= 120){
                                                $text = substr($text,0,120);
                                                $text .= "...";
                                            }
                                        } 
                                        $read = "white";
                                        if ($row2['id_user'] === $id){
                                            if ($row2['read'] == 0)
                                                $text = "<i>Вы: ".$text."</i><span style='height: 10px; width: 10px; background-color: lightblue; border-radius: 50%; display: inline-block; top: 40px; right: 20px; position: absolute'></span>";
                                            else
                                                $text = "<i>Вы: ".$text."</i>";
                                        }
                                        else {
                                            if ($row2['read'] == 0){
                                                $sqlr = "SELECT * FROM $chat WHERE `read` = 0";   
                                                $resultr = mysqli_query($linkm, $sqlr) or die("Ошибка " . mysqli_error($link));  
                                                $num = mysqli_num_rows($resultr);
                                                $text .= "<span class='badge-pill badge-primary' style='right: 15px; position: absolute'><small>".$num."</small></span>";
                                                $read = "rgb(241, 241, 241)";
                                            }
                                        }
                                        if (empty($photo)) $photo = "anon.png";
                            printf('<a href="messages.php?chat=%s" class="list-group-item list-group-item-action" style="border-radius: 0 0 0 0; background-color: %s">   
                                        <div class="row">                             
                                            <img src="img/users/%s" width="60px" height="60px" class="rounded-circle"  style="margin-left: 10px;">
                                            <div class="col">
                                                <div class="d-flex w-100 justify-content-between" style="margin-top: 10px;">
                                                    <b>%s</b>
                                                    <small class="text-muted">%s</small>
                                                </div>
                                                <p class="txt apple">%s</p>
                                            </div>
                                        </div>
                                    </a>',
                                        $chat, $read, $photo, $row['name'], $date, $text);}
                                } else {
                                    $sql = "SELECT * FROM $login ORDER BY last_mes DESC";
                                    $result = mysqli_query($linkm, $sql) or die("Ошибка " . mysqli_error($link));  
                                    while ($row = mysqli_fetch_array($result)) {
                                        $search = mb_strtolower($search);
                                        $sername = mb_strtolower($row['name']);
                                        if(stristr($sername, $search) === FALSE) {
                                            continue;
                                        }
                                        $chat = $row['chat'];  
                                        $sql2 = "SELECT * FROM $chat ORDER BY id DESC";   
                                        $result2 = mysqli_query($linkm, $sql2) or die("Ошибка " . mysqli_error($link));  
                                        $row2 = mysqli_fetch_array($result2);
                                        $idi = $row['id_friend'];
                                        $sql3 = "SELECT * FROM users_about WHERE id_user=$idi";
                                        $result3 = mysqli_query($link, $sql3) or die("Ошибка " . mysqli_error($link));
                                        $row3 = mysqli_fetch_array($result3);
                                        $photo = $row3['photo'];
                                        $date = $row2['date']; 
                                        date_default_timezone_set('Asia/Tomsk'); 
                                        $diff = strtotime (date("Y-m-d H:i:s")) - strtotime (date ("Y-m-d H:i:s", strtotime ($date)));
                                        if ($diff >= 86400){
                                            $_monthsList = array("-01" => "января", "-02" => "февраля", 
                                            "-03" => "марта", "-04" => "апреля", "-05" => "мая", "-06" => "июня", 
                                            "-07" => "июля", "-08" => "августа", "-09" => "сентября",
                                            "-10" => "октября", "-11" => "ноября", "-12" => "декабря");
                                            $_mD = date("-m", strtotime ($date));
                                            $date = date ("d-m", strtotime ($date));
                                            $date = str_replace($_mD, " ".$_monthsList[$_mD]." ", $date);
                                        }
                                        else                                             
                                            $date = date ("H:i", strtotime ($date));
                                        if (!empty($row2['file'])) $text = "<i><b>Файл</b></i>";
                                        else {                                   
                                            $text = $row2['text'];
                                            $text = hex2bin($text); 
                                            $text = str_replace('<br>', ' ', $text);
                                            $text = str_replace('\"', '"', $text);
                                            if (strlen($text) >= 120){
                                                $text = substr($text,0,120);
                                                $text .= "...";
                                            }
                                        } 
                                        $read = "white";
                                        if ($row2['id_user'] === $id){
                                            if ($row2['read'] == 0)
                                                $text = "<i>Вы: ".$text."</i><span style='height: 10px; width: 10px; background-color: lightblue; border-radius: 50%; display: inline-block; top: 40px; right: 40px; position: absolute'></span>";
                                            else
                                                $text = "<i>Вы: ".$text."</i>";
                                        }
                                        else {                                            
                                            if (empty($row2['text'])) {
                                                $text = "<i><small>У Вас пока нет сообщений с этим пользователем</small></i>";
                                                $date = "";
                                            }
                                            else if ($row2['read'] == 0){
                                                $sqlr = "SELECT * FROM $chat WHERE `read` = 0";   
                                                $resultr = mysqli_query($linkm, $sqlr) or die("Ошибка " . mysqli_error($link));  
                                                $num = mysqli_num_rows($resultr);
                                                $text = "<span class='badge-pill badge-primary' style='right: 15px; position: absolute'><small>".$num."</small></span>";
                                                $read = "rgb(241, 241, 241)";
                                            }
                                        }
                                        if (empty($photo)) $photo = "anon.png";
                            printf('<a href="messages.php?chat=%s" class="list-group-item list-group-item-action" style="border-radius: 0 0 0 0;">   
                                        <div class="row">                             
                                            <img src="img/users/%s" width="60px" height="60px" class="rounded-circle"  style="margin-left: 10px;">
                                            <div class="col">
                                                <div class="d-flex w-100 justify-content-between" style="margin-top: 10px;">
                                                    <b>%s</b>
                                                    <small class="text-muted">%s</small>
                                                </div>
                                                <p class="txt apple" id=text>%s</p>
                                            </div>
                                        </div>
                                    </a>',
                                        $chat, $photo, $row['name'], $date, $text);}
                                }
                                
                                    ?> 