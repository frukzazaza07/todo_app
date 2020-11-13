<?php
session_start();
include('../config/chklogin.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php include('../component/header.php'); ?>


<body style="font-family: Sukhumvit Set; height: 100%; padding: 0px; margin: 0px;">
    <div class="container-main background-color: rgb(237, 237, 237, 0.7);">
        <div class="content-head" style="width: 100%; overflow:hidden; background-color: rgb(237, 237, 237, 0.7);">
            <div class="user-container">
                <!-- jquery -->
            </div>
            <article class="content-body" style="width: 100%; height: 100%;">
                <div class="container-body mb-0">
                    <h4>แจ้งปัญหาการใช้งาน Hardware/Software</h4>
                    <hr>
                    <form action="" onsubmit="return false" id="insertNew_tricket">
                        <div class="alert" role="alert" id="alert-error" style="display:  none;">
                        </div>
                        <div class="form-group">
                            <label for="requestProblem">ชื่อผู้แจ้ง</label>
                            <input type="text" class="form-control" id="request_by" value="<?php echo $_SESSION["request_name"] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="requestProblem">ชื่อเรื่อง</label>
                            <input type="text" class="form-control" id="request_title">
                        </div>
                        <div class="form-group">
                            <label for="requestProblem">รายละเอียดของปัญหา</label>
                            <textarea class="form-control" id="request_detail" rows="3"></textarea>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="request_img">
                            <label class="custom-file-label" for="customFile">รูปภาพเพิ่มเติม</label>
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary btn-block btn-lg">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>
            </article>

        </div>

    </div>
    <script async="" src="https://snap.licdn.com/li.lms-analytics/insight.beta.min.js"></script>
    <script type="text/javascript" async="" src="https://snap.licdn.com/li.lms-analytics/insight.min.js"></script>
    <?php include('../component/footer.php');  ?>
    <script>
        $.get("../component/aside.php", function(data) {
            $('.container-main').append(data);
            $('#newTracking').toggleClass('menu-active');
            $('#newTracking > a').toggleClass('a-menu-active');
        });
        $.get("../component/head.php", function(data) {
            $('.user-container').append(data);
        });
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $('#insertNew_tricket').on('submit', function() {
            let request_by = '<?php echo $_SESSION['request_name']; ?>';
            let request_title = $('#request_title').val().trim();
            let request_detail = $('#request_detail').val().trim();
            let request_img = $('#request_img').val().trim();
            if (request_by == "") {
                $('#alert-error').addClass('alert-danger');
                $('#alert-error').show();
                $('#alert-error').text('กรุณาป้อนข้อมูลให้ครบถ้วน!');
                return false;
            } else if (request_title == "") {
                $('#alert-error').addClass('alert-danger');
                $('#alert-error').show();
                $('#alert-error').text('กรุณาป้อนข้อมูลให้ครบถ้วน!');
                return false;
            } else if (request_detail == "") {
                $('#alert-error').addClass('alert-danger');
                $('#alert-error').show();
                $('#alert-error').text('กรุณาป้อนข้อมูลให้ครบถ้วน!');
                return false;
            }
            let JSONCreate_tricket = {
                request_by: request_by,
                request_title: request_title,
                request_detail: request_detail,
                request_img: request_img
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONCreate_tricket);
            $.ajax({
                url: 'new-tracking-engine/insert-tracking.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    //#errorRegister_email
                    let data = JSON.parse(res);
                    // console.log(data);
                    if (data.success != 1) {
                        $('#alert-error').addClass('alert-danger');
                        $('#alert-error').show();
                        $('#alert-error').text(data.message);
                    } else {
                        $('.form-control').val('');
                        $('#alert-error').removeClass('alert-danger');
                        $('#alert-error').addClass('alert-success');
                        $('#alert-error').show();
                        $('#alert-error').text(data.message);
                    }
                }

            });
        });
    </script>
</body>


</html>