<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES["progressbarTW_img"]["error"] > 0) {
        echo "Error:" . $_FILES["progressbarTW_img"]["error"];
    } else {
        echo "檔案名稱:" . $_FILES["progressbarTW_img"]["name"] .
            "<br/>";
        echo "檔案類型:" . $_FILES["progressbarTW_img"]["type"] .
            "<br/>";
        echo "檔案大小:" . ($_FILES["progressbarTW_img"]["size"] / 1024) . "Kb<br/>";
        echo "暫存名稱:" . $_FILES["progressbarTW_img"]["tmp_name"];

        if (file_exists("upload/" . $_FILES["progressbarTW_img"]["name"])) {
            echo "檔案已存在，請勿重複上船相同檔案";
        } else {
            $file = $_FILES["progressbarTW_img"]["tmp_name"];
            $target_path = "upload/" . $_FILES["progressbarTW_img"]["name"];

            if (move_uploaded_file($file, iconv("UTF-8", "big5", $target_path))) {
                echo "檔案:" . $_FILES["progressbarTW_img"]["name"] . "上傳成功";
            } else {
                echo "檔案上傳失敗，請在試一次!";
            }
        }
    }
    
    $file="upload/" . $_FILES["progressbarTW_img"]["name"];
    $stmt = $pdo->prepare("update member set mname=?,gender=?,birthday=?,img=? where uname=?");
    $update = $stmt->execute(array($_POST["yourname"], $_POST["gender"], $_POST["birthday"], $file, $_POST["uname"]));
    if ($update) {
        header('location:member.php');
        exit();
    }
}
