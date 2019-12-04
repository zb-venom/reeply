
                <div class="col" id="content" style="padding-left: 0; padding-right: 0; max-width: 975px; width: 975px; min-width: 500px;">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row" style="margin-left: 5px;">                           
                                        <div class="spinner-grow" style="color: rgb(14, 143, 143);" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <h4><b>&#8194;Сообщения</b></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="border-radius: 0 0 0 0; background-color: white; border: 1px solid lightgrey;">
                                        <i class="fa fa-search" style="padding-left: 5px;"></i>
                                    </span>
                                </div>
                                <input class="form-control" id="search" style="z-index: 1; border: 1px solid lightgrey; border-left: 0px;" autocomplete="off" autocorrect="off" autocapitalize="off"  spellcheck="false" placeholder="Поиск">
                                <div class="input-group-append" id="closehide" style="margin-left: -30px; padding-right: 17px; z-index: 0;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="clear">
                                            <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="list-group">
                                <div id="Dok"></div>
                            </div>
                </div>

<script>
    var myInput = document.getElementById('search');
    var clear = document.getElementById('clear');
    var closehide = document.getElementById('closehide');

    clear.onclick = function() { 
        myInput.value = '';
        check_messages_list();
    };
    //on keyup, start the countdown
    myInput.addEventListener('keyup', () => {
        if (myInput.value) {
            closehide.style.zIndex = 2;
            doneTyping();
        }
        if(!myInput.value){
            closehide.style.zIndex = 0;
            check_messages_list();
        }
    });

    //user is "finished typing," do something
    function doneTyping () {
        $.post("actions/check_mes_list.php", {search: document.getElementById("search").value} ,function( data ) {
        Dok.innerHTML = data;
        }); 
    }
    check_messages_list();
    function reloadEmoji() {
        $('.apple').Emoji({
                    path:  'lib/jquery-emoji/img/apple40/',
                    class: 'emoji',
                    ext:   'png'
                });
    }
    function check_messages_list() {
    $.post("actions/check_mes_list.php", function( data ) {
        Dok.innerHTML = data;
        reloadEmoji();
        }); 
    }
</script>