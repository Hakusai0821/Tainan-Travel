<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
session_start();
$uname = $_SESSION["uname"];
$stmt = $pdo->prepare("select * from user_order where mid=?");
$stmt->execute(array($uname));
$row = $stmt->fetchAll();
$num = count($row);

$stmt1 = $pdo->prepare("select * from member where uname=?");
$stmt1->execute(array($uname));
$row1 = $stmt1->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/member_buy.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="small-header">
            <nav>
                <?php
                if (isset($uname)) {
                    echo '<font color=#fff>' . $_SESSION["uname"] . '</font><a href="logout.php">登出</a>';
                } else {
                ?>
                    <a href="login.php">登入</a>
                    <a href="register.php">註冊</a>
                <?php } ?>
            </nav>
        </div>
        <div class="main-header">
            <div class="container title">
                <p>會員中心</p>
                <ul class="nav ">
                    <li><a href="Attractions.php"><i class="fa fa-camera" aria-hidden="true"></i>
                            景點</a></li>
                    <li><a href="food.php"><i class="fa fa-cutlery" aria-hidden="true"></i>
                            美食</a></li>
                    <li><a href="giftbuy.php"><i class="fa fa-suitcase" aria-hidden="true"></i>
                            購物</a></li>
                    <li><a href="member.php"><i class="fa fa-user" aria-hidden="true"></i>
                            會員</a></li>
                </ul>
            </div>
        </div>
    </header>
    <?php if (isset($uname)) { ?>
        <main>
            <article>
                <div class="member">

                    <div class="member-img">
                        <?php if ($row1["img"] == "upload/" || $row1["img"] == "") { ?>
                            <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                            <img src="">
                        <?php } else { ?>
                            <img src="<?php echo $row1["img"] ?>">
                        <?php } ?>
                    </div>
                    <p class="member-name">jankid</p>
                </div>
                <h4><a href="member.php">編輯會員簡介</a></h4>
                <h4><a href="">購買清單</a></h4>
            </article>

            <aside>
                <h2>購買清單</h2>
                <?php if ($num > 0) { ?>
                    <div class="buy_list">
                        <div class="list">
                            <?php foreach ($row as $r) { ?>
                                <div class="list_goods">
                                    <div class="list_img">
                                        <img src="<?php echo $r["imgs"] ?>">
                                    </div>
                                    <div class="list_goodsname">
                                        <?php echo $r["bname"] ?>
                                    </div>
                                    <div class="list_price">
                                        <?php echo $r["bprice"] ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="list_total">
                                <label>總金額：</label>
                                <p><?php echo $r["total"] ?></p>
                            </div>
                            <div class="again">
                                <a href="giftbuy.php">再買一次</a>
                            </div>
                            <p class="date">日期:<?php echo date($r["date"]) ?></p>
                        </div>
                    </div>
                <?php } else {
                } ?>
            </aside>
        </main>


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
    <?php } else {
        echo "<script>alert('請先登入會員'); location.href = 'login.php';</script>";
    } ?>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>

</html>