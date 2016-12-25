<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Чат Rudi</title>
    <meta name="description" content="Чат" />
    <meta name="keywords" content="Чат" />

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="/css/media-queries.css" rel="stylesheet">
</head>
<body>
<h1 class="text-center">Чат</h1>
<div class="container">
    <div id="loader"></div>
    <div class="chat-window" id="dialog"></div>
    <br>
    <div class="chat-msg">
        <form id="msgForm" role="form" method="post" action="">
            <div class="row">
                <div class="col-sm-2">
                    <input id="userName" name="userName" type="text" autofocus="autofocus" placeholder="Ваш Ник">
                </div>
                <div class="col-sm-8">
                    <textarea id="userMsg" name="userMsg" placeholder="Ваше сообщение" rows="3" cols="40" ></textarea>
                </div>
                <div class="col-sm-2">
                    <button class="chatBtn btn btn-success" type="submit"><span class="glyphicon glyphicon-send text-success"></span> Отправить</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/chat.js" type="text/javascript"></script>
</body>
</html>