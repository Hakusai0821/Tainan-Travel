<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=travel;charset=utf8", "root", "");
} catch (PDOException $err) {
    die("資料庫無法連接");
}
if (isset($_GET["attid"])) {
    $stmt = $pdo->prepare("select * from attractions where id=?");
    $stmt->execute(array($_GET["attid"]));
    $row = $stmt->fetch();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />
    <link rel="stylesheet" href="css/clickatt.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>景點</title>
</head>

<body>
    <header>
        <div class="small-header">
            <nav>
                <?php
                session_start();
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
            <div class="container">
                <a href="index.php" class="logo">
                    <img src="imgs/大頑台南LOGO.png">
                </a>
                <ul class="nav">
                    <li><a href="Attractions.php"><i class="fa fa-camera" aria-hidden="true"></i>景點</a></li>
                    <li><a href="food.php"><i class="fa fa-cutlery" aria-hidden="true"></i>美食</a></li>
                    <li><a href="giftbuy.php"><i class="fa fa-suitcase" aria-hidden="true"></i>購物</a></li>
                    <li><a href="member.php"><i class="fa fa-user" aria-hidden="true"></i>會員</a></li>
                </ul>
                <form action="" class="search">
                    <input type="search">
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </header>
    <!-- 管理員編輯資料 -->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("select * from attractions where id=?");
        $stmt->execute(array($_POST["attid"]));
        $row = $stmt->fetch();
    ?>
        <form action="upatt.php" method="post" enctype="multipart/form-data">
            <input type="hidden" value=" <?php echo $row["id"] ?>" name="id">
            <div class="attwindow">
                <h1 class="attname"><input type="text" value="<?php echo $row["attname"] ?>" name="attname"></h1>
                <div class="att_summary">
                    <h2>景點簡介</h2>
                    <div class="attimg">
                        <img src="<?php echo $row["broimgs"] ?>" id="preview_progressbarTW_img">
                        <input name="broimg" type="file" id="imgInp" accept="image/gif, image/jpeg, image/png">
                    </div>
                    <div class="summary">
                        <textarea rows=5 cols=100 name="summary"><?php echo $row["summary"] ?></textarea>
                    </div>
                </div>
                <div class="att_intro">
                    <h2>景點介紹</h2>
                    <div class="intro">
                        <textarea rows=10 cols=100 name="intro"><?php echo $row["intro"] ?> </textarea>
                    </div>
                </div>
                <div class="att_info">
                    <h2>景點資訊</h2>
                    <div class="opentime">
                        <h3>開放時間</h3>
                        <p><input type="text" value="<?php echo $row["opentime"] ?>" size=80 style="margin-left: 10px" name="opentime"></p>
                    </div>
                    <div class="area">
                        <h3>地區</h3>
                        <p><input type="text" value="<?php echo $row["district"] ?>" size=80 style="margin-left: 10px" name="district"></p>
                    </div>
                    <div class="address">
                        <h3>地址</h3>
                        <p><input type="text" value="<?php echo $row["address"] ?>" size=80 style="margin-left: 10px" name="address"></p>
                    </div>
                    <div class="telphone">
                        <h3>電話</h3>
                        <p><input type="text" value="<?php echo $row["tel"] ?>" size=80 style="margin-left: 10px" name="tel"></p>
                    </div>
                </div>
                <h2 class="map_title">景點位置</h2>
                <span>
                    <iframe class="map" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCD_g150I_AdA_1ggRH0VBRDmI7LXZlXUo&q=<?php echo $row["latitude"]; ?>,<?php echo $row["longitude"]; ?>&zoom=16" allowfullscreen>
                    </iframe>
                </span>

                <p style="text-align: center;"><input type="text" value="<?php echo $row["latitude"]; ?>" size=80 style="margin-left: 10px" name="lat"></p>
                <p style="text-align: center;"><input type="text" value="<?php echo $row["longitude"]; ?>" size=80 style="margin-left: 10px" name="log"></p>
                <button style="background-color: bisque; font-size: 25px;padding: 5px 25px;margin-top: 45px;color: white;background-color: #14ae67;border: 1px solid rgb(207, 207, 207);border-radius: 5px;display:block; margin-left:auto; margin-right:15px">更新</button>
            </div>
        </form>


    <?php } else if (isset($_GET["insert"])) { ?>
        <form action="upatt.php" method="post" enctype="multipart/form-data">
            <div class="attwindow">
                <h1 class="attname"><input type="text" value="" name="attname"></h1>
                <div class="att_summary">
                    <h2>景點簡介</h2>
                    <div class="attimg">
                        <div class="broimg">
                            <i class="fa fa-picture-o fa-4x picture1" aria-hidden="true"></i>
                            <img src="" id="preview_progressbarTW_img">
                        </div>
                        <input name="broimg" type="file" id="imgInp" accept="image/gif, image/jpeg, image/png" style="margin-top:10px; margin-left:58px">
                        <div class="littleimg">
                            <i class="fa fa-picture-o fa-4x picture2" aria-hidden="true"></i>
                            <img src="" id="preview_progressbarTW_littleimg">
                        </div>
                        <input name="littleimg" type="file" id="limgInp" accept="image/gif, image/jpeg, image/png" style="margin-top:10px; margin-left:58px">
                    </div>
                    <div class="summary">
                        <textarea rows=5 cols=100 name="summary"></textarea>
                    </div>
                </div>
                <div class="att_intro">
                    <h2>景點介紹</h2>
                    <div class="intro">
                        <textarea rows=10 cols=100 name="intro"></textarea>
                    </div>
                </div>
                <div class="att_info">
                    <h2>景點資訊</h2>
                    <div class="opentime">
                        <h3>開放時間</h3>
                        <p><input type="text" value="" size=80 style="margin-left: 10px" name="opentime"></p>
                    </div>
                    <div class="area">
                        <h3>地區</h3>
                        <p><input type="text" value="" size=80 style="margin-left: 10px" name="district"></p>
                    </div>
                    <div class="address">
                        <h3>地址</h3>
                        <p><input type="text" value="" size=80 style="margin-left: 10px" name="address"></p>
                    </div>
                    <div class="telphone">
                        <h3>電話</h3>
                        <p><input type="text" value="" size=80 style="margin-left: 10px" name="tel"></p>
                    </div>
                </div>
                <h2 class="map_title">景點位置</h2>
                <span>
                    <iframe class="map" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCD_g150I_AdA_1ggRH0VBRDmI7LXZlXUo&q=<?php echo $row["latitude"]; ?>,<?php echo $row["longitude"]; ?>&zoom=16" allowfullscreen>
                    </iframe>
                </span>

                <p style="text-align: center;"><input type="text" value="" size=80 style="margin-left: 10px" name="lat"></p>
                <p style="text-align: center;"><input type="text" value="" size=80 style="margin-left: 10px" name="log"></p>
                <button style="background-color: bisque; font-size: 25px;padding: 5px 25px;margin-top: 45px;color: white;background-color: #14ae67;border: 1px solid rgb(207, 207, 207);border-radius: 5px;display:block; margin-left:auto; margin-right:15px">更新</button>
            </div>
        </form>


    <?php } else { ?>
        <!-- 管理員編輯資料 -->


        <div class="attwindow">
            <h1 class="attname"><?php echo $row["attname"] ?></h1>
            <div class="att_summary">
                <h2>景點簡介</h2>
                <div class="attimg">
                    <img src="<?php echo $row["broimgs"] ?>">
                </div>
                <div class="summary">
                    <?php echo $row["summary"] ?>
                </div>
            </div>
            <div class="att_intro">
                <h2>景點介紹</h2>
                <div class="intro">
                    <?php echo nl2br($row["intro"]) ?>
                </div>
            </div>
            <div class="att_info">
                <h2>景點資訊</h2>
                <div class="opentime">
                    <h3>開放時間</h3>
                    <?php
                    if ($row["opentime"] == "") {
                        echo '<p>全年開放</p>';
                    } else {
                        echo '<p>' . nl2br($row["opentime"]) . '</p>';
                    }
                    ?>
                </div>
                <div class="area">
                    <h3>地區</h3>
                    <p><?php echo $row["district"] ?></p>
                </div>
                <div class="address">
                    <h3>地址</h3>
                    <p> <?php echo $row["address"] ?></p>
                </div>
                <div class="telphone">
                    <h3>電話</h3>
                    <p> <?php echo $row["tel"] ?></p>
                </div>
            </div>

            <h2 class="map_title">景點位置</h2>
            <span>
                <iframe class="map" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCD_g150I_AdA_1ggRH0VBRDmI7LXZlXUo&q=<?php echo $row["latitude"]; ?>,<?php echo $row["longitude"]; ?>&zoom=16" allowfullscreen>
                </iframe>
            </span>
        </div>
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
    <script>
        //預覽圖片
        $("#imgInp").change(function() {
            $(".picture1").css({
                "display": "none"
            });
            $(".broimg").css({
                "overflow": "hidden"
            });
            $("#preview_progressbarTW_img").css({
                "display": "block",
            });
            readURL(this);
        });

        $("#limgInp").change(function() {
            $(".picture2").css({
                "display": "none"
            });
            $(".littleimg").css({
                "overflow": "hidden"
            });
            $("#preview_progressbarTW_littleimg").css({
                "display": "block",
            });
            lreadURL(this);
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

        function lreadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#preview_progressbarTW_littleimg").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>