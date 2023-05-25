<?php
//接続情報
include  "./db.php";

    //id, pw 入力
    $id = $_POST['id'];
    $pw = $_POST['pw'];

    //id検査
    $query = "select * from Admin_Member where user_id = '$id'";
    $result = mq($query);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //idがある場合、パスワード検査
    if(mysqli_num_rows($result)==1) {

        $row=mysqli_fetch_assoc($result);
        $user_name = $row['user_name'];
        //セッション生成
        if($row['user_pw'] == $pw) {
            $_SESSION['user_id']=$id;
            $_SESSION['user_name'] = $user_name;
            
            if(isset($_SESSION['user_id'])){
                ?>  <script>
                        alert("로그인 되었습니다."); //ログイン成功
                        location.replace("./serial.php?page");
                    </script>
    <?php
            } else {
                echo "session fail";
            }
        }

        else {
            ?> <script>
                    alert("아이디나 비밀번호가 잘못되었습니다."); //id又はパスワードが正しくありません。
                    history.back();
                </script>
    <?php
        }
    }
        else {
            ?> <script>
                    alert("아이디나 비밀번호가 잘못되었습니다.");　//id又はパスワードが正しくありません。
                    history.back();
                </script>
<?php
        }
?>