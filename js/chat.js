/**
 * Первоначальная загрузка сообщений чата
  */
$(document).ready(function(){
    window.updateMsgScroll = true;
    $("#loader").hide();
    //Отображаем 10 последних сообщений
    getMsg(0, 10, false);
    //Запускаем цикл обновления чата
    setInterval(function(){window.setTimeout(updateMsg, 0);}, 1000);
});

/**
 * Добавить новое сообщение в БД
 */
    $("#msgForm").validate({
        rules:{
            userName:{
                required:true,
                maxlength: 128
            },
            userMsg:{
                required:true,
                maxlength: 1024
            }
        },
        messages:{
            userName:{
                required:"Укажите имя",
                maxlength: "Максимум 128 символов"
            },
            userMsg:{
                required:"Напишите сообщение",
                maxlength: "Максимум 1024 символов"
            }
        },
        submitHandler:function(form){
            var userName = $("#userName").val();
            var userMsg  = $("#userMsg").val();
            var param = {'userName':userName, 'userMsg':userMsg}
            $.ajax({
                url: '/core/sendMsg.php',
                dataType: 'json',
                cache: false,
                type: 'POST',
                data: param,
                success: function(data) {
                    if(data.error != 0){
                        alert(data.text);
                        return false;
                    }
                    //делаем фокус на поле сообщения
                    $("#userMsg").val('').focus();
                },
                error: function(data) {
                    alert('Server Error response msgForm');
                }
            });
            return false;
        }
    });

    /**
     * Получить сообщения
     * @param from - номер ID сообщения после которого следует сделать выборку
     * @param max  - максимальное кол. сообщений для выборки
     */
    function getMsg(from, max, reverse){
        var rev = (reverse === true)? 1 : 0;
        var param = {'from':from, 'max':max, 'reverse':rev};
        $.ajax({
            url: '/core/getMsg.php',
            dataType: 'json',
            cache: false,
            type: 'POST',
            data: param,
            success: function(data) {
                if(data.error != 0){
                    alert(data.text);
                    return false;
                }
                //Отображаем сообщения
                appendMsg(data.text, false);
            },
            error: function(data) {
                ;//alert('Server Error response getMsg');
            }
        });
        return false;
    }

    /**
     * Добавить сообщения в конец чата
     * @param msgs - массив сообщений
     * @param top  - Если TRUE тодобавить в начало (Используется при AJAX подгрузки скролинга)
     */
    function appendMsg(msgs, top){
        if (msgs.length == 0) return;
        var index, len, html = '', time;
        for (index = 0, len = msgs.length; index < len; ++index) {
            time = new Date(msgs[index].msg_time * 1000);
            html += '<div class="userMsgBlock" id="' + msgs[index].id + '">' +
                    '<b>' + msgs[index].user_name + '</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                    '<small>' + time.toDateString() + '&nbsp;&nbsp;(' + time.getHours() + ':' + time.getMinutes() + ':' + time.getSeconds() + ')</small><br>' +
                    '<span>' + msgs[index].user_msg + '</span></div>';
        }
        if(top == true){
            $("#dialog").prepend(html);
            $("#dialog").scrollTop(5);
        }else{
            $("#dialog").append(html);
            //Опускаем скролл
            var block = document.getElementById("dialog");
            block.scrollTop = block.scrollHeight;
        }
    }

/**
 * Обновление до последних сообщений
 */
function updateMsg(){
    var lastId = $('#dialog div').last().attr('id');
    if(typeof lastId == "undefined")
        lastId = 0;
    getMsg(lastId, 0, false); //Получить все сообщения после lastId
}

/**
 * Динамическая подгрузка сообщений при скролинге
 */
$("#dialog").scroll(function(){
    if(window.updateMsgScroll == false) return;
    var top = $("#dialog").scrollTop();
    if(top == 0){
        window.updateMsgScroll = false;
        $("#dialog").scrollTop(20);
        var firstId = $('#dialog div:first').attr('id');
        //Получаем сообщения для их подгрузки вверху
        if(typeof firstId != "undefined"){
            $("#loader").show();
            var param = {'from':firstId, 'max':10, 'reverse':1};
            $.ajax({
                url: '/core/getMsg.php',
                dataType: 'json',
                cache: false,
                type: 'POST',
                data: param,
                success: function(data) {
                    if(data.error == 0){
                        //Отображаем сообщения в начале
                        appendMsg(data.text, true);
                    }
                    $("#loader").hide();
                    window.updateMsgScroll = true;
                },
                error: function(data) {
                    alert('Server Error response scroll');
                    $("#loader").hide();
                    window.updateMsgScroll = true;
                }
            });
            return false;
        }
        return false;
    }
    return false;
});



