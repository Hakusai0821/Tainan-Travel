<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forget.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <div class="login">
        <h3 class="msg"></h3>
        <form action="sendmail.php" id="myForm" method="post">
            <div class="member">
                <label for="">輸入信箱</label>
                <input type="email" placeholder="email" name="email" id="email">
            </div>
            <div class="btn-member">
                <button class="sign" id="sub_btn">送出</button>
            </div>
        </form>
    </div>


    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        // function sendmail() {
        //     let email = $('#email');
        //     $.ajax({
        //         url: 'sendmail.php',
        //         method: 'POST',
        //         dataType: 'json',
        //         data: {
        //             email: email.val(),
        //         },
        //         success: function (response) {
        //             $('#myForm')[0].reset();
        //             alert("郵箱格式有誤！");
        //         }

        //     })
        // }

        // function isNotEmpty(caller) {
        //     if (caller.val() == "") {
        //         caller.css('border', '1px solid red');
        //         return false;
        //     } else {
        //         caller.css('border', '');
        //         return true;
        //     }
        // }


        // $('#sub_btn').click(function () {
        //     email = $('#email').val();
        //     if (email == "") {
        //         $("#chkmsg").html("請輸入註冊信箱 !"); 
        //     } else {
        //         if (email.match(/^\w+((-\w+)|(\.\w+))*\@\w+\.\w+$/)) {
        //             $('#sub_btn').attr('disabled', 'disabled').val('提交中...').css({ "cursor": "wait" });
        //             $.ajax({
        //                 type: 'post',
        //                 url: "send_mail.php",
        //                 dataType: 'json',              //這裡的T一定需要大寫！！！
        //                 data: { 'email': email },
        //                 beforeSend: function () {        //這裡的S一定需要大寫！！！
        //                     //alert("傳送成功！");
        //                 },
        //                 success: function (data) {
        //                     if (data.success == 1) {
        //                         $('#sub_btn').removeAttr('disabled').val('提交').css({ "cursor": "pointer" });
        //                         //alert(data.id+'--'+data.mess+'--'+data.success+'--'+data.token+'--'+data.email+'--'+data.msg+'--'+data.time);
        //                     } else {
        //                         //alert(data.id+'--'+data.mess+'--'+data.success+'--'+data.token+'--'+data.email+'--'+data.msg+'--'+data.time);
        //                     }
        //                 }
        //             });
        //         } else {
        //             alert("郵箱格式有誤！");
        //         }
        //     }
        // });
    </script>
</body>

</html>