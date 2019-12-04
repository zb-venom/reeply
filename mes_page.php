<div class="col" id="content" style="padding-left: 0;  border-radius: 0 0 10px 10px;  padding-right: 0; max-width: 975px; width: 975px; min-width: 500px;">
    <?php
    
    date_default_timezone_set('Asia/Tomsk'); 
    $name_fd = $row['name'];
    $name = $_SESSION['name'];
    $idi = $row['id_friend'];
    $id = $_SESSION['id'];
    $chat = $_GET['chat'];
    $sql2 = "SELECT * FROM users WHERE id='$idi'";
    $result2 = mysqli_query($link, $sql2) or die("Ошибка " . mysqli_error($link));
    $row2 = mysqli_fetch_array($result2);
    $login_fd = $row2['login'];

    $friend_status = $row2['status'];
    $diff = strtotime (date("H:i")) - strtotime (date ("H:i", strtotime ($friend_status))); 
    
    $sql3 = "SELECT * FROM users_about WHERE id_user=$idi";
    $result3 = mysqli_query($link, $sql3) or die("Ошибка " . mysqli_error($link));
    $row3 = mysqli_fetch_array($result3);
    $photo = $row3['photo'];
    if (empty($photo)) $photo = "anon.png";
    printf('
    <div class="card" id="boxm" style="border-radius: 0 0 10px 10px; ">
        <div class="card">
            <div class="card-header">
                <div class="row"">                    
                    <div class="col-2">
                        <d class="btn" style="margin: 0px -10px; z-index: 1;"><a href="messages.php" style="z-index: 2; text-decoration: none;"><img src="https://img.icons8.com/wired/64/000000/back.png" width="30px" height="30px"> Назад</a></d>                               
                    </div>
                    <div class="col-8" style="margin-top: -15px">
                        <a href="page.php?id=%s"><button class="btn btn-block" disabled><b>%s</b></button></a>', $idi, $name_fd);                               
                        if ($diff >= -120 && $diff <= 120) echo '
                        <div class="row justify-content-center" style="margin-top: -10px;">
                            <div id="circle" style="margin-right: 10px;"></div>
                            <i  style="margin-top: 3px;">online</i>
                        </div>'; else echo '
                        <div class="row justify-content-center">
                            <i style="font-size: 13px;">был(-а) в сети '.date ("H:i", strtotime ($friend_status)).'</i>
                        </div>';
                        ?>
                    </div>
                    <div class="col-2" style="margin-top: -5px">
                        <div class="row justify-content-center">
                            <a href="page.php?id=<?php echo $idi;?>"><img src="img/users/<?php echo $photo;?>" width="45px" height="45px" class="rounded-circle"></a>  
                        </div>                        
                    </div>                
                </div>
            </div>                
        </div>
            <div class="scroll" id="scroll" style="margin-right: auto; margin-left: auto; margin-bottom: auto; width: 100%;"> 
                <div id="Dok" class="txt apple"></div>
            </div>
            <div class="row" style="padding-left: 20px; margin: 0px; border-top: solid 1px lightgrey; border-radius: 0 0 10px 10px; padding-top: 10px; background-color: rgba(0, 0, 0, 0.08);">                      
                <div class="col">
                    <p class="lead emoji-picker-container">
                    <textarea autofocus placeholder="Введите сообщение" maxlength="1024" id="text" name="text" 
                          class="form-control textarea-control" rows="4" data-emojiable="true"></textarea>
                    </p>
                </div>
                <div style="width: 150px;">
                    <label style="width:40px; height:40px; cursor: pointer;">
                        <input id="file" type="file" name="file" style="outline:0;opacity:0;pointer-events:none;user-select:none;" accept=".jpg, .jpeg, .png">
                        <img src="img/img.png" style="margin-top: -45px;" width="40px" height="40px">    
                    </label>
                    <button class="btn btn-outline-secondary" type="button" id="send" style="border-radius: 30px; margin-top: 18px;">Отправить</button>
                </div>
            </div>
        </div>
    </div>
</div>
<s<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="lib/emoji-picker/lib/js/config.js"></script>
<script src="lib/emoji-picker/lib/js/util.js"></script>
<script src="lib/emoji-picker/lib/js/jquery.emojiarea.js"></script>
<script src="lib/emoji-picker/lib/js/emoji-picker.js"></script>
<script>
    document.addEventListener('keydown', sendBotton);
    function sendBotton(event) {
        if (event.ctrlKey && event.keyCode == 13) {
            send();
            setTimeout(function(){
                scrollToBottom();
            }, 500);
        }
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
        
    });
    setTimeout(function(){
        scrollToBottom();
    }, 1000);
    function scrollToBottom(){
        var div = document.getElementById("scroll");
        div.scrollTop = div.scrollHeight - div.clientHeight;
    }
    resize()
    document.getElementsByTagName("BODY")[0].onresize = function() {resize()};
    function resize() {
        boxm.style.height=$(window).height()+"px";
    }
    var files; // переменная. будет содержать данные файлов
    // заполняем переменную данными, при изменении значения поля file 
    $('input[type=file]').on('change', function(){
        files = this.files;
    });

    function send_solo() {
        text = $('.emoji-wysiwyg-editor').html();
        text = text.replace(/ {1,}/g," ");
        text = text.replace(/\n+$/g,'\n');
        $.post("/actions/send.php", 
        {
            id_user: <?php echo $id;?>,
            name: "<?php echo $name; ?>",
            cid: "<?php echo $chat; ?>",
            login_fd: "<?php echo $login_fd; ?>",
            text: text
        });
        $('.emoji-wysiwyg-editor').html("");
        document.getElementById("text").value = "";
        check_messages();
        };
        

    function send() { 
        // ничего не делаем если files пустой
        if( typeof files == 'undefined' ) { send_solo();}
        // создадим объект данных формы
        var data = new FormData();

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each( files, function( key, value ){
            data.append( key, value );
        });

        // добавим переменную для идентификации запроса
        data.append( 'my_file_upload', 1 );
        data.append('id_user', <?php echo $id;?>);
        data.append('name', "<?php echo $name; ?>");
        data.append('cid', "<?php echo $chat; ?>");
        data.append('login_fd', "<?php echo $login_fd; ?>");
        text = $('.emoji-wysiwyg-editor').html();
        text = text.replace(/ {1,}/g," ");
        text = text.replace(/\n+$/g,'\n');
        data.append('text', text);
        $.ajax({
            url: "/actions/send.php",
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
        $('.emoji-wysiwyg-editor').html("");
        document.getElementById("text").value = "";
        document.getElementById("file").value = "";
        check_messages();
    };
    document.getElementById("send").onclick = function() { 
        send(); 
        setTimeout(function(){
            scrollToBottom();
        }, 100);
    };
    check_messages();
    setInterval("check_messages()", 1000);
    function reloadEmoji() {
        $('.apple').Emoji({
                    path:  'lib/jquery-emoji/img/apple40/',
                    class: 'emoji',
                    ext:   'png'
                });
    }
    function check_messages() {       
    $.post("actions/check_messages.php?chat=<?php echo $chat; ?>", function( data ) {
        Dok.innerHTML = data;
        reloadEmoji();
        }); 
    }
</script>
