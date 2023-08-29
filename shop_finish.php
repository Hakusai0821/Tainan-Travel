<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
session_start();
$uname = $_SESSION["uname"];
$stmt = $pdo->prepare("select * from shop_finish");
$stmt->execute();
$rows = $stmt->fetchAll();
$num_rows = count($rows);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($uname)) {
        foreach ($_POST["goods_id"] as $k => $v) {
            if (isset($_POST["goods_id"][$k])) {
                $goods_id =  $_POST["goods_id"][$k];
                $goods_name =  $_POST["goods_name"][$k];
                $goods_num = $_POST["goods_num"][$k];
                $goods_price =  $_POST["goods_price"][$k];
                $goods_img =  $_POST["goods_img"][$k];
                if ($num_rows == 0) {
                    $stmt = $pdo->prepare("insert into shop_finish(gid,mid,bname,amount,bprice,imgs) values(?,?,?,?,?,?)");
                    $add = $stmt->execute(array($goods_id, $uname, $goods_name, $goods_num, $goods_price, $goods_img));
                    if ($add) {
                        $stmt = $pdo->prepare("select * from shop_finish where mid=?");
                        $stmt->execute(array($_SESSION["uname"]));
                        $rows = $stmt->fetchAll();
                    }
                } else if ($num_rows > 0) {
                    $amount = $goods_num + 1;
                    $stmt = $pdo->prepare("update shop_finish set amount=? where gid=?");
                    $update = $stmt->execute(array($amount, $goods_id));
                    if ($update) {
                        $stmt = $pdo->prepare("select * from shop_finish where mid=?");
                        $stmt->execute(array($_SESSION["uname"]));
                        $rows = $stmt->fetchAll();
                    }
                }
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shop_finish.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
            </nav>
        </div>
        <div class="main-header">
            <div class="container title">
                <p>結帳</p>
                <ul class="nav ">
                    <li><a href="Attractions.php"><i class="fa fa-camera" aria-hidden="true"></i>
                            景點</a></li>
                    <li><a href="food.php"><i class="fa fa-cutlery" aria-hidden="true"></i>
                            美食</a></li>
                    <li><a href="giftbuy.php"><i class="fa fa-suitcase" aria-hidden="true"></i>
                            購物</a></li>
                    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>
                            會員</a></li>
                </ul>

            </div>
        </div>
    </header>
    <?php if (isset($_SESSION["uname"])) { ?>
        <main>
            <form action="order.php" method="post">
                <div class="container">
                    <div class="row order">
                        <div class="order_title">
                            <div class="col-6 order-name">訂單商品</div>
                            <div class="col-2 order-price">單價</div>
                            <div class="col-2 order-amount">數量</div>
                            <div class="col-2 order-stotal">總計</div>
                        </div>
                        <?php $total = 0;
                        foreach ($rows as $r) { ?>
                            <div class="order-content">
                                <div class="col-6 order-name2">
                                    <div class="order-img">
                                        <img src="<?php echo $r["imgs"] ?>">
                                    </div>
                                    <p><?php echo $r["bname"] ?></p>
                                </div>
                                <div class="col-2 order-price2"><?php echo "$" . " " . $r["bprice"] ?></div>
                                <div class="col-2 order-amount2"><?php echo $r["amount"] ?></div>
                                <div class="col-2 order-stotal2"><?php echo "$" . " " . $r["amount"] * $r["bprice"] ?></div>
                            </div>

                        <?php $total += $r["amount"] * $r["bprice"];
                        } ?>
                    </div>

                    <div class="info">

                        <div class="row">
                            <div class="col-6 orderer-info">
                                姓名<input type="text" name="orderer_infoname">
                                手機<input type="text" name="orderer_infophone">
                                電子信箱<input type="email" name="orderer_infoemail">
                            </div>
                            <div class="col-6 orderer-address">
                                收件人<input type="text" name="orderer_addname">
                                連絡電話<input type="text" name="orderer_addphone">
                                電子信箱<input type="text" name="orderer_addemail">

                                收件人地址
                                <div id="twzipcode">
                                </div>
                                <input type="text" name="orderer_add" style="width: 100%;">
                            </div>
                        </div>
                        <div class="checkout-buy">
                            <div class="row goods-checkout">
                                <div class="col go-buy">

                                    <?php foreach ($rows as $val) { ?>
                                        <input type="hidden" name="goods_id[]" value="<?php echo $val["gid"] ?>">
                                        <input type="hidden" name="goods_name[]" value="<?php echo $val["bname"] ?>">
                                        <input type="hidden" name="goods_num[]" value="<?php echo $val["amount"] ?>">
                                        <input type="hidden" name="goods_price[]" value="<?php echo $val["bprice"] ?>">
                                        <input type="hidden" name="goods_stotal[]" value="<?php echo $val["amount"] * $val["bprice"] ?>">
                                        <input type="hidden" name="goods_img[]" value="<?php echo $val["imgs"] ?>">
                                    <?php } ?>
                                    <input type="hidden" name="goods_total" value="<?php echo $total; ?>">
                                    <div class="d-flex align-items-center">
                                        <div class="total_price d-flex align-items-center">
                                            <span>總金額:</span>
                                            <span class="total_price2"><?php echo "$" . $total ?></span>
                                        </div>
                                        <button class="go">
                                            <span>下訂單</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </main>

    <?php } else { ?>
        echo "<script>
            alert('請先登入會員');
            location.href = 'login.php';
        </script>";
    <?php } ?>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-twzipcode@1.7.14/jquery.twzipcode.min.js"></script>
    <script>
        $("#twzipcode").twzipcode({
            css: ["city", "area", "zip"],
            readonly: true
        });
    </script>
</body>

</html>