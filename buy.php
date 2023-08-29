<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}

session_start();
// $arr = $_SESSION['shop_cart'];
$stmt = $pdo->prepare("select * from buy_cart where mid=?");
$stmt->execute(array($_SESSION["uname"]));
$rows = $stmt->fetchAll();
$total = count($rows);

if (isset($_GET["goods_id"])) {
    $stmt = $pdo->prepare("delete from buy_cart where gid=?");
    $stmt->execute(array($_GET["goods_id"]));
    header("location:buy.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/buy.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
            <div class="container title">
                <p>購物車</p>
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
    <?php if (isset($_SESSION["uname"])) { ?>
        <div class="container buy">
            <div class="row goods-title">
                <div class="col-4 product">商品</div>
                <div class="col-2 price">單價</div>
                <div class="col-2 amount">數量</div>
                <div class="col-2 total1">總計</div>
                <div class="col-2 oper">操作</div>
            </div>
            <?php $total1 = 0;
            foreach ($rows as $r) { ?>
                <form action="" class="d-flex list">
                    <div class="row goods-content mt-4">
                        <div class="col-4 product d-flex align-items-center">
                            <div class="buy_img"><img src="<?php echo $r["imgs"] ?>"></div>
                            <p><?php echo $r["bname"] ?></p>
                        </div>
                        <div class="col-2 price1 d-flex align-items-center justify-content-end">
                            <span>$</span>
                            <span class="price2"><?php echo $r["bprice"] ?></span>
                        </div>
                        <div class="col-2 amount d-flex align-items-center justify-content-end">
                            <input class="amount2" type="text" value=<?php echo $r["amount"] ?>>
                        </div>
                        <div class="col-2 total d-flex align-items-center justify-content-end"> <?php echo $r["amount"] * $r["bprice"] ?></div>
                        <div class="col-2 oper d-flex align-items-center justify-content-end"><a href="buy.php?goods_id=<?php echo $r["gid"] ?>" class="delete">刪除</a></div>
                    </div>
                </form>
            <?php $total1 += $r["amount"] * $r["bprice"];
            } ?>
        </div>

    <?php } else { ?>
        <div class="content">
            <p class="tip">請登入會員</p>
            <a href="login.php" class="exit"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>會員登入</a>
        </div>

    <?php } ?>

    <?php if ($total > 0) { ?>
        <div class="checkout-buy">
            <div class="container checkout">
                <div class="row goods-checkout">
                    <div class="col go-buy">
                        <form action="shop_finish.php" method="post" class="d-flex align-items-center">
                            <?php foreach ($rows as $val) { ?>
                                <input type="hidden" name="goods_id[]" value="<?php echo $val["gid"] ?>">
                                <input type="hidden" name="goods_name[]" value="<?php echo $val["bname"] ?>">
                                <input type="hidden" name="goods_num[]" value="<?php echo $val["amount"] ?>">
                                <input type="hidden" name="goods_price[]" value="<?php echo $val["bprice"] ?>">
                                <input type="hidden" name="goods_img[]" value="<?php echo $val["imgs"] ?>">
                            <?php } ?>


                            <div class="total_price d-flex align-items-center">
                                <span>總金額:</span>
                                <span class="total_price2"><?php echo "$" . $total1 ?></span>
                            </div>
                            <button class="go">
                                <span>去結帳</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else {
    } ?>
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
    <script>
        // $(function() {
        //     // var goods_price = parseInt($(".add").parent().parent().children(".price1").children(".price2").text());
        //     // var q = parseInt($(".add").parent().children(".amount2").val());
        //     // $(".total").text("$" + goods_price * q);
        //     $(".add").click(function() {
        //         var t = $(this).parent().children(".amount2");
        //         t.val(parseInt(t.val()) + 1);
        //         setTotal();
        //         // var goods_price = parseInt($(this).parent().parent().children(".price1").children(".price2").text());
        //         // var q = parseInt($(this).parent().children(".amount2").val());
        //         // $(".total").text("$" + goods_price * q);
        //     });

        //     $(".min").click(function() {
        //         var t = $(this).parent().children(".amount2");
        //         t.val(parseInt(t.val()) - 1);
        //         // var goods_price = parseInt($(this).parent().parent().children(".price1").children(".price2").text());
        //         // var q = parseInt($(this).parent().children(".amount2").val());
        //         if (parseInt(t.val()) < 1) {
        //             t.val(1)
        //         }
        //         setTotal();
        //         //  else {
        //         //     // $(".total").text("$" + goods_price * q);
        //         // }
        //     });

        //     function setTotal() {
        //         var s = 0;
        //         $(".goods-content").each(function() {
        //             s += parseInt($(this).children(".amount").children(".amount2").val()) *
        //                 parseInt($(this).children(".price1").children(".price2").text());
        //         });
        //         $(".total_price2").html(s);
        //     }
        //     setTotal();
        // })
    </script>
</body>

</html>