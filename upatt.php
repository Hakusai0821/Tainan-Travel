<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES["broimg"]["error"] == 0) {
        echo "檔案名稱:" . $_FILES["broimg"]["name"] .
            "<br/>";
        echo "檔案類型:" . $_FILES["broimg"]["type"] .
            "<br/>";
        echo "檔案大小:" . ($_FILES["broimg"]["size"] / 1024) . "Kb<br/>";
        echo "暫存名稱:" . $_FILES["broimg"]["tmp_name"];

        if (file_exists("upload/" . $_FILES["broimg"]["name"])) {
            echo "檔案已存在，請勿重複上傳相同檔案";
        } else {
            $file = $_FILES["broimg"]["tmp_name"];
            $target_path = "upload/" . $_FILES["broimg"]["name"];
            if (move_uploaded_file($file, $target_path)) {
                echo "檔案:" . $_FILES["broimg"]["name"] . "上傳成功";
            } else {
                echo "檔案上傳失敗，請在試一次!";
            }
        }
        $flie = "upload/" . $_FILES["broimg"]["name"];
        $stmt = $pdo->prepare("update attractions set attname=?,broimgs=?,summary=?,intro=?,opentime=?,district=?,address=?,tel=?,latitude=?,longitude=? where id=?");
        $stmt->execute(array($_POST["attname"], $flie, $_POST["summary"], $_POST["intro"], $_POST["opentime"], $_POST["district"], $_POST["address"], $_POST["tel"], $_POST["lat"], $_POST["log"], $_POST["id"]));
        echo "<script>alert('編輯成功'); location.href='Attractions.php'</script>";
    } else {
        $stmt = $pdo->prepare("update attractions set attname=?,summary=?,intro=?,opentime=?,district=?,address=?,tel=?,latitude=?,longitude=? where id=?");
        $stmt->execute(array($_POST["attname"], $_POST["summary"], $_POST["intro"], $_POST["opentime"], $_POST["district"], $_POST["address"], $_POST["tel"], $_POST["lat"], $_POST["log"], $_POST["id"]));
        echo "<script>alert('編輯成功'); location.href='Attractions.php'</script>";
    }
}
