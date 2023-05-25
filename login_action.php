<?php
//연결정보
include  "./db.php";

    //id, pw 입력
    $id = $_POST['id'];
    $pw = $_POST['pw'];

    //id검사
    $query = "select * from Admin_Member where user_id = '$id'";
    $result = mq($query);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //id가 있으면 비번검사
    if(mysqli_num_rows($result)==1) {

        $row=mysqli_fetch_assoc($result);
        $user_name = $row['user_name'];
        //비밀번호가 맞으면 세션 생성
        if($row['user_pw'] == $pw) {
            $_SESSION['user_id']=$id;
            $_SESSION['user_name'] = $user_name;
            
            if(isset($_SESSION['user_id'])){
                ?>  <script>
                        alert("로그인 되었습니다.");
                        location.replace("./serial.php?page");
                    </script>
    <?php
            } else {
                echo "session fail";
            }
        }

        else {
            ?> <script>
                    alert("아이디나 비밀번호가 잘못되었습니다.");
                    history.back();
                </script>
    <?php
        }
    }
        else {
            ?> <script>
                    alert("아이디나 비밀번호가 잘못되었습니다.");
                    history.back();
                </script>
<?php
        }
?>