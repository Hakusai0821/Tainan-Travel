<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <link href="https://file.myfontastic.com/E8p6K9badokQFWLyj5DCbE/icons.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css' integrity='sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==' crossorigin='anonymous' />

    <title>Document</title>
</head>

<body>
    <!-- 導覽頁 -->
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
                <a href="#">購物車</a>

            </nav>
        </div>
        <div class="main-header">
            <div class="container">
                <a href="#" class="logo">
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

    <!-- 幻燈片 -->
    <div class="slidepic">
        <div class="row">
            <div class="col-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://picsum.photos/1200/300/?random=1" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="https://picsum.photos/1200/300/?random=2" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="https://picsum.photos/1200/300/?random=3" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class=" pre " aria-hidden="true">
                        </span> <span class="visually-hidden">Previous
                        </span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="next" aria-hidden="true">></span>
                        <span class="visually-hidden ">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- 氣象資訊 -->
    <div class="weather">
        <div class="weather-focus">
            <span>
                <p class="weather-title">今天天氣</p>
                <p id="citytoday"></p>
                <img src="https://picsum.photos/100/100/?random=30" id="weather">
            </span>
            <span>
                <p class="weather-title">明天天氣</p>
                <p id="citytomorrow"></p>
                <img src="https://picsum.photos/100/100/?random=10" id="weather">
            </span>
        </div>
    </div>

    <!-- 內容資訊 -->
    <div class="container-fluid warp">
        <h1>台南腳印
            <div class="icon-foot"></div>
            <div class="icon-foot"></div>
            <div class="icon-foot"></div>
            <div class="icon-foot"></div>
        </h1>

        <div class="travel-warp">
            <div class="item">
                <img src="https://picsum.photos/300/300/?random=6">
                <span class="txt">
                    <h1>安平古堡</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit, architecto.</p>
                </span>
            </div>
            <div class="item">
                <img src="https://picsum.photos/100/100/?random=5">
                <span class="txt">
                    <h1>七股鹽山</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit, architecto.</p>
                </span>
            </div>
            <div class="item">
                <img src="https://picsum.photos/100/100/?random=4">
                <span class="txt">
                    <h1>奇美博物館</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit, architecto.</p>
                </span>
            </div>
            <div class="item">
                <img src="https://picsum.photos/100/100/?random=2">
                <span class="txt">
                    <h1>觀夕平台</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit, architecto.</p>
                </span>
            </div>
            <div class="item">
                <img src="https://picsum.photos/100/100/?random=2">
                <span class="txt">
                    <h1>神農老街</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit, architecto.</p>
                </span>
            </div>
        </div>
    </div>

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
        //XNLHttpRequest 中央氣象局api串接
        document.getElementById("weather").onload = function getdata() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(xhttp.responseText);
                    let a = document.getElementById("citytoday").innerHTML = data.records.location[0].weatherElement[0].time[0].parameter.parameterName;
                    console.log(a);

                    let b = document.getElementById("citytomorrow").innerHTML = data.records.location[0].weatherElement[0].time[2].parameter.parameterName;
                    console.log(b);
                }
            };
            xhttp.open("GET", "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-124F2645-8986-4A4A-B2E3-D4FE57867992&format=JSON&locationName=%E8%87%BA%E5%8D%97%E5%B8%82&elementName=Wx", true);
            xhttp.send();
        }
    </script>
</body>

</html>