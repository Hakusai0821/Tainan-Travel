<?php
$pdo = mysqli_connect('localhost', 'root', '', 'travel');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>會員登入</title>
</head>

<body>

    <?php
    //會員登入
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["sign"])) {
            $uname = $_POST["uname"];
            $upassword = $_POST["upassword"];
            $stmt = "select * from member where uname='$uname'and upassword='$upassword'";
            $ro = mysqli_query($pdo, $stmt);
            $row = mysqli_fetch_assoc($ro);
            $total = mysqli_num_rows($ro);
            if ($total == 1) {
                session_start();
                $_SESSION["uid"] = $row["uid"];
                $_SESSION["upassword"] = $row["upassword"];
                $_SESSION["uname"] = $row["uname"];
                $_SESSION["uemail"] = $row["uemail"];
                $_SESSION["utel"] = $row["utel"];
                $_SESSION["uaddress"] = $row["uaddress"];
                $_SESSION["level"] = $row["level"];
                header('location:index.php');
            } else { //帳號密碼輸入錯誤
                echo '<div class="login">
            <form action="" method="post">
                <h1>會員登入</h1>
                <div class="member">
                    <label for="">帳號</label>
                    <input type="text" placeholder="使用者名稱" name="uname">
                </div>
                <div class="member">
                    <label for="">密碼</label>
                    <input type="password" placeholder="密碼" name="upassword">
                    <span id="tip" style="color:red;">帳號或密碼錯誤</span>
                </div>
                <div class="btn-member">
                    <button class="sign" name="sign">登入</button>
                    <button class="reg"><a href="register.php">註冊</a></button>
                </div>
                <p class="forget"><a href="forget.html">忘記密碼 ?</a></p>
            </form>
            </div>';
            }
        }
    } else {
    ?>
        <div class="login">
            <form action="" method="post">
                <h1>會員登入</h1>
                <div class="member">
                    <label for="">帳號</label>
                    <input type="text" placeholder="使用者名稱" name="uname">
                </div>
                <div class="member">
                    <label for="">密碼</label>
                    <input type="password" placeholder="密碼" name="upassword">
                </div>
                <div class="btn-member">
                    <button class="sign" name="sign">登入</button>
                    <button class="reg"><a href="register.php">註冊</a></button>
                </div>
                <p class="forget"><a href="forget.php">忘記密碼 ?</a></p>
            </form>
        </div>
    <?php } ?>

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


</body>

</html>