<?php
session_start();
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
                                <th scope="col">ผู้ Pendding</th>
                                <th scope="col">วันที่ Pendding</th>
                                <th scope="col">ระยะเวลาที่ใช้</th>
                                <th scope="col">Action</th>
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
    <div class="modal fade bd-example-modal-md" id="assignedModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
        var edit_ticket_kkc_id = '';
        var assinged_ticket_id = '';
        var SLA_time;
        $.get("../component/aside.php", function(data) {
            $('.container-main').append(data);
            $('#penddingTracking').toggleClass('menu-active');
            $('#penddingTracking > a').toggleClass('a-menu-active');
        });
        $.get("../component/head.php", function(data) {
            $('.user-container').append(data);
        });
        $.get('pendding-tracking-engine/retive-user.php', function(res) {
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
                url: 'pendding-tracking-engine/select-pendding-assigned.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    if (data.success != 1) {
                        autoComplete(data.message, 0);
                    } else {
                        autoComplete(data.res, 1);
                    }
                }

            });
        }


        function chageTicket_status(id, ticket_id, staff_id, thisElem, title, SLA_minute) {
            let ticket_status = $(thisElem).val();
            if (ticket_status == "assigned") {
                changeTo_assigned(id, ticket_id, staff_id, title, SLA_minute);
            } else if (ticket_status != "") {
                var r = confirm("ต้องการ " + ticket_status + " ใบงาน " + ticket_id + " ?");
                if (r == true) {
                    if (ticket_status == "pendding") {
                        changeTo_pendding(id, ticket_id, staff_id, SLA_minute);
                        retive_data()
                    }
                }
            }
        }
        //ต้องเปลี่ยน parameter staff_id เป็น user pendding

        function changeTo_assigned(id, ticket_id, staff_id, title, SLA_minute) {
            assinged_ticket_id = id;
            SLA_time = SLA_minute;
            let assinged_title = $('#assinged_title').val(title);
            let assinged_ticket = $('#assinged_ticket').val(ticket_id);
            jQuery.noConflict(); //ถ้าไม่ใส่บรรทัดนี้ modal ไม่ออกมา
            $('#assignedModal').modal('show');
        }

        $('#btn_assinged').click(function() {

            let ticketId = $('#assinged_ticket').val();
            let staff_it = $('#staff_it').val();
            let JSONassinged_ticket = {
                assingedBy: '<?php echo $_SESSION['request_name']; ?>',
                assingedTo: staff_it,
                ticketNo: assinged_ticket_id,
                ticketId: ticketId,
                SLA_time: SLA_time
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }
            let jsonData = JSON.stringify(JSONassinged_ticket);
            alert(JSONassinged_ticket.SLA_time);
            $.ajax({
                url: 'pendding-tracking-engine/insert-assigned.php',
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


        });

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

        function autoComplete(data, success_status) {
            // console.log(data);
            $('tbody > tr').remove();
            if (success_status == 1) {
                edit_ticket = [];
                let pendding_sql;
                for (let i = 0; i < data.length; i++) {
                    edit_ticket.push(data[i]);
                    let template = ` <tr> \
            <th scope = "row">${i+1}</th> 
            <td><a href="javascript:void(0)" style="text-decoration: none;" onclick="show_ticket_detail('${data[i][0].id}','${data[i][0].tracking_id}')">${data[i][0].tracking_id}</a></td> 
            <td>${data[i][0].request_by}</td> 
            <td style="color: #FFEB00">${data[i][0].request_status}</td> \
            <td>${data[i][0].name}</td> \
            <td>${data[i][0].request_date}</td>\
            <td>${data[i][1]}</td>\
                <td width="15%"> \
                <select class="form-control form-control-sm" onchange="chageTicket_status('${data[i][0].id}','${data[i][0].tracking_id}','${data[i][0].assigned_to}',this,'${data[i][0].request_title}','${data[i][0].request_date}')">\
                    <option value="">แก้ไขสถานะใบงาน</option>\
                    <option value="assigned">Assigned</option>\
                </select>\
                </td>\
                </tr>`;
                    $('tbody').append(template);
                }
            } else {
                let template = ` <tr> \
            <th colspan="8">${data}</th> \
                  </tr>`;
                $('tbody').append(template);
            }
        }
    </script>
</body>

</html>