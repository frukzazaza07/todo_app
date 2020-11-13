<?php
session_start();
include('config/chklogin_index.php');
if (isset($_SESSION['id'])) {
    header("Location: dashboard/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php include('header.php'); ?>


<body style="font-family: Sukhumvit Set; height: 100%; padding: 0px; margin: 0px;">
    <div class="container-main background-color: rgb(237, 237, 237, 0.7);">
        <div class="content-head" style="width: 100%; overflow:hidden; background-color: rgb(237, 237, 237, 0.7);">
            <div class="user-container">
                <!-- jquery -->
            </div>
        </div>
    </div>
    <script async="" src="https://snap.licdn.com/li.lms-analytics/insight.beta.min.js"></script>
    <script type="text/javascript" async="" src="https://snap.licdn.com/li.lms-analytics/insight.min.js"></script>
    <?php include('footer.php');  ?>
    <script>
        $.get("component/aside.php?aside", function(data) {
            $('.container-main').append(data);
        });
        $.get("component/head.php?header", function(data) {
            $('.user-container').append(data);
        });
    </script>
</body>


</html>