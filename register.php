<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>註冊會員</title>
</head>

<body>
    <?php
    //新增會員資料
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("insert into member(uname,upassword,uemail,utel,uaddress) values(?,?,?,?,?)");
        $res = $stmt->execute(array($_POST["uname"], $_POST["upassword"], $_POST["uemail"], $_POST["utelpgone"], $_POST["uaddress"]));
        if ($res) {
            echo '<div class="tip_success">
            <h1 class="success">註冊成功 !!</h1>
            <a href="login.php" class="login_back">返回</a>
        </div>';
        }
    } else {
    ?>
        <div class="register">
            <form action="" method="post" onsubmit="return formsubmit(this)">
                <h1>會員註冊</h1>
                <input type="text" placeholder="使用者名稱" name="uname"><span id="namewarn"></span>
                <input type="password" placeholder="密碼" name="upassword" id="password">
                <input type="password" placeholder="確認密碼" id="confirmpassword" onblur="confirmpwd()"><span id="hiddentext"></span>
                <input type="email" placeholder="email" name="uemail"><span id="emailwarn"></span>
                <input type="text" placeholder="電話" name="utelpgone"><span id="phonewarn"></span>
                <input type="address" placeholder="地址" name="uaddress"><span id="addresswarn"></span>
                <button id="btn_reg">確認</button>
            </form>

        </div>

    <?php } ?>




    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        //判斷密碼輸入一致
        function confirmpwd() {
            let pwd1 = document.getElementById("password").value;
            let pwd2 = document.getElementById("confirmpassword").value;

            if (pwd1 != "" && pwd2 != "" && pwd1 == pwd2) {
                document.getElementById("hiddentext").innerHTML = "<font color='#0c683d'>密碼一致</font>";
                document.getElementById("btn_reg").disabled = false;
            } else {
                document.getElementById("hiddentext").innerHTML = "<font color='red'>密碼輸入錯誤</font>";
                document.getElementById("btn_reg").disabled = true;
            }
        }

        function formsubmit(form) {
            let name = form.uname.value;
            let email = form.uemail.value;
            let phone = form.utelpgone.value;
            let address = form.uaddress.value;

            if (name == "") {
                document.getElementById("namewarn").innerHTML = "<font color='red'>此欄位不能為空</font>";
                form.uname.focus();
                return false;
            } else {
                document.getElementById("namewarn").innerHTML = "";
            }

            if (email == "") {
                document.getElementById("emailwarn").innerHTML = "<font color='red'>此欄位不能為空</font>";
                form.uemail.focus();
                return false;
            } else {
                document.getElementById("emailwarn").innerHTML = "";
            }

            if (phone == "") {
                document.getElementById("phonewarn").innerHTML = "<font color='red'>此欄位不能為空</font>";
                form.utelpgone.focus();
                return false;
            } else {
                document.getElementById("phonewarn").innerHTML = "";
            }

            if (email == "") {
                document.getElementById("addresswarn").innerHTML = "<font color='red'>此欄位不能為空</font>";
                form.uaddress.focus();
                return false;
            } else {
                document.getElementById("addresswarn").innerHTML = "";
            }

            return true;
        }
    </script>
</body>

</html>