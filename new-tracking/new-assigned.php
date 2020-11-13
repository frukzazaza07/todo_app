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
                    <h4>มอบหมายงานให้เจ้าหน้าที่<?php echo $_SESSION['request_name']; ?></h4>
                    <hr>
                    <div class="alert" role="alert" id="alert-message" style="display:  none;">
                    </div>
                    <table class="table table-striped">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">เลขที่ใบงาน</th>
                                <th scope="col">ชื่อผู้แจ้ง</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">แก้ไข</th>
                                <th scope="col">วันที่</th>
                                <th scope="col">มอบหมายงาน</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <!-- jquery -->
                        </tbody>
                    </table>
                </div>
            </article>

        </div>

    </div>
    <!-- assigned -->
    <div class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เลือกเจ้าหน้าที่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="requestProblem">ชื่อเรื่อง</label>
                            <input type="text" class="form-control" id="assinged_title" readonly>
                        </div>
                        <div class="form-group">
                            <label for="requestProblem">เลขที่ใบงาน</label>
                            <input type="text" class="form-control" id="assinged_ticket" readonly>
                        </div>
                        <div class="form-group">
                            <label for="requestProblem">Assigned เจ้าหน้าที่</label>
                            <select class="form-control" id="staff_it">
                                <!-- jquery -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_assinged" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- แก้ไขใบงาน -->
    <div class="modal fade bd-example-modal-md" id="edit_ticket" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เลือกเจ้าหน้าที่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="requestProblem">เลขที่ใบงาน</label>
                            <input type="text" class="form-control" id="request_ticket" readonly>
                        </div>
                        <div class="form-group">
                            <label for="requestProblem">ชื่อผู้แจ้ง</label>
                            <input type="text" class="form-control" id="request_by" value="<?php echo $_SESSION['name']; ?>" disabled>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnConflim_edit" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script async="" src="https://snap.licdn.com/li.lms-analytics/insight.beta.min.js"></script>
    <script type="text/javascript" async="" src="https://snap.licdn.com/li.lms-analytics/insight.min.js"></script>
    <?php include('../component/footer.php');  ?>
    <script>
        var edit_ticket = [];
        var edit_ticket_id = '';
        var edit_ticket_kkc_id = '';
        var assinged_ticket_id = '';
        $.get("../component/aside.php", function(data) {
            $('.container-main').append(data);
            $('#newToAssigned').toggleClass('menu-active');
            $('#newToAssigned > a').toggleClass('a-menu-active');
        });
        $.get("../component/head.php", function(data) {
            $('.user-container').append(data);
        });
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        $.get('new-tracking-engine/retive-userIt.php', function(res) {
            let data = JSON.parse(res);
            for (let i = 0; i < data.res.length; i++) {
                let template = `<option value="${data.res[i].id}">${data.res[i].name}</option>`;
                $('#staff_it').append(template);
            }
        });
        $(document).ready(function() {
            retive_data();
        });

        function retive_data() {
            let JSONTicket = {
                loadData: 'ticket_new'
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONTicket);
            $.ajax({
                url: 'new-tracking-engine/select-assigned-new.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    //#errorRegister_email
                    let data = JSON.parse(res);
                    if (data.success != 1) {
                        autoComplete(data.message, 0);
                    } else {
                        autoComplete(data.res, 1);
                    }
                }

            });
        }

        $('#btnConflim_edit').click(function() {
            if (edit_ticket_id != '') {
                let request_by = '<?php echo $_SESSION['request_name']; ?>';
                let request_title = $('#request_title').val();
                let request_detail = $('#request_detail').val();
                let request_img = $('#request_img').val();

                let JSONEdit_ticket = {
                    edit_ticket_id: edit_ticket_id,
                    edit_ticket_kkc_id: edit_ticket_kkc_id,
                    request_by: request_by,
                    request_title: request_title,
                    request_detail: request_detail,
                    request_img: request_img
                    // company_id: json_request["company_id"],
                    // passkey: json_request["passkey"]
                }

                let jsonData = JSON.stringify(JSONEdit_ticket);
                $.ajax({
                    url: 'new-tracking-engine/update-ticket.php',
                    type: "post",
                    data: {
                        json: jsonData
                    },
                    success: function(res) {
                        //#errorRegister_email
                        let data = JSON.parse(res);

                        if (data.success != 1) {
                            $('#alert-message').addClass('alert-danger');
                            $('#alert-message').show();
                            $('#alert-message').text(data.message);
                        } else {
                            retive_data();
                            $('#alert-message').removeClass('alert-danger');
                            $('#alert-message').addClass('alert-success');
                            $('#alert-message').show();
                            $('#alert-message').text(data.message);
                        }
                    }

                });
            }

        });

        $('#btn_assinged').click(function() {
            let ticketId = $('#assinged_ticket').val();
            let staff_it = $('#staff_it').val();
            let JSONassinged_ticket = {
                assignedBy: '<?php echo $_SESSION['request_name'] ?>',
                assingedTo: staff_it,
                ticketNo: assinged_ticket_id,
                ticketId: ticketId
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONassinged_ticket);
            $.ajax({
                url: 'new-tracking-engine/insert-assigned.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    console.log(res);
                    let data = JSON.parse(res);
                    if (data.success != 1) {
                        $('#alert-message').addClass('alert-danger');
                        $('#alert-message').show();
                        $('#alert-message').text(data.message);
                    } else {
                        retive_data();
                        $('#alert-message').removeClass('alert-danger');
                        $('#alert-message').addClass('alert-success');
                        $('#alert-message').show();
                        $('#alert-message').text(data.message);
                    }
                }

            });


        });

        function editTicket(id, kkc_id) {
            edit_ticket_id = id;
            edit_ticket_kkc_id = kkc_id;
            for (let i = 0; i < edit_ticket.length; i++) {
                if (id == edit_ticket[i].id) {
                    let request_by = $('#request_by').val();
                    let request_ticket = $('#request_ticket').val(edit_ticket[i].tracking_id);
                    let request_title = $('#request_title').val(edit_ticket[i].request_title);
                    let request_detail = $('#request_detail').val(edit_ticket[i].request_detail);
                    let request_img = $('#request_img').val(edit_ticket[i].request_img);
                    break;
                }
            }
        }

        function assingedTicket(id, ticket_id, ticket_title) {
            let ticketTitle = $('#assinged_title').val(ticket_title);
            let ticketId = $('#assinged_ticket').val(ticket_id);
            assinged_ticket_id = id;
        }

        function autoComplete(data, success_status) {
            $('tbody > tr').remove();
            if (success_status == 1) {
                edit_ticket = [];
                for (let i = 0; i < data.length; i++) {
                    edit_ticket.push(data[i]);
                    let template = ` <tr> \
            <th scope = "row">${i+1}</th> 
            <td>${data[i].tracking_id}</td> 
            <td>${data[i].request_by}</td> 
            <td style="color: #F339A6">${data[i].request_status}</td> \
            <td>${data[i].request_date}</td>\
            <td><button type="button" onclick="editTicket('${data[i].id}','${data[i].tracking_id}')" class="btn btn-warning"data-toggle="modal" data-target="#edit_ticket">แก้ไข</button></td >\
                <td> \
                <button type="button" onclick="assingedTicket('${data[i].id}','${data[i].tracking_id}','${data[i].request_title}')" class="btn btn-success"data-toggle="modal" data-target =".bd-example-modal-md">Assigned</button></td>\
                </tr>`;
                    $('tbody').append(template);
                }
            } else {
                let template = ` <tr> \
            <th colspan="7">${data}</th> \
                  </tr>`;
                $('tbody').append(template);
            }

        }
    </script>
</body>


</html>