<?php
    include "./db.php";
    if (isset($_SESSION['user_id'])) {
  
      } else { ?>
        <script>
          alert("로그인 해 주세요."); //ログインしてください。
          location.replace("./")
        </script>
        <br />
      <?php
      }

$link = '';
if(isset($_POST["link"])) {
        $link = $_POST["link"];
}
        if(isset($_POST["id"])) {
                
                $query = "select i.id, i.serial, d.name, d.phone, d.address, d.email, d.ju_serial, d.branch, d.attatch, d.out_date, d.remark
                        from User_Info as i
                        left join User_Data as d
                        on i.id = d.id
                        where i.id = '".$_POST["id"]."'";
                $result = mq($query);
                $output = '';
                $output .='
                <form method = "POST" action = "modify_action.php" id="modify_form">
                <div class="table-responsive">
                        <table class="table table-bordered">';

                        while($row = mysqli_fetch_array($result)) {
                                $output .='
                        <tr>
                                <td width="30%">태블릿번호</td>
                                <td width="70%">'.$row["id"].'</td>
                                <input type="hidden" name="id" value="'.$row["id"].'">
                        </tr>
                                <input type="hidden" name="link" value="'.$link.'"
                        <tr>
                                <td width="30%">태블릿시리얼</td>
                                <td width="70%">'.$row["serial"].'</td>
                                <input type="hidden" name="serial" value="'.$row["serial"].'">
                        </tr>
                        <tr>
                                <td width="30%">주열기시리얼</td>
                                <td width="70%">
                                <input class="form-control" type="text" name="ju_serial" value="'.$row["ju_serial"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">이름</td>
                                <td width="70%">
                                <input class="form-control" type="text" name="name" value="'.$row["name"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">휴대폰</td>
                                <td width="70%">
                                <input class="form-control" type="text" name="phone" value="'.$row["phone"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">주소</td>
                                <td width="70%">
                                <input class="form-control" type="text" name="address" value="'.$row["address"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">출고일</td>
                                <td width="70%">
                                <input class="form-control" type="date" name="out_date" value="'.$row["out_date"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">이메일</td>
                                <td width="70%">
                                <input class="form-control" type="text" name="email" value="'.$row["email"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">지사</td>
                                <td width="70%">
                                <input class="form-control" type="text" name="branch" value="'.$row["branch"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">소속</td>
                                <td width="70%">
                                <input class="form-control" type="text" name="attatch" value="'.$row["attatch"].'"></td>
                        </tr>
                        <tr>
                                <td width="30%">비고</td>
                                <td width="70%">
                                <textarea class="form-control" row="4" name="remark" style="height:100px;">'.$row["remark"].'</textarea>
                                </td>
                        </tr>
                        ';
                        }
                        $output .= "</table></div></form>
                        <div><button class='btn btn-info' type='submit' form='modify_form'>수정</button></div>";
                        echo $output;
        }
?>