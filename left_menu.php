      
            <div class="card left_menu" id="left_menu" style="padding-left: 0; padding-right: 0; border: 0px; max-width: 225px; width: 225px; min-width: 0px;">
                <div class="card-header" style="background-color: white; border-bottom: 0px;">
                    <a class="navbar-brand" href="/"><h1 class="logo-link"><b>R<span id="dis0">eeply<i style="font-size: 15px; margin-left: -7px;">inc.</i></b></span></h1></a>
                </div>
                <div class="card-body" style="margin-top: -30px; margin-right: -20%;">
                    <a href="/news.php" <?php if($_SERVER['REQUEST_URI']==="/news.php") echo 'class="active-link"'; ?>><h4 style="display: inline;"><i style='width: 1em' class="active-link fa fa-newspaper-o"></i><span id="dis1">&nbsp;Новости</span></h4></a> <p style="margin-bottom: 10px;"></p>
                    <a href="/my_page.php" <?php if($_SERVER['REQUEST_URI']==="/my_page.php") echo 'class="active-link"'; ?>><h4 style="display: inline;"><i style='width: 1em' class="active-link fa fa-home"></i><span id="dis2">&nbsp;Профиль</span></h4></a> <p style="margin-bottom: 10px;"></p>
                    <a href="/messages.php" <?php if($_SERVER['REQUEST_URI']==="/messages.php") echo 'class="active-link"'; ?>><h4 style="display: inline;"><i style='width: 1em' class="active-link fa fa-comments"></i><span id="dis3">&nbsp;Сообщения</h4><? require_once "actions/num_mes.php"; ?></span></a> <p style="margin-bottom: 10px;"></p>             
                    <a href="/settings.php" <?php if($_SERVER['REQUEST_URI']==="/settings.php") echo 'class="active-link"'; ?>><h4 style="display: inline;"><i style='width: 1em' class="active-link fa fa-cog"></i><span id="dis4">&nbsp;Настройки</span></h4></a><p style="margin-bottom: 10px;"></p>
                    <a href="/service"><h4 style="display: inline;"><i style='width: 1em' class="active-link fa fa-gamepad"></i><span id="dis5">&nbsp;Сервисы</span></h4></a><p style="margin-bottom: 10px;"></p>
                    <hr>
                    <a href="/actions/exit.php"><h4 style="display: inline;"><i style='width: 1em' class="active-link fa fa-sign-out"></i><span id="dis6">&nbsp;Выход</span></h4></a><p style="margin-bottom: 10px;"></p>
                    <hr>
                    <a href="#" id="hide" onclick="left()" style="visibility: hidden"><h4 style="display: inline;"><i style='width: 1em' class="active-link fa fa-list"></i><span id="dis7">&nbsp;Скрыть</span></h4></a><p style="margin-bottom: 10px;"></p>
                </div>
            </div>
            <script>
                if ("<?php echo $_SERVER['REQUEST_URI']; ?>" == "/news.php" || "<?php echo $_SERVER['REQUEST_URI']; ?>" == "/messages.php")
                   document.getElementById('hide').style.visibility = "visible";
            </script>