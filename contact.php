<?php
  session_start();
  $mode = 'input';
  $errmessage = array();
  if( isset($_POST['back']) && $_POST['back'] ){
    // 何もしない
  } else if( isset($_POST['confirm']) && $_POST['confirm'] ){
	  // 確認画面
    if( !$_POST['fullname'] ) {
	    $errmessage[] = "名前を入力してください";
    } else if( mb_strlen($_POST['fullname']) > 100 ){
	    $errmessage[] = "名前は100文字以内にしてください";
    }
	  $_SESSION['fullname']	= htmlspecialchars($_POST['fullname'], ENT_QUOTES);

	  if( !$_POST['email'] ) {
		  $errmessage[] = "Eメールを入力してください";
	  } else if( mb_strlen($_POST['email']) > 200 ){
		  $errmessage[] = "Eメールは200文字以内にしてください";
    } else if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
	    $errmessage[] = "メールアドレスが不正です";
	  }
	  $_SESSION['email']	= htmlspecialchars($_POST['email'], ENT_QUOTES);

	  if( !$_POST['message'] ){
		  $errmessage[] = "お問い合わせ内容を入力してください";
	  } else if( mb_strlen($_POST['message']) > 500 ){
		  $errmessage[] = "お問い合わせ内容は500文字以内にしてください";
	  }
	  $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);

	  if( $errmessage ){
	    $mode = 'input';
    } else {
	    $mode = 'confirm';
    }
  } else if( isset($_POST['send']) && $_POST['send'] ){
    // 送信ボタンを押したとき
    $message  = "お問い合わせを受け付けました \r\n"
              . "名前: " . $_SESSION['fullname'] . "\r\n"
              . "email: " . $_SESSION['email'] . "\r\n"
              . "お問い合わせ内容:\r\n"
              . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);
	  mail($_SESSION['email'],'お問い合わせありがとうございます',$message);
    mail('shohei01@icloud.com','お問い合わせありがとうございます',$message);
    $_SESSION = array();
    $mode = 'send';
  } else {
    $_SESSION['fullname'] = "";
    $_SESSION['email']    = "";
    $_SESSION['message']  = "";
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Contact</title>
<meta name="description" content="齋藤将平の自己紹介">
<link rel="icon" type="image/png" href="images/marulogo.pdf">

<!-- CSS -->
<link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
<link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
<link href="css/plofile-style.css" rel="stylesheet">
</head>

<body>
  <div id="contact" class="big-bg">
  <header class="page-header wrapper">
    <h1><a href="plofile-index.html"><img class="logo" src="htimages/齋藤将平.pdf"></a></h1>
  <nav>
    <ul class="main-nav">
      <li><a href="plofile.html">Plofile</a></li>
      <li><a href="performance.html">Performance</a></li>
      <li><a href="hobby.html">Hobby</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
  </nav>
</header>
<div class="wrapper">
<h2 class="page-title">Contact</h2>
</div><!---/.wrapper --->
</div><!--- /#home -->



<?php if( $mode == 'input' ){ ?>
  <!-- 入力画面 -->
  <?php
    if( $errmessage ){
      echo '<div style="color:red;">';
      echo implode('<br>', $errmessage );
      echo '</div>';
    }
  ?>
  <div class="wrapper">
  <form action="./htcontact.php" method="post">
    <label for="name">お名前</label>
    <input type="text"    name="fullname" value="<?php echo $_SESSION['fullname'] ?>">
    <label for="name">email</label>
    <input type="email"   name="email"    value="<?php echo $_SESSION['email'] ?>">
    <label for="name">お問い合わせ内容</label>
    <textarea cols="40" rows="8" name="message"><?php echo $_SESSION['message'] ?></textarea><br>
    <input type="submit"  class="button" name="confirm" value="確認" />
  </form>
<?php } else if( $mode == 'confirm' ){ ?>
  <!-- 確認画面 -->
  <form action="./htcontact.php" method="post">
      名前 :   <?php echo $_SESSION['fullname'] ?><br>
      Eメール : <?php echo $_SESSION['email'] ?><br>
      お問い合わせ内容<br>
      <?php echo nl2br($_SESSION['message']) ?><br>
      <input type="submit" class="button" name="back" value="戻る" />
      <input type="submit" class="button" name="send" value="送信" />
  </form>
<?php } else { ?>
  <!-- 完了画面 -->
  送信しました。お問い合わせありがとうございました。<br>
<?php } ?>
</div>

<div class="logo-sns">
<h1><a href="https://www.facebook.com/profile.php?id=100022577121591"><img class="logosns" src="htimages/facebook.logo.png"></a></h1>
<h1><a href="https://twitter.com/saito3110sho"><img class="logosns" src="htimages/twitter.logo.png"></a></h1>
<h1><a href="https://www.instagram.com/sai.shooo"><img class="logosns" src="htimages/instagram.logo.png"></a></h1>
</div>

<footer>
  <div class="wrapper">
    <p><small>&copy; 2021 SAITO SHOHEI</small></p>
  </div>
</footer>
</body>

</html>
