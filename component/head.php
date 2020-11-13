<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .user-detail-container {
            transition: transform 0.3s linear;
            display: none;
            /* transform: scale(0); */

        }

        .user-detail-containerA {
            display: block;
            animation: move 1s;
        }

        #arrow-user-menu {
            -webkit-animation-fill-mode: forwards;
            -moz-animation-fill-mode: forwards;
            -ms-animation-fill-mode: forwards;
            -o-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
            transition: transform 1s linear;
        }

        .arrow-user-menu-active {
            animation: arrow_active 1s;
        }

        @keyframes arrow_active {
            from {

                transform: rotate(0deg);
            }

            to {
                transform: rotate(180deg);
            }
        }

        @keyframes move {

            /* 0% {
                transform: scale(0);
            }

            20% {
                transform: scale(1);
                transform: translate(300px, 0px)
            }
            40% {
                transform: rotate(-10deg);
            } */
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1);
            }


        }
    </style>
</head>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>



<body style="font-family: Sukhumvit Set; height: 100%;">
    <?php if (isset($_GET['header'])) {
        echo ' <header class="head-user">
            <nav class="user-link">
                 <img src="component/img/logo_user.jpg" alt="" width="40px" height="40px" style="border-radius: 50px 50px;"> 
                <span style="padding: 0px 8px;">คุณ ' . $_SESSION["name"] . ' </span>
                <i class="fas fa-angle-down"></i>
            </nav>
        </header> ';
    } else {
        echo '<header class="head-user">
        <nav class="user-link">
             <img src="../component/img/logo_user.jpg" alt="" width="40px" height="40px" style="border-radius: 50px 50px;"> 
            <span style="padding: 0px 8px;">คุณ ' . $_SESSION["name"] . ' </span>
            <div id="arrow-user-menu"><i class="fas fa-angle-down" ></i></div>
        </nav>
            <div class="user-detail-container" style="position: absolute; top: 68px; right: 15px; width: 280px; height: 260px;">
                <div style="background-color: #AF920A; height: 120px;">
                </div>
                <div style="background-color: #FFFFFF; height: 140px; box-shadow: 0px 3px 8px #ECECEC;">
                </div>
            </div>
    </header>';
    } ?>

</body>

<script>
    $('.user-link').click(function() {
        // $('.user-detail-container').css('display', 'block');
        $('.user-detail-container').toggleClass('user-detail-containerA');
        $('#arrow-user-menu').toggleClass('arrow-user-menu-active');
    });
</script>

</html>