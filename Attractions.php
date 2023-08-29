<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}

if (isset($_GET["search"])) {
    $sql = "select * from attractions where attname like '%" . $_GET["search"] . "%' ";
    $stmt = $pdo->prepare($sql); //like搜尋 %雙引號
    $stmt->execute();
    $rows = $stmt->fetchAll();
    $pages = ceil(count($rows) / 12); //全部頁數
} else if (!isset($_GET["search"])) {
    $sql = "select * from attractions";
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

//從第幾筆資料開始取12個資料

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="css/Attractions.css">
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
            <h1>景點搜尋</h1>
        </div>
        <div class="aa w-100 d-flex">
            <form action="Attractions.php" class="att-search w-100" method="get">

                <input type="text" size=100 placeholder="搜尋景點" class="att-text w-75" name="search" value="<?php if (!empty($_GET["search"])) {
                                                                                                                echo $_GET["search"];
                                                                                                            } ?>">
                <button class="att-btn w-auto"><i class="fa fa-search" aria-hidden="true"></i></button>
                <div class="dropdown d-flex align-items-center ms-2">
                    <div class="btn btn-success btn-lg px-4 fs-4" type="button" id="areadropdown" data-bs-toggle="dropdown">
                        地區 <i class="fa fa-filter fs-4 " aria-hidden="true"></i>
                    </div>
                    <ul class="dropdown-menu" style="width: 400px;">
                        <div class="row">
                            <?php
                            $stmt = $pdo->prepare("select * from attractions group by district");
                            $stmt->execute();
                            $row = $stmt->fetchAll();
                            foreach ($row as $d) {
                                echo '<li class="col-3 text-center mb-2"><a class="dropdown-item text-decoration-none w-100 fs-6" href="attarea.php?area=' . $d["district"] . '">' . $d["district"] . '</a></li>';
                            }
                            ?>
                        </div>
                    </ul>
                    <?php
                    if (isset($_SESSION["uname"])) {
                        if ($_SESSION["level"] == "admin") { ?>
                            <div class="btn btn-success btn-lg mx-2 px-4 fs-4"><a href="clickatt.php?insert='attraction'" style=color:white;text-decoration:none>新增</a>
                            </div>
                    <?php } else {
                        }
                    } ?>

                </div>
            </form>

        </div>
        <div class="card-group">
            <div class="row">

                <?php
                if (isset($_SESSION["uname"])) {
                    foreach ($rows as $r) {
                        if ($_SESSION["level"] == "admin") {
                            echo '<div class="col-sm-6 col-md-4 col-lg-3  card">
                    <a href="clickatt.php?attid=' . $r["id"] . '">
                        <img src="' . $r["imgs"] . '">
                        <div class="txt">
                            <p>' . $r["attname"] . '</p>
                        </div>
                    </a>
                    <form action="clickatt.php" method="post" style="display:flex; justify-content:flex-end" >
                      <input type="hidden" value="' . $r["id"] . '" name="attid">
                      <button style="border:1px solid black; padding:0px 10px; font-size:20px ">編輯</button>
                    </form>
                </div>';
                        } else {
                            echo '<div class="col-sm-6 col-md-4 col-lg-3  card">
                        <a href="clickatt.php?attid=' . $r["id"] . '">
                            <img src="' . $r["imgs"] . '">
                            <div class="txt">
                                <p>' . $r["attname"] . '</p>
                            </div>
                        </a>
                        </div>';
                        }
                    }
                } else {
                    foreach ($rows as $r) {
                        echo '<div class="col-sm-6 col-md-4 col-lg-3  card">
                    <a href="clickatt.php?attid=' . $r["id"] . '">
                        <img src="' . $r["imgs"] . '">
                        <div class="txt">
                            <p>' . $r["attname"] . '</p>
                        </div>
                    </a>
                    </div>';
                    }
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
                                if (!isset($_GET["search"])) {
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
                                <a class="page-link" href="?pgno=1&search=' . $_GET["search"] . '"> &lt;&lt; </a>
                                 </li>
                                <li class="page-item">
                                <a class="page-link" href="?pgno=' . $prevpage . '&search=' . $_GET["search"] . '"> &lt; </a>
                                 </li>';
                                    }
                                }
                                ?>
                                <li class="page-item">
                                    <?php
                                    if (!isset($_GET["search"])) {
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
                                                    echo '<li class="page-item active"><a class="page-link">' . $i . '</a></li>'; //取消超連結 //新增頁數
                                                } else {
                                                    echo '<li class="page-item"><a class="page-link" href="?pgno=' . $i . '&search=' . $_GET["search"] . '">' . $i . '</a></li>';
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </li>
                                <?php
                                if (!isset($_GET["search"])) {
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
                                <a class="page-link" href="?pgno=' . $nextpage . '&search=' . $_GET["search"] . '"> &gt; </a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="?pgno=' . $pages . '&search=' . $_GET["search"] . '"> &gt;&gt; </a>
                              </li>';
                                    }
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