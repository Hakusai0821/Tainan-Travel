<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}

session_start();
$uname = $_SESSION["uname"];
$goods_id = $_GET["goods_id"];
$goods_name = $_GET["goods_name"];
$goods_price = $_GET["goods_price"];
$goods_imgs = $_GET["goods_imgs"];

$stmt = $pdo->prepare("select * from buy_cart where gid=?");
$stmt->execute(array($goods_id));
$rows = $stmt->fetch();


if (isset($uname)) {
    if (isset($goods_id)) {
        if ($rows["gid"]) {
            $amount = $rows["amount"] + 1;
            $stmt = $pdo->prepare("update buy_cart set amount=? where gid=?");
            $res = $stmt->execute(array($amount, $goods_id));
            header("location:giftbuy.php");
        } else {
            $amount = 1;
            $stmt = $pdo->prepare("insert into buy_cart(gid,mid,bname,bprice,imgs,amount) values(?,?,?,?,?,?)");
            $stmt->execute(array($goods_id, $uname, $goods_name, $goods_price,  $goods_imgs, $amount));
            header("location:giftbuy.php");
        }
    }
} else {
    header("location:giftbuy.php");
}
