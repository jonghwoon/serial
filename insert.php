<?php include './db.php';
//データー入力
if(!empty($_POST)) {
    $msg = '';
    $output = '';
    $connect = mysqli_connect("host", "id", "password", "driver");

    $id = mysqli_real_escape_string($connect, $_POST["id"]);
    $serial = mysqli_real_escape_string($connect, $_POST["serial"]);
    $ju_serial = mysqli_real_escape_string($connect, $_POST["ju_serial"]);
    $name = mysqli_real_escape_string($connect, $_POST["name"]);
    $phone = mysqli_real_escape_string($connect, $_POST["phone"]);
    $address = mysqli_real_escape_string($connect, $_POST["address"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $branch = mysqli_real_escape_string($connect, $_POST["branch"]);
    $attatch = mysqli_real_escape_string($connect, $_POST["attatch"]);
    $remark = mysqli_real_escape_string($connect, $_POST["remark"]);

    //insert
    if($_POST["id"] != '') {
        $query = 
        "INSERT INTO User_Data
        (id, serial, name, phone, address, email,
        ju_serial, branch, attatch, remark)
        VALUES (
        '$id','$serial','$name','$phone','$address','$email',
        '$ju_serial','$branch','$attatch','$remark')
        ON DUPLICATE KEY UPDATE 
        serial = '$serial',
        name = '$name',
        phone = '$phone',
        address = '$address',
        email = '$email',
        ju_serial = '$ju_serial',
        branch = '$branch',
        attatch = '$attatch',
        remark = '$remark'";

        $msg = '정상적으로 처리 되었습니다.'; //正常に処理されました。
    }

    if(mysqli_query($connect, $query)) {
        
        $output .= '<label calss="text-success">'.$msg.'</label>';
        $select_query = 
        "SELECT i.id, i.serial, d.name, d.phone, d.address, d.branch
        from User_Info as i
        left join User_Data as d
        on i.id = d.id
        where i.id >= 200
        order by id desc";
        $result = mysqli_query($connect, $select_query);

        $output .='
            <table class="table table-bordered">
                <tr>
                    <th width="30%">이름/名前</th>
                    <th width="70%">보기/詳細</th>
                </tr>';

                while($row=mysqli_fetch_array($result)){
                    $output .='
                    <tr>
                        <td>'.$row["name"].'</td>
                        <td><input type="button" name="view" value="자세히" id="'.$row["id"].'"
                        class="view_data btn" /></td>
                    </tr>';

                }
                $output .= '</table>';
    }
            echo $output;
}   



?>