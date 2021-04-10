<?php
  // ログイン機能で使う
  // if (isset($_SESSION["user"])) {
  //   # code...
  // }else {
  //   header("Location; login_form.php");
  //   exit;
  // }


?>

<!DOCTYPE html>
<html lang="ja">
  <form action="favorite.php" method="post">
  <head>
    <meta charset="utf-8">
    <title> 商品情報 </title>
    <link href="css/goods.css" rel="stylesheet">
  </head>
  <body>
    <?php
      // Yahoo APIを利用するためのオマジナイ文 //
      require_once("common.php");//共通ファイル読み込み(使用する前に、appidを指定してください。)

    	$hits = array();
    	$query = !empty($_GET["query"]) ? $_GET["query"] : "";
    	$sort =  !empty($_GET["sort"]) && array_key_exists($_GET["sort"], $sortOrder) ? $_GET["sort"] : "-score";
    	$category_id = !empty($_GET["category_id"]) && ctype_digit($_GET["category_id"]) && array_key_exists($_GET["category_id"], $categories) ? $_GET["category_id"] : "1";

    	if ($query != "") {
    		$query4url = rawurlencode($query);
    		$sort4url = rawurlencode($sort);
    		$url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appid&query=$query4url&category_id=$category_id&sort=$sort4url";
    		$xml = simplexml_load_file($url);
    		if ($xml["totalResultsReturned"] != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。
    				$hits = $xml->Result->Hit;
    		}
    	}
      // Yhoo APIオマジナイはここまで //

      // monacaからJANコードをGET型で受け取る
      if (isset($_GET["num"])) {
        $query = $_GET["num"];
        $favorite=1;
      }

      // 件数が１件でもある場合に、表示と履歴登録
      $isProductExist = false;
      if(count($hits) > 0){
        $isProductExist = true;
      }

      if($isProductExist){

        // 検索結果の1番目を取ってくる(1番目指定の方法)
        $num = h($query);
        $name = h($hits[0]->Name);
        $img =  h($hits[0]->Image->Medium);

        // 商品表示
        if (count($hits) > 0) {
          echo '<div align="center">';
          echo '<a href="https://www.amazon.co.jp/s/url=search-alias%3Daps&field-keywords=' . $query .
               ' " class="btn-action" >';
          echo '<br>';
          echo '<img src=' . $img . ' />';
          echo '<h3 class="Link">' . $name . '</h3>';
          echo '</a>';
          echo '</div>';
        }

        // 履歴登録
        $pdo = new PDO("sqlite:CMP.sqlite");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        // データの挿入
        $st = $pdo->prepare("insert into rireki(num, name, img) values(?, ?, ?)");
        $st->execute(array($num, $name, $img));
      }
    ?>

    <?php if($isProductExist){ ?>
    <!-- POST形式でfavorite.phpに変数を送る。 -->
    <input type="hidden" name="num" value="<?=$num?>">
    <input type="hidden" name="name" value="<?=$name?>">
    <input type="hidden" name="img" value="<?=$img?>">
    <div  class="button"><button class="button" type="submit" >お気に入り登録</button></div>

    <!-- 商品検索がない場合 -->
    <?php }else{ ?>
      <div class="error">
        <h3>エラー：商品が存在しません。JANコードを確認してください。</h3>
      </div>
    <?php } ?>
  </body>
  </form>
</html>
