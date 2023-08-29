<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
session_start();
$uname = $_SESSION["uname"];
$stmt = $pdo->prepare("select * from member where uname=?");
$stmt->execute(array($uname));
$row = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/member.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="small-header">
            <nav>
                <?php
                if (isset($uname)) {
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
                <p>會員中心</p>
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

            </div>
        </div>
    </header>
    <?php if (isset($uname)) { ?>
        <main>
            <article>
                <div class="member">
                    <div class="member-img">
                        <?php if ($row["img"] == "upload/" || $row["img"] == "") { ?>
                            <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                            <img src="">
                        <?php } else { ?>
                            <img src="<?php echo $row["img"] ?>">
                        <?php } ?>
                    </div>
                    <p class="member-name"><?php echo $uname ?></p>
                </div>
                <h4><a href="member.php">編輯會員簡介</a></h4>
                <h4><a href="member_buy.php">購買清單</a></h4>
            </article>

            <aside>
                <h2>我的檔案</h2>
                <div class="username">
                    <label for="">使用者名稱</label>
                    <div class="name"><?php echo $uname ?></div>
                </div>
                <form action="upload.php" method="post" class="update-mamber" enctype="multipart/form-data">
                    <input type="hidden" name="uname" value="<?php echo $row["uname"] ?>">
                    <div class="yourname">
                        <label>姓名</label><input type="text" name="yourname" value="<?php echo $row["mname"] ?>">
                    </div>
                    <div class="gender">
                        <label>性別</label>
                        <input type="radio" value="1" id="male" name="gender" checked>
                        <label for="male">男</label>
                        <input type="radio" value="2" id="female" name="gender">
                        <label for="female">女</label>
                    </div>
                    <div class="date">
                        <label>生日</label><input type="date" name="birthday" value="<?php echo $row["birthday"] ?>">
                    </div>
                    <button>儲存</button>
                    <div class="preview">
                        <div class="member-img2">
                            <?php if ($row["img"] == "upload/" || $row["img"] == "") { ?>
                                <i class="fa fa-user fa-4x user" aria-hidden="true"></i>
                                <img src="" id="preview_progressbarTW_img">
                            <?php } else { ?>
                                <img src="<?php echo $row["img"] ?>" id="preview_progressbarTW_img">
                            <?php } ?>
                        </div>
                        <input name="progressbarTW_img" type="file" id="imgInp" accept="image/gif, image/jpeg, image/png">
                    </div>
                </form>
            </aside>
        </main>


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
    <?php } else {
        echo "<script>alert('請先登入會員'); location.href = 'login.php';</script>";
    } ?>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $("#imgInp").change(function() {
            $(".user").css({
                "display": "none"
            });
            readURL(this);
        });

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#preview_progressbarTW_img").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>