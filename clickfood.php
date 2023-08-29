<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
if (isset($_GET["foodid"])) {
    $stmt = $pdo->prepare("select * from food where id=?");
    $stmt->execute(array($_GET["foodid"]));
    $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <link rel="stylesheet" href="css/clickfood.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>美食</title>
</head>

<body>
    <header>
        <div class="small-header">
            <nav>
                <?php
                session_start();
                if (isset($_SESSION["uname"])) {
                    echo '<font color=#fff>' . $_SESSION["uname"] . '</font><a href="logout.php">登出</a>';
                } else {
                ?>
                    <a href="login.php">登入</a>
                    <a href="register.php">註冊</a>
                <?php } ?>
                <a href="buy.php">購物車</a>
            </nav>
        </div>
        <div class="main-header">
            <div class="container">
                <a href="index.php" class="logo">
                    <img src="imgs/大頑台南LOGO.png">
                </a>
                <ul class="nav">
                    <li><a href="Attractions.php"><i class="fa fa-camera" aria-hidden="true"></i>景點</a></li>
                    <li><a href="food.php"><i class="fa fa-cutlery" aria-hidden="true"></i>美食</a></li>
                    <li><a href="giftbuy.php"><i class="fa fa-suitcase" aria-hidden="true"></i>購物</a></li>
                    <li><a href="member.php"><i class="fa fa-user" aria-hidden="true"></i>會員</a></li>
                </ul>
                <form action="" class="search">
                    <input type="search">
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </header>

    <div class="foodwindow">
        <h1 class="foodname"><?php echo $row["fname"] ?></h1>
        <div class="food_summary">
            <h2>美食簡介</h2>
            <div class="foodimg">
                <img src="<?php echo $row["broimgs"] ?>">
            </div>
            <div class="summary">
                <?php echo $row["fsummary"] ?>
            </div>
        </div>
        <div class="food_intro">
            <h2>美食介紹</h2>
            <div class="intro">
                <?php echo nl2br($row["fintro"]) ?>
            </div>
        </div>
        <div class="food_info">
            <h2>美食資訊</h2>
            <div class="opentime">
                <?php
                if ($row["fopentime"] == "") {
                } else {
                    echo '<h3>開放時間</h3> <p>' . $row["fopentime"] . '</p>';
                }
                ?>
            </div>
            <div class="area">
                <h3>地區</h3>
                <p><?php echo $row["fdistrict"] ?></p>
            </div>
            <div class="address">
                <h3>地址</h3>
                <p> <?php echo $row["faddress"] ?></p>z
            </div>
            <div class="telphone">
                <h3>電話</h3>
                <p> <?php echo $row["ftel"] ?></p>
            </div>
        </div>
        <h2 class="map_title">美食位置</h2>
        <span>

            <iframe class="map" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCD_g150I_AdA_1ggRH0VBRDmI7LXZlXUo&q=<?php echo $row["flatitude"]; ?>,<?php echo $row["flongitude"]; ?>&zoom=16" allowfullscreen>
            </iframe>
        </span>
    </div>

    <div class="footer">
        <div class="footer-container">
            <div class="txt1 order-2">
                <h3>組員：</h3>
                <p>劉起嘉、范綱勝、呂俊廷、蕭清文</p>
            </div>
            <div class="txt2 order-1">
                <h3>學校：</h3>
                <p>南台科技大學</p>
            </div>
        </div>
        <div class="copyright">
            Copyright &COPY; 2021 台南遊
        </div>
    </div>


    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>