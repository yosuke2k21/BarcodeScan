<html>
	<head>
  	<title>ほしい物リスト</title>
    <meta charset="UTF-8">
    <link href="css/favorite.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/rireki.js"></script>
    <script type="text/javascript">

    $(function() {
      $('.Layout').tile(3);
    });

    </script>
	</head>

	<body>
    <br>
    <h1> ほしい物リスト </h1>
    <?php
      /////////////////////////////////////
      // リロード時の二重送信防止 (データ処理) //
      /////////////////////////////////////
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //////////////////
        // お気に入り登録 //
        //////////////////

        // server.phpから送られてきたPOST型の変数
        if (isset($_POST["num"]) && isset($_POST["name"]) && isset($_POST["img"])) {
          $num = $_POST["num"];
          $name = $_POST["name"];
          $img = $_POST["img"];

          $count = 0;

          // JANコードからレコード取得
          $pdo = new PDO("sqlite:CMP.sqlite");
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $st = $pdo->query("select * from favorite where num =" . $num);
          foreach($st as $row){
           $count++;
          }

          // 件数比較
          if ($count == 0) {
            // データの追加
            $st = $pdo->prepare("insert into favorite(num, name, img) values(?, ?, ?)");
            $st->execute(array($num, $name, $img));
          }
          else {
            // すでにほしいものリストに入ってる
          }
        }

        //////////////////
        // お気に入り削除 //
        /////////////////
        else if (isset($_POST["num"])) {
          $num = $_POST["num"];
          $pdo = new PDO("sqlite:CMP.sqlite");
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
          $st = $pdo->query("delete from favorite where num =" . $num);
        }
        header('Location:favorite.php', true, 303);
      }
      /////////////////////////////////////
      // リロード時の二重送信防止 (結果の表示) //
      /////////////////////////////////////
      else {
        // データベース読み込み
        $pdo = new PDO("sqlite:CMP.sqlite");
        $st = $pdo->query("SELECT * FROM favorite");

        echo '<div id="wrap">';
        echo '<div class="tiles_2">';
        foreach($st as $row){
          echo '<div class="Layout">';
          echo '<a href="https://www.amazon.co.jp/s/url=search-alias%3Daps&field-keywords=' . $row["num"]
               . ' " style="text-decoration: none;" class="btn-action"> ' . '<img src=' . $row["img"] . '/>';
          echo '<h3>' . $row["name"] . '</h3>';
          echo '</a>';
          // 削除ボタン
          echo '<form action="favorite.php" method="POST">';
          echo '<input type="hidden" name="num" value="' . $row["num"] . '">';
          echo '<div class="button"><button type="submit">削除する</button></div>';
          echo '</form>';
          echo '</div>';
        }
        echo '</div>';
        echo '</div>';
				echo '<h2><a href="rireki.php" style="text-decoration: none; color: white;">
							読み取り履歴を見る</a></h2>';
      }
    ?>
  </body>
</html>
