<!DOCTYPE>
<link rel="stylesheet" href="css/bootstrap.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<html>

<head>
    <meta charset='utf-8'>
</head>
<!-- メイン画面 -->
<body>
    <div class="container"  style="width: 400px; center;">
        <div class="login-form">
            <form action="login_action.php" method="post">
                <h2 class="text-center">ログイン</h2>
                <div class="form-group">
                    <input type="text" name="id" class="form-control" placeholder="Username" required="required">
                </div>
                <div class="form-group">
                    <input type="password" name="pw" class="form-control" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">ログイン</button>
                </div>
            </form>
        </div>

    </div>

</body>