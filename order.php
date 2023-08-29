<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
$stmt = $pdo->prepare("select * from user_order");
$stmt->execute();
$rows = $stmt->fetchAll();
$num_rows = count($rows);

$uname = $_SESSION["uname"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($uname)) {
        foreach ($_POST["goods_id"] as $k => $v) {
            if (isset($_POST["goods_id"][$k])) {
                $goods_id =  $_POST["goods_id"][$k];
                $goods_name =  $_POST["goods_name"][$k];
                $goods_num = $_POST["goods_num"][$k];
                $goods_price =  $_POST["goods_price"][$k];
                $goods_stotal = $_POST["goods_stotal"][$k];
                $goods_img = $_POST["goods_img"][$k];
                $goods_total = $_POST["goods_total"];
                $city = $_POST["county"];
                $area = $_POST["district"];
                $zip = $_POST["zipcode"];
                if ($num_rows >= 0) {
                    $stmt = $pdo->prepare("insert into user_order(mid,gid,bname,bprice,amount,stotal,total,oname,ophone,oemail,oname2,ophone2,oemail2,oaddress,city,area,zip,imgs) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($uname, $goods_id, $goods_name, $goods_price, $goods_num, $goods_stotal, $goods_total, $_POST["orderer_infoname"], $_POST["orderer_infophone"], $_POST["orderer_infoemail"], $_POST["orderer_addname"], $_POST["orderer_addphone"], $_POST["orderer_addemail"], $_POST["orderer_add"], $city, $area, $zip, $goods_img));
                }
            }
        }
        $stmt = $pdo->prepare("delete from buy_cart where mid=?");
        $stmt->execute(array($uname));
        $rows = $stmt->fetchAll();
        header('location:member.php');
        exit();
    }
}
