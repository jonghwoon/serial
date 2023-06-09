<?php
include  "./db.php";


if (isset($_SESSION['user_id'])) {
  ?> &nbsp;<button class="btn btn-warning" onclick="location.href='./logout.php'">로그아웃</button>
  <?php echo $_SESSION['user_name'] ?>님 안녕하세요.
  
  <?php
  $category = $_GET['category'];
  $searching = $_GET['searching'];
  $searching1 = ($_GET['searching1']) ? $_GET['searching1'] : 200;
  $searching2 = ($_GET['searching2']) ? $_GET['searching2'] : 99999;
  $searching3 = ($_GET['searching3']) ? $_GET['searching3'] : '1999-01-01';
  $searching4 = ($_GET['searching4']) ? $_GET['searching4'] : '2200-12-31';

  $query = '';
  if ($category == 'id') {
    $query = "select i.id, i.serial, d.name, d.phone, d.address, d.email, d.ju_serial, d.branch, d.attatch, d.date, d.remark, d.out_date
    from User_Info as i
    left join User_Data as d
    on i.id = d.id
    where i.id >= '$searching1' and i.id <= '$searching2' and i.id >= 200
    order by id desc";
  } else if ($category == 'out_date') {
    $query = "select i.id, i.serial, d.name, d.phone, d.address, d.email, d.ju_serial, d.branch, d.attatch, d.out_date, d.remark
      from User_Info as i
      left join User_Data as d
      on i.id = d.id
      where out_date >= '$searching3' and out_date <= '$searching4' and i.id >= 200
      order by out_date desc";
  } else {
    $query = "select i.id, i.serial, d.name, d.phone, d.address, d.email, d.ju_serial, d.branch, d.attatch, d.out_date, d.remark
      from User_Info as i
      left join User_Data as d
      on i.id = d.id
      where i.id >= 200 and $category like '%$searching%'
      order by id desc";
  }

  $result = mq($query);
  $total = mysqli_num_rows($result);
} else {
  ?>
  <script>
    alert("로그인 해 주세요."); //ログインしてください。
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
  <title>시리얼 검색</title><!-- シリアル検索 -->
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body>
  <!-- テーブル -->
  <h2 align=center><a href="./serial.php?page">시리얼 관리</a></h2> <!-- シリアル管理 -->
  <?php if($_SESSION['user_id'] != 'admin@mail.com') {
    //シリアル追加は管理者のみ出来ること。
  } else { ?>
  <!-- シリアル 追加 ボタン -->
  <div class=text align=center>
    <button type="button" name="add" id="add" data-toggle="modal" class="btn btn-primary" style="cursor: hand" data-target="#add_data_Modal">시리얼추가</button>
    <br><br>
  </div>
  <?php }  ?>
  <div class="container">
    <!-- 検索ボタン -->
    <?php
    //検索引数
    $category = $_GET['category'];
    $serch = $_GET['searching'];
    ?>
    <!-- 検索ボタン -->
    <div class="form-group">
      <form action="search.php?page=1&" method="get" class="form-inline">
        <select class="form-control" name="category" id="category">
          <option value="i.serial">태블릿시리얼</option> <!-- タブレットシリアル -->
          <option value="ju_serial">주열기시리얼</option> <!-- 熱機器シリアル -->
          <option value="id"> 태블릿번호 </option> <!-- タブレット番号 -->
          <option value="out_date">출고일</option> <!-- 出庫日 -->
          <option value="name">이름</option> <!-- 名前 -->
          <option value="branch">지사</option> <!-- 支店 -->
        </select>&nbsp;
        <input type="text" class="form-control" id="searching" name="searching" size="35" require="require">
        <input type="text" class="form-control" id="searching1" name="searching1" size="15" require="require" placeholder="시작번호"> <!-- 開始番号 -->
        <input type="text" class="form-control" id="searching2" name="searching2" size="15" require="require" placeholder="끝번호"> <!-- 終了番号 -->
        <input type="date" class="form-control" id="searching3" name="searching3" size="15" require="require" placeholder="시작날짜"> <!-- 開始日付 -->
        <input type="date" class="form-control" id="searching4" name="searching4" size="15" require="require" placeholder="끝날짜"> <!-- 終了日付 -->
        <button class="btn btn-success">검색</button> <!-- 検索 -->
      </form>
    </div>
    <script>
      $(document).ready(function() {
        $('#searching1').hide();
        $('#searching2').hide();
        $('#searching3').hide();
        $('#searching4').hide();

        //数字のみ入力
        $('#searching1').keyup(function() {
          $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });
        $('#searching2').keyup(function() {
          $(this).val($(this).val().replace(/[^0-9]/g, ""));
        });

        //カテゴリー変更すると表示変更
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
    <table class="table table-bordered" align=center>
      <thead align="center">
        <tr>
          <td width="15%" align="center">태블릿번호</td> <!-- タブレット番号 -->
          <td width="13%" align="center">태블릿시리얼</td> <!-- タブレットシリアル -->
          <td width="11%" align="center">이름</td> <!-- 名前 -->
          <td width="28%" align="center">주소</td> <!-- 住所 -->
          <td width="12%" align="center">연락처</td> <!-- 携帯電話 -->
          <td width="11%" align="center">지사</td> <!-- 支店 -->
          <td width="10%" align="center">출고일</td> <!-- 出庫日 -->
        </tr>
      </thead>

      <tbody>
        <?php
        while ($rows = mysqli_fetch_assoc($result)) { //DBのデータ数
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
            <td width="11%" align="center"><?php echo $rows['name'] ?></td>
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
</body>
<!-- 詳細モーダル -->
<div id="dataModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- モーダルヘッダー -->
      <div class="modal-header">
        <h4 class="modal-title">상세보기</h4> <!-- 詳細確認 -->
        <button class="close" type="button" data-dismiss="modal">&times;</button>
      </div>

      <!-- モーダルボディ -->
      <div class="modal-body" id="detail"></div>

      <!-- モーダルフッター -->
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" type="button">닫기</button> <!-- 閉じる -->
      </div>
    </div>
  </div>
</div>

<!-- 入力モーダル-->
<div id="add_data_Modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- モーダルヘッダー -->
      <div class="modal-header">
        <h4 class="modal-title">정보입력</h4> <!-- 情報入力 -->
        <button type="button" data-dismiss="modal" class="close">&times;</button>
      </div>

      <!-- モーダルボディ -->
      <div class="modal-body">
        <form method="POST" id="insert_form">
          <table class="table table-bordered">
            <tr>
              <th><label for="id">태블릿번호</label></th>  <!-- タブレット番号 -->
              <td><input class="form-control" type="text" name="id" id="id"></td>
            </tr>
            <tr>
              <th><label for="serial">태블릿시리얼</label></th> <!-- タブレットシリアル -->
              <td><input class="form-control" type="text" name="serial" id="serial"></td>
            </tr>
            <tr>
              <th><label for="ju_serial">주열기시리얼</label></th> <!-- 熱機器シリアル -->
              <td><input class="form-control" type="text" name="ju_serial" id="ju_serial"></td>
            </tr>
            <tr>
              <th><label for="name">이름</label></th> <!-- 名前 -->
              <td><input class="form-control" type="text" name="name" id="name"></td>
            </tr>
            <tr>
              <th><label for="phone">휴대폰</label></th> <!-- 携帯電話 -->
              <td><input class="form-control" type="text" name="phone" id="phone"></td>
            </tr>
            <tr>
              <th><label for="address">주소</label></th> <!-- 住所 -->
              <td><input class="form-control" type="text" name="address" id="address"></td>
            </tr>
            <tr>
              <th><label for="email">이메일</label></th> <!-- メール -->
              <td><input class="form-control" type="email" name="email" id="email"></td>
            </tr>
            <tr>
              <th><label for="out_date">출고일</label></th> <!-- 出庫日 -->
              <td><input class="form-control" type="date" name="out_date" id="out_date"></td>
            </tr>
            <tr>
              <th><label for="branch">지사</label></th> <!-- 支店 -->
              <td><input class="form-control" type="text" name="branch" id="branch"></td>
            </tr>
            <tr>
              <th><label for="attatch">소속</label></th> <!-- 所属 -->
              <td><input class="form-control" type="text" name="attatch" id="attatch"></td>
            </tr>
            <tr>
              <th><label for="remark">비고</label></th> <!-- 備考 -->
              <td><textarea class="form-control" name="remark" style="height: 100px;" id="remark"></textarea></td>
            </tr>
          </table>
          <input type="submit" name="insert" value="추가" class="btn btn-primary" id="insert"> <!-- 追加 -->
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button> <!-- 閉じる -->
      </div>

    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
      //現在のページ
      var link = document.location.href;
      //追加ボタン押下し動作
      $('#insert_form').on('submit', function(event) {
        //入力されない項目がある場合、動作防止
        event.preventDefault();
        if ($('#id').val() == '') {
          alert("태블릿번호를 입력해주세요."); //タブレット番号を入力してください。
        } else if ($('#serial').val() == '') {
          alert("태블릿시리얼을 입력해주세요."); //タブレットシリアルを入力してください。
        } else {
          $.ajax({
            url: "insert.php",
            method: "POST",
            data: $('#insert_form').serialize(),
            success: function(data) {
              $('#insert_form')[0].reset();
              $('#add_data_Modal').modal('hide');
              location.href = "./serial.php?page"; //ページ移動するための
              alert("추가 되었습니다."); //追加されました。
            }
          })
        }
      });

      //詳細確認リンク押下する時
      $(document).on('click', '.view_data', function() {

        var id = $(this).attr("id");
        var link = document.location.href;
        $.ajax({
          //view.phpへデーター送信
          url: "view.php",
          method: "post",
          //id引数 
          data: {
            id: id,
            link: link
          },
          success: function(data) {
            //モーダルにデーター表示
            $('#detail').html(data);
            $('#dataModal').modal("show");
          }
        });
      });
    });
  </script>

</html>