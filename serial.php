<?php
include  "./db.php";


if (isset($_SESSION['user_id'])) {
  ?> &nbsp;<button class="btn btn-warning" onclick="location.href='./logout.php'">로그아웃</button>
  <?php echo $_SESSION['user_name'] ?>님 안녕하세요.
  <?php
  $result = mq("SELECT i.id, i.serial, d.name, d.phone, d.address, d.branch, d.out_date
  from User_Info as i
  left join User_Data as d
  on i.id = d.id
  where i.id >= 200
  order by id desc");
  $total = mysqli_num_rows($result);

  //페이징에 필요한 변수
  $pageNum = ($_GET['page']) ? $_GET['page'] : 1; //기본페이지 1
  $list = 10;                                     //한페이지당 10개씩
  $limit = ($pageNum - 1) * $list;                //mysql limit활용에 필요한 변수
  $blockList = 10;                                //블록에 10개씩 표시
  $block = ceil($pageNum / $blockList);           //현재리스트 구하기

  $blockStart = (($block - 1) * $blockList) + 1;  //현재블록 시작페이지
  $blockEnd = $blockStart + $blockList - 1;       //현재블록 마지막페이지

  $total_page = ceil($total / $list);             //총 페이지 수

  if ($blockEnd > $total_page) $blockEnd = $total_page; //마지막페이지보다 총페이지가 크면 숫자 맞춰주기

} else { ?>
  <script>
    alert("로그인 해 주세요.");
    location.replace("./")
  </script>
  <br />
<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>시리얼 관리</title>
</head>

<body>
  <!-- 테이블 -->
  <h2 align=center><a href="./serial.php?page">시리얼 관리</a></h2>
  <?php if($_SESSION['user_id'] != 'say2them@gmail.com') {
    //시리얼 추가는 관리자만 할 수 있도록 다른 아이디일 때 표시 안되게 처리
  } else { ?>
  <!-- 시리얼 추가 버튼 -->
  <div class=text align=center>
    <button type="button" name="add" id="add" data-toggle="modal" class="btn btn-primary" style="cursor: hand" data-target="#add_data_Modal">시리얼추가</button>
    <br><br>
  </div>
  <?php }  ?>
  <div class="container">
    <!-- 검색버튼 -->
    <div class="form-group">
      <form action="search.php?page=1&" method="get" class="form-inline" id="search_form" name="search_form">
        <select class="form-control" name="category" id="category">
          <option value="i.serial">태블릿시리얼</option>
          <option value="ju_serial">주열기시리얼</option>
          <option value="id"> 태블릿번호 </option>
          <option value="out_date">출고일</option>
          <option value="name">이름</option>
          <option value="branch">지사</option>
        </select>&nbsp;
        <input type="text" class="form-control" id="searching" name="searching" size="35" require="require">
        <input type="text" class="form-control" id="searching1" name="searching1" size="15" require="require" placeholder="시작번호">
        <input type="text" class="form-control" id="searching2" name="searching2" size="15" require="require" placeholder="끝번호">
        <input type="date" class="form-control" id="searching3" name="searching3" size="15" require="require" placeholder="시작날짜">
        <input type="date" class="form-control" id="searching4" name="searching4" size="15" require="require" placeholder="끝날짜">
        <button type="submit" class="btn btn-success">검색</button>
      </form>
    </div>
    <script>
      $(document).ready(function() {
        $('#searching1').hide();
        $('#searching2').hide();
        $('#searching3').hide();
        $('#searching4').hide();

        //태블릿 번호 입력란에 숫자만 입력 가능하게
        $('#searching1').keyup(function() {
          $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });
        $('#searching2').keyup(function() {
          $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });

        //카테고리 변경 시 검색창 변경
        $('#category').change(function() {

          if ($(this).val() == 'id') {
            $('#searching').hide();
            $('#searching1').show();
            $('#searching2').show();
            $('#searching3').hide();
            $('#searching4').hide();

          } else if ($(this).val() == 'out_date') {
            $('#searching').hide();
            $('#searching1').hide();
            $('#searching2').hide();
            $('#searching3').show();
            $('#searching4').show();
          } else {
            $('#searching').show();
            $('#searching1').hide();
            $('#searching2').hide();
            $('#searching3').hide();
            $('#searching4').hide();
          }
        });

      });
    </script>
    <!-- 메인테이블 -->
    <table id="main_table" class="table table-bordered" align=center>
      <thead align="center">
        <tr>
          <td width="15%" align="center">태블릿번호</td>
          <td width="13%" align="center">태블릿시리얼</td>
          <td width="11%" align="center">이름</td>
          <td width="28%" align="center">주소</td>
          <td width="12%" align="center">연락처</td>
          <td width="11%" align="center">지사</td>
          <td width="10%" align="center">출고일</td>
        </tr>
      </thead>

      <tbody>
        <?php
        $result2 = mq("SELECT i.id, i.serial, d.name, d.phone, d.address, d.branch, d.out_date
      from User_Info as i
      left join User_Data as d
      on i.id = d.id
      where i.id >= 200
      order by id desc
      limit $limit, $list");
        while ($rows = mysqli_fetch_assoc($result2)) { //DB에 저장된 데이터 수 (열 기준)
          if ($total % 2 == 0) {
            ?> <tr class="even">
            <?php   } else {
              ?>
            <tr>
            <?php } ?>
            <td width="15%" align="center"><?php echo $rows['id'] ?></td>
            <td width="13%" align="center">
              <input class="btn btn-link view_data" type="button" value="<?php echo $rows['serial'] ?>" name="view" id="<?php echo $rows['id'] ?>">
            </td>
            <td width="11%"" align=" center"><?php echo $rows['name'] ?></td>
            <td width="28%" align="center"><?php echo $rows['address'] ?></td>
            <td width="12%" align="center"><?php echo $rows['phone'] ?></td>
            <td width="11%" align="center"><?php echo $rows['branch'] ?></td>
            <td width="10%" align="center"><?php echo $rows['out_date'] ?></td>
          </tr>
          <?php
          $total--;
        }
        ?>
      </tbody>
    </table>
  </div>
  <!-- 상세보기 모달 -->
  <div id="dataModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- 모달 헤더 -->
        <div class="modal-header">
          <h4 class="modal-title">상세보기</h4>
          <button class="close" type="button" data-dismiss="modal">&times;</button>
        </div>

        <!-- 모달 바디 -->
        <div class="modal-body" id="detail"></div>

        <!-- 모달 풋터 -->
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal" type="button">닫기</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 입력하기 모달 -->
  <div id="add_data_Modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- 모달 헤더 -->
        <div class="modal-header">
          <h4 class="modal-title">정보입력</h4>
          <button type="button" data-dismiss="modal" class="close">&times;</button>
        </div>

        <!-- 모달 바디 -->
        <div class="modal-body">
          <form method="POST" id="insert_form">
            <table class="table table-bordered">
              <tr>
                <th><label for="id">태블릿번호</label></th>
                <td><input class="form-control" type="text" name="id" id="id"></td>
              </tr>
              <tr>
                <th><label for="serial">태블릿시리얼</label></th>
                <td><input class="form-control" type="text" name="serial" id="serial"></td>
              </tr>
              <tr>
                <th><label for="ju_serial">주열기시리얼</label></th>
                <td><input class="form-control" type="text" name="ju_serial" id="ju_serial"></td>
              </tr>
              <tr>
                <th><label for="name">이름</label></th>
                <td><input class="form-control" type="text" name="name" id="name"></td>
              </tr>
              <tr>
                <th><label for="phone">휴대폰</label></th>
                <td><input class="form-control" type="text" name="phone" id="phone"></td>
              </tr>
              <tr>
                <th><label for="address">주소</label></th>
                <td><input class="form-control" type="text" name="address" id="address"></td>
              </tr>
              <tr>
                <th><label for="email">이메일</label></th>
                <td><input class="form-control" type="email" name="email" id="email"></td>
              </tr>
              <tr>
                <th><label for="out_date">출고일</label></th>
                <td><input class="form-control" type="date" name="out_date" id="out_date"></td>
              </tr>
              <tr>
                <th><label for="branch">지사</label></th>
                <td><input class="form-control" type="text" name="branch" id="branch"></td>
              </tr>
              <tr>
                <th><label for="attatch">소속</label></th>
                <td><input class="form-control" type="text" name="attatch" id="attatch"></td>
              </tr>
              <tr>
                <th><label for="remark">비고</label></th>
                <td><textarea class="form-control" name="remark" style="height: 100px;" id="remark"></textarea></td>
              </tr>
            </table>
            <input type="submit" name="insert" value="추가" class="btn btn-primary" id="insert">
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
        </div>

      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      //현재페이지 주소 받아오기
      var link = document.location.href;
      //추가버튼 클릭 시 작동
      $('#insert_form').on('submit', function(event) {
        //입력 안되면 넘어가지 않도록 하기
        event.preventDefault();
        if ($('#id').val() == '') {
          alert("태블릿번호를 입력해주세요.");
        } else if ($('#serial').val() == '') {
          alert("태블릿시리얼을 입력해주세요.");
        } else {
          $.ajax({
            url: "insert.php",
            method: "POST",
            data: $('#insert_form').serialize(),
            success: function(data) {
              $('#insert_form')[0].reset();
              $('#add_data_Modal').modal('hide');
              location.href = "./serial.php?page"; //원래 있던 페이지에 남기 원하면 link로 교체할 것
              alert("추가 되었습니다.");
            }
          })
        }
      });

      //태블릿시리얼의 링크를 클릭했을 때
      $(document).on('click', '.view_data', function() {

        var id = $(this).attr("id");
        var link = document.location.href;
        $.ajax({
          //view.php로 데이터 전송
          url: "view.php",
          method: "post",
          //id 변수 
          data: {
            id: id,
            link: link
          },
          success: function(data) {
            //모달에 데이터 뿌려줌
            $('#detail').html(data);
            $('#dataModal').modal("show");
          }
        });
      });
    });
  </script>

  <!-- 페이징 -->

  <div class="paging" align=center>
    <?php
    if ($pageNum <= 1) { ?>
      <font size=4 color=red>처음</font>
    <?php } else { ?>
      <font size=4><a href="./serial.php?page=&list=<?= $list ?>">처음</a></font>
    <?php }

    if ($block <= 1) { ?>
      <font></font>
    <?php } else { ?>
      <font size=4><a href="./serial.php?page=<?= $blockStart - 1 ?>&list=<?= $list ?>">이전</a></font>
    <?php } ?>
    <?php
    for ($j = $blockStart; $j <= $blockEnd; $j++) {
      if ($pageNum == $j) { ?>
        <font size=4 color=red> <?= $j ?></font>
      <?php } else { ?>
        <font size=4><a href="./serial.php?page=<?= $j ?>&list=<?= $list ?>"><?= $j ?></a></font>
      <?php }
    } ?>

    <?php
    $total_block = ceil($total_page / $blockList);

    if ($block >= $total_block) { ?>
      <font> </font>
    <?php } else { ?>
      <font size=4><a href="./serial.php?page=<?= $blockEnd + 1 ?>&list=<?= $list ?>">다음</a></font>
    <?php }

    if ($pageNum >= $total_page) { ?>
      <font size=4 color=red>마지막</font>
    <?php } else { ?>
      <font size=4><a href="./serial.php?page=<?= $total_page ?>&list=<?= $list ?>">마지막</a></font>
    <?php }
    ?>
  </div>
</body>

</html>