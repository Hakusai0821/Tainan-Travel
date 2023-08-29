<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
session_start();

if (isset($_GET["fcetegory"])) {
    $sql = "select * from giftbuy where fcetegory like '%" . $_GET["fcetegory"] . "%' ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $pages = ceil(count($rows) / 12); //全部頁數
} else if (!isset($_GET["fcetegory"])) {
    $sql = "select * from giftbuy";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $pages = ceil(count($rows) / 12); //全部頁數
}

if (!isset($_GET["pgno"])) {
    $pgno = 1;
} else {
    $pgno = $_GET["pgno"];
}
$prevpage = $pgno - 1;
$nextpage = $pgno + 1;

$stmt = $pdo->prepare($sql . " limit " . (($pgno - 1) * 12) . ",12");
$stmt->execute();
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <link rel="stylesheet" href="css/giftbuy.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="small-header">
            <nav>
                <?php
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
            </div>
        </div>
    </header>

    <div class="container buy">
        <div class="row justify-content-center ">
            <div class="row justify-content-center mb-3 mt-3">
                <div class="col btn bcet">
                    <a href="giftbuy.php?fcetegory=花生糖">花生糖 <i class="fa fa-filter " aria-hidden="true"></i></a>
                </div>
                <div class="col btn bcet">
                    <a href="giftbuy.php?fcetegory=鳳梨酥">鳳梨酥 <i class="fa fa-filter " aria-hidden="true"></i></a>
                </div>
                <div class="col btn bcet">
                    <a href="giftbuy.php?fcetegory=甜品">甜品 <i class="fa fa-filter " aria-hidden="true"></i></a>
                </div>
                <div class="col btn bcet">
                    <a href="giftbuy.php?fcetegory=蜜餞">蜜餞 <i class="fa fa-filter " aria-hidden="true"></i></a>
                </div>
                <div class="col btn bcet">
                    <a href="giftbuy.php?fcetegory=餅乾">餅乾<i class="fa fa-filter " aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php
                foreach ($rows as $r) {
                    echo '<div class="col-sm-6 col-md-4 col-lg-3 buy-card">
                    <div class="buy-img">
                        <img src="' . $r["imgs"] . '">
                    </div>
                    <div class="buy-name">
                        <div class="fname">
                            ' . $r["fname"] . '
                        </div>
                        <div class="price">
                            $ ' . $r["price"] . '
                        </div>
                        <a href="buy_cart2.php?goods_id=' . $r["gid"] . '&goods_name=' . $r["fname"] . '&goods_price=' . $r["price"] . '&goods_imgs=' . $r["imgs"] . '" class="buy-btn">
                            購買
                        </a>
                    </div>
                </div>';
                }
                ?>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <nav class="Page d-flex justify-content-center">
                        <ul class="pagination">
                            <?php
                            if (!isset($_GET["fcetegory"])) {
                                if ($pgno == 1) {
                                    echo '<li class="page-item">
                                   <a class="page-link"> &lt;&lt; </a>
                                    </li>
                                   <li class="page-item">
                                   <a class="page-link"> &lt; </a>
                                    </li>';
                                } else {
                                    echo '<li class="page-item">
                                    <a class="page-link" href="?pgno=1"> &lt;&lt; </a>
                                     </li>
                                    <li class="page-item">
                                    <a class="page-link" href="?pgno=' . $prevpage . '"> &lt; </a>
                                     </li>';
                                }
                            } else {
                                if ($pgno == 1) {
                                    echo '<li class="page-item">
                               <a class="page-link"> &lt;&lt; </a>
                                </li>
                               <li class="page-item">
                               <a class="page-link"> &lt; </a>
                                </li>';
                                } else {
                                    echo '<li class="page-item">
                                <a class="page-link" href="?pgno=1&fcetegory=' . $_GET["fcetegory"] . '"> &lt;&lt; </a>
                                 </li>
                                <li class="page-item">
                                <a class="page-link" href="?pgno=' . $prevpage . '&fcetegory=' . $_GET["fcetegory"] . '"> &lt; </a>
                                 </li>';
                                }
                            }
                            ?>
                            <li class="page-item">
                                <?php
                                if (!isset($_GET["fcetegory"])) {
                                    for ($i = 1; $i <= $pages; $i++) {
                                        if ($pgno - 3 < $i && $i < $pgno + 3) {
                                            if ($i == $pgno) {
                                                echo '<li class="page-item active"><a class="page-link">' . $i . '</a></li>';
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="?pgno=' . $i . '">' . $i . '</a></li>';
                                            }
                                        }
                                    }
                                } else {
                                    for ($i = 1; $i <= $pages; $i++) {
                                        if ($pgno - 3 < $i && $i < $pgno + 3) {
                                            if ($i == $pgno) {
                                                echo '<li class="page-item active"><a class="page-link">' . $i . '</a></li>';
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="?pgno=' . $i . '&fcetegory=' . $_GET["fcetegory"] . '">' . $i . '</a></li>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </li>
                            <?php
                            if (!isset($_GET["fcetegory"])) {
                                if ($pgno == $pages) {
                                    echo '<li class="page-item">
                                                <a class="page-link"> &gt; </a>
                                              </li>
                                              <li class="page-item">
                                                <a class="page-link"> &gt;&gt; </a>
                                              </li>';
                                } else {
                                    echo '<li class="page-item">
                                    <a class="page-link" href="?pgno=' . $nextpage . '"> &gt; </a>
                                  </li>
                                  <li class="page-item">
                                    <a class="page-link" href="?pgno=' . $pages . '"> &gt;&gt; </a>
                                  </li>';
                                }
                            } else {
                                if ($pgno == $pages) {
                                    echo '<li class="page-item">
                                            <a class="page-link"> &gt; </a>
                                          </li>
                                          <li class="page-item">
                                            <a class="page-link"> &gt;&gt; </a>
                                          </li>';
                                } else {
                                    echo '<li class="page-item">
                                <a class="page-link" href="?pgno=' . $nextpage . '&fcetegory=' . $_GET["fcetegory"] . '"> &gt; </a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="?pgno=' . $pages . '&fcetegory=' . $_GET["fcetegory"] . '"> &gt;&gt; </a>
                              </li>';
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 d-flex align-items-end justify-content-end mb-2">
                    <div class="page">
                        <?php
                        echo "第" . $pgno . "頁 / 共" . $pages . "頁";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- 頁尾 -->
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