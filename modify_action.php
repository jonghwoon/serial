<?php
include "./db.php";
?>

<?php
                            
                $id = $_POST['id'];                     //id
                $serial = $_POST['serial'];             //タブレットシリアル
                $name = $_POST['name'];                 //名前
                $phone = $_POST['phone'];               //電話番号
                $address = $_POST['address'];           //住所
                $email = $_POST['email'];               //メール
                $ju_serial = $_POST['ju_serial'];       //熱機器シリアル
                $branch = $_POST['branch'];             //支店
                $attatch = $_POST['attatch'];           //所属
                $remark = $_POST['remark'];             //備考
                
                $URL = $_POST['link'];                  //return URL
 
                $query = "INSERT INTO User_Data
                            (id, serial, name, phone, address, email,
                            ju_serial, branch, attatch, remark)
                            VALUES (
                            '$id',
                            '$serial',
                            '$name',
                            '$phone',
                            '$address',
                            '$email',
                            '$ju_serial',
                            '$branch',
                            '$attatch',
                            '$remark')
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
                $result = mq($query);
                if($result){
                    
?>                  <script>
                        alert("<?php echo "정보가 수정 되었습니다."?>"); //情報が修正されました。
                        location.replace("<?php echo $URL?>");
                    </script>
<?php
                }
                else{
                        echo "FAIL";
                        error_reporting(E_ALL);

                        ini_set("display_errors", 1);
               }

?>