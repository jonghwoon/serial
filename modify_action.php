<?php
include "./db.php";
?>

<?php
                            
                $id = $_POST['id'];                     //id
                $serial = $_POST['serial'];             //serial
                $name = $_POST['name'];                 //이름
                $phone = $_POST['phone'];               //전화
                $address = $_POST['address'];           //주소
                $email = $_POST['email'];               //메일
                $ju_serial = $_POST['ju_serial'];       //주열기 시리얼
                $branch = $_POST['branch'];             //지점
                $attatch = $_POST['attatch'];           //소속
                $remark = $_POST['remark'];             //비고란
                
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
                        alert("<?php echo "정보가 수정 되었습니다."?>");
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