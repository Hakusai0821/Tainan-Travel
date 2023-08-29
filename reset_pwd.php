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
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
    <style>
        .success {
            font-size: 60px;
            font-weight: 900;
            color: rgb(255, 255, 255);
        }

        .login_back {
            background-color: #14ae67;
            font-size: 30px;
            padding: 10px;
            margin-top: 30px;
            width: 100px;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: 600;
        }

        .login_back:hover {
            background-color: #129256;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        if (isset($_POST["password"]) || isset($_POST["repassword"])) {
            $stmt = $pdo->prepare("update member set upassword=? where uemail=?");
            $update = $stmt->execute(array($_POST["repassword"], $_GET["email"]));
            if ($update) {
                echo ' <div class="tip_success">
                <h1 class="success">密碼修改完成 !!</h1>
                <a href="login.php" class="login_back">返回</a>
            </div>';
            }
        }
    } else {
    ?>
        <div class="login">
            <form action="" method="post" onsubmit="return updatepwd(this)">
                <h1>密碼重置</h1>
                <div class="member">
                    <label for="">輸入新密碼</label>
                    <input type="password" placeholder="請輸入新密碼" name="password" id="password">
                </div>
                <div class="member">
                    <label for="">確認新密碼</label>
                    <input type="password" placeholder="確認新密碼" name="repassword" id="repassword">
                </div>

                <div class="btn-member">
                    <span id=tip style="color: red;font-size:20px"></span>
                    <button class="sign" name="sign">確定</button>
                </div>
            </form>
        </div>
    <?php } ?>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function updatepwd(form) {
            let pwd = form.password.value;
            let repwd = form.repassword.value;
            if (pwd == "" || repwd == "") {
                document.getElementById("tip").innerHTML = "<font color='red'>請輸入密碼</font>";
                form.password.focus();
                form.repassword.focus();
                return false;
            } else {
                document.getElementById("tip").innerHTML = "";
            }
            if (pwd != repwd) {
                document.getElementById("tip").innerHTML = "<font color='red'>密碼不一致</font>"
                form.password.focus();
                form.repassword.focus();
                return false;
            } else {
                document.getElementById("tip").innerHTML = "";
            }
        }
    </script>
</body>

</html>