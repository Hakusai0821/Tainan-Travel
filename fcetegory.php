<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}

if (isset($_GET["fclass"])) {
    $sql = "select * from food where category like '%" . $_GET["fclass"] . "%' ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $pages = ceil(count($rows) / 12);
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
    <link rel="stylesheet" href="css/food.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <title>Document</title>
    <style>
        .dropdown-item {
            font-family: "微軟正黑體";
            font-weight: 800;

        }
    </style>
</head>

<body>


    <!-- 導覽頁 -->
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
                <form action="" class="search">
                    <input type="search">
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </header>
    <!-- 滿版圖片 -->
    <div class="warp-img">

        <img src="https://picsum.photos/1200/300/?random=1">
    </div>

    <!-- 景點搜尋 -->
    <div class="container attractions">
        <div class="txt">
            <h1>美食-盡情凌辱您的味蕾</h1>
        </div>
        <div class="aa w-100 d-flex">
            <form action="food.php" class="att-search w-100" method="get">

                <input type="text" size=100 placeholder="搜尋美食" class="att-text w-75" name="food-search" value="<?php if (!empty($_GET["food-search"])) {
                                                                                                                    echo $_GET["food-search"];
                                                                                                                } ?>">
                <button class="att-btn w-auto"><i class="fa fa-search" aria-hidden="true"></i></button>
                <div class="dropdown d-flex align-items-center ms-2">
                    <div class="btn  btn-lg px-4 fs-4" type="button" id="areadropdown" data-bs-toggle="dropdown" style="background-color:  rgb(231, 156, 59); color:white; font-weight: 900;">
                        地區 <i class="fa fa-filter fs-4 " aria-hidden="true"></i>
                    </div>
                    <ul class="dropdown-menu" style="width: 400px;">
                        <div class="row">
                            <?php
                            $stmt = $pdo->prepare("select * from food group by fdistrict");
                            $stmt->execute();
                            $row = $stmt->fetchAll();
                            foreach ($row as $d)

                                echo '<li class="col-3 text-center mb-2"><a class="dropdown-item text-decoration-none w-100 fs-6" href="farea.php?area=' . $d["fdistrict"] . '">' . $d["fdistrict"] . '</a></li>'
                            ?>
                        </div>

                    </ul>
                </div>
            </form>

        </div>
        <div class="row w-100">
            <?php

            $fcet = array("中式美食", "伴手好禮", "安心餐廳", "咖啡茶鋪", "飲料冰品", "景觀餐廳", "異國料理", "農產好物", "其他美食");
            for ($i = 0; $i < count($fcet); $i++) {
                echo '<div class="btn col fcet">
    <a href="fcetegory.php?fclass=' . $fcet[$i] . '">' . $fcet[$i] . '<i class="fa fa-filter " aria-hidden="true"></i></a>
</div>';
            }
            ?>
        </div>
        <div class="card-group">
            <div class="row">
                <?php
                foreach ($rows as $r) {
                    echo '<div class="col-sm-6 col-md-4 col-lg-3  card">
                    <a href="clickfood.php?foodid=' . $r["id"] . '">
                        <img src="' . $r["imgs"] . '">
                        <div class="txt">
                            <p>' . $r["fname"] . '</p>
                        </div>
                    </a>
                </div>';
                }
                ?>
            </div>
            <!-- 頁數 -->
            <?php if ($pages > 1) { ?>
                <div class="row">
                    <div class="col-12">
                        <nav class="Page d-flex justify-content-center">
                            <ul class="pagination">
                                <?php
                                if ($pgno == 1) {
                                    echo '<li class="page-item">
                               <a class="page-link"> &lt;&lt; </a>
                                </li>
                               <li class="page-item">
                               <a class="page-link"> &lt; </a>
                                </li>';
                                } else {
                                    echo '<li class="page-item">
                                <a class="page-link" href="?pgno=1&fclass=' . $_GET["fclass"] . '"> &lt;&lt; </a>
                                 </li>
                                <li class="page-item">
                                <a class="page-link" href="?pgno=' . $prevpage . '&fclass=' . $_GET["fclass"] . '"> &lt; </a>
                                 </li>';
                                }
                                ?>
                                <li class="page-item">
                                    <?php
                                    for ($i = 1; $i <= $pages; $i++) {
                                        if ($pgno - 3 < $i && $i < $pgno + 3) {
                                            if ($i == $pgno) {
                                                echo '<li class="page-item active"><a class="page-link">' . $i . '</a></li>';
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="?pgno=' . $i . '&fclass=' . $_GET["fclass"] . '">' . $i . '</a></li>';
                                            }
                                        }
                                    }

                                    ?>
                                </li>
                                <?php
                                if ($pgno == $pages) {
                                    echo '<li class="page-item">
                                            <a class="page-link"> &gt; </a>
                                          </li>
                                          <li class="page-item">
                                            <a class="page-link"> &gt;&gt; </a>
                                          </li>';
                                } else {
                                    echo '<li class="page-item">
                                <a class="page-link" href="?pgno=' . $nextpage . '&fclass=' . $_GET["fclass"] . '"> &gt; </a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="?pgno=' . $pages . '&fclass=' . $_GET["fclass"] . '"> &gt;&gt; </a>
                              </li>';
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-12 d-flex align-items-end justify-content-end">
                        <div class="page">
                            <?php
                            echo "第" . $pgno . "頁 / 共" . $pages . "頁";
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
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