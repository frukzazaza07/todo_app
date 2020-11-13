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
                    <h4>มอบหมายงานให้เจ้าหน้าที่</h4>
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
                                <th scope="col">เจ้าหน้าที่</th>
                                <th scope="col">วันที่ Assigned</th>
                                <th scope="col">ระยะเวลาที่ใช้</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="all-data">
                            <!-- jquery -->
                        </tbody>
                    </table>
                </div>
            </article>

        </div>

    </div>
    <!-- Detail Tracking การเคลื่อนไหวของใบงาน -->
    <div class="modal fade bd-example-modal-lg" id="detail_tracking" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticket_detail"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped text-center">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ผู้ดำเนินการ</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Action</th>
                                <th scope="col">วันที่</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="ticket-detail">
                            <!-- jquery -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
            $('#assignedTracking').toggleClass('menu-active');
            $('#assignedTracking > a').toggleClass('a-menu-active');
        });
        $.get("../component/head.php", function(data) {
            $('.user-container').append(data);
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
                url: 'assigned-tracking-engine/select-assigned-assigned.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    // console.log(data);
                    if (data.success != 1) {
                        autoComplete(data.message, 0);
                    } else {
                        autoComplete(data.res, 1);
                    }
                }

            });
        }


        function inprogressTicket(id, ticket_id, staff_id) {
            let user_position = '<?php echo $_SESSION['user_position']; ?>';
            if (user_position != 'it') {
                $('#alert-message').addClass('alert-danger');
                $('#alert-message').show();
                $('#alert-message').text('ไม่สามารถรับงานได้ คุณไม่ใช่เจ้าหน้าที่ IT!');
                return 0;
            }
            let JSONassinged_ticket = {
                assingedTo: <?php echo $_SESSION['id']; ?>,
                ticketNo: id,
                ticketId: ticket_id,
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONassinged_ticket);
            $.ajax({
                url: 'assigned-tracking-engine/insert-inprogress.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
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

        function show_ticket_detail(id) {
            jQuery.noConflict(); //ถ้าไม่ใส่บรรทัดนี้ modal ไม่ออกมา
            $('#detail_tracking').modal('show');
            let JSONassinged_ticket = {
                ticketID: id
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONassinged_ticket);
            $.ajax({
                url: '../tracking-all-detail-engine/select-all-ticket.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    if (data.success != 1) {
                        retive_tickets_detail(data)
                    } else {
                        console.log(data.res);
                        retive_tickets_detail(data.res)
                    }
                }

            });
        }

        function retive_tickets_detail(data) {
            $('#ticket_detail').text('เลขที่ใบงาน ' + data[0].ticket_id);
            $('tbody#ticket-detail > tr').remove();
            let color_code = '';
            for (let i = 0; i < data.length; i++) {
                if (data[i].ticket_status == 'assigned') {
                    color_code = '#074D9E';
                } else if (data[i].ticket_status == 'inprogress') {
                    color_code = '#0DDC4E';
                } else if (data[i].ticket_status == 'new') {
                    color_code = '#F339A6';
                } else if (data[i].ticket_status == 'pendding') {
                    color_code = '#FFEB00';
                } else {
                    color_code = '#F50000';
                }
                let template = ` <tr> \
            <th scope = "row">${i+1}</th> 
            <td>${data[i].request_by}</td> 
            <td>${data[i].end_by}</td> 
            <td style="color: ${color_code}">${data[i].ticket_status}</td> \
            <td>${data[i].ticket_date}</td> \
                </tr>`;
                $('tbody#ticket-detail').append(template);
            }
        }
        //ตรงปุ่มรับงานต้องเปลี่ยน parameter เป็ฯ ID
        function autoComplete(data, success_status) {
            // console.log(data);
            $('tbody#all-data > tr').remove();
            if (success_status == 1) {
                edit_ticket = [];
                for (let i = 0; i < data.length; i++) {
                    edit_ticket.push(data[i]);
                    let template = ` <tr> \
            <th scope = "row">${i+1}</th> 
            <td><a href="javascript:void(0)" style="text-decoration: none;" onclick="show_ticket_detail('${data[i][0].id}','${data[i][0].tracking_id}')">${data[i][0].tracking_id}</a></td> 
            <td>${data[i][0].request_by}</td> 
            <td style="color: #074D9E">${data[i][0].request_status}</td> \
            <td>${data[i][0].name}</td> \
            <td>${data[i][0].request_date}</td>\
            <td>${data[i][1]}</td>\
                <td> \
                <button type="button" onclick="inprogressTicket('${data[i][0].id}','${data[i][0].tracking_id}','${data[i][0].assigned_to}')" class="btn btn-primary"data-toggle="modal" data-target =".bd-example-modal-md">รับงาน</button></td>\
                </tr>`;
                    $('tbody#all-data').append(template);
                }
            } else {
                let template = ` <tr> \
            <th colspan="8">${data}</th> \
                  </tr>`;
                $('tbody#all-data').append(template);
            }
        }
    </script>
</body>


</html>