<?php
session_start();
include('../config/chklogin.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .liactive1 {
            background-color: white;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            border-style: solid;
            border-color: #e6e6e6;
            border-width: 1px 1px 0 1px;
            padding-top: 18px;
        }

        .aactive1 {
            color: rebeccapurple;
            /* color: red; */
        }
    </style>
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
                    <h4>Dashboard</h4>
                    <hr>
                    <div class="gaph1-body" style="display: flex; justify-content: space-between; margin-bottom: 40px;">
                        <div style="width: 50%;box-shadow: 0 0 10px #ECECEC; padding: 0px 15px 0px 10px; height: 350px;">
                            <!-- <h5 style="padding-top: 10px">ใบงาน</h5> -->
                            <canvas id="tickets-gaph"></canvas>
                        </div>
                        <div style="width: 50%;box-shadow: 0 0 10px #ECECEC; padding: 0px 15px 0px 10px; height: 350px;">
                            <!-- <h5 style="padding-top: 10px">ผู้รับงาน</h5> -->
                            <canvas id="workee-gaph" height="200px"></canvas>
                        </div>
                    </div>
                    <div class="gaph2-body">
                        <div class="gaph-content4" style="width: 100%;box-shadow: 0 0 10px #ECECEC; padding: 0px 15px 0px 10px; height: 500px;">
                            <div class="gaph-item">
                                <h5 style="margin: 0px 20px; padding: 15px 0px">ใบงานทั้งหมด</h5>
                                <hr style="margin: 0px 20px; padding: 0px;">
                            </div>
                            <ul id="menu" class="nav-type">
                                <li class="sale-menu all-commissions" onclick="setTypeOfShow(1,this)">
                                    <a href="javascript:void(0)">Yesterday</a>
                                </li>
                                <li class="sale-menu all-commissions" id="curlent_show" onclick="setTypeOfShow(2,this)">
                                    <a href="javascript:void(0)">Curlent Date</a>
                                </li>
                                <li class="sale-menu all-commissions" onclick="setTypeOfShow(3,this)">
                                    <a href="javascript:void(0)">This Month</a>
                                </li>
                                <li class="sale-menu all-commissions" onclick="setTypeOfShow(4,this)">
                                    <a href="javascript:void(0)">This Year</a>
                                </li>
                            </ul>
                            <div class="content-box box1" style="height: 72%;">
                                <canvas id="outstanding-gaph" style="margin-top: 30px;"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        </article>

    </div>
    </div>

    <script async="" src="https://snap.licdn.com/li.lms-analytics/insight.beta.min.js"></script>
    <script type="text/javascript" async="" src="https://snap.licdn.com/li.lms-analytics/insight.min.js"></script>
    <?php include('../component/footer.php');  ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var edit_ticket_kkc_id = '';
        var assinged_ticket_id = '';
        var charts_tickets, charts_workee, charts_outstanding;
        $.get("../component/aside.php", function(data) {
            $('.container-main').append(data);
            $('#dashboard').toggleClass('menu-active');
            $('#dashboard > a').toggleClass('a-menu-active');
        });
        $.get("../component/head.php", function(data) {
            $('.user-container').append(data);
        });
        $(document).ready(function() {
            retive_tickets();
            retive_workee();
            retive_outstanding('dashboard-engine/select-outstanding.php');
            setWidth('3000px');
            $('#curlent_show').toggleClass('liactive1');
            $('#curlent_show > a').toggleClass('aactive1');
        });

        function setWidth(width) {
            var canvas = document.getElementById("tickets-gaph");
            canvas.width = width;
        }

        function retive_tickets() {
            let JSONTicket = {
                loadData: 'tickets'
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONTicket);
            $.ajax({
                url: 'dashboard-engine/select-dashboard.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    // console.log(data);
                    if (data.success != 1) {
                        showGraph_tickets('bar', '#tickets-gaph', data.res)
                    } else {
                        showGraph_tickets('bar', '#tickets-gaph', data.res)
                    }
                }

            });
        }

        function retive_workee() {
            let JSONTicket = {
                loadData: 'tickets'
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONTicket);
            $.ajax({
                url: 'dashboard-engine/select-workee.php',
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    if (data.success != 1) {
                        showGraph_workee('bar', '#workee-gaph', data.res)
                    } else {
                        showGraph_workee('bar', '#workee-gaph', data.res)
                    }
                }

            });
        }

        function retive_outstanding(url) {
            let JSONTicket = {
                loadData: 'tickets'
                // company_id: json_request["company_id"],
                // passkey: json_request["passkey"]
            }

            let jsonData = JSON.stringify(JSONTicket);
            $.ajax({
                url: url,
                type: "post",
                data: {
                    json: jsonData
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    // console.log(data);
                    if (data.success != 1) {
                        showGraph_outstanding('bar', '#outstanding-gaph', data.res)
                    } else {
                        showGraph_outstanding('bar', '#outstanding-gaph', data.res)
                    }
                }

            });
        }

        function setTypeOfShow(typeDate, thisElem) {
            let elem_a = $(thisElem).children('a');
            $('.all-commissions').removeClass('liactive1');
            $('.all-commissions > a').removeClass('aactive1');
            $(thisElem).toggleClass('liactive1');
            $(elem_a).toggleClass('aactive1');
            switch (typeDate) {
                case 1:
                    retive_outstanding('dashboard-engine/select-outstanding-yesterday.php');
                    break;
                case 2:
                    retive_outstanding('dashboard-engine/select-outstanding.php');
                    break;
                case 3:
                    retive_outstanding('dashboard-engine/select-outstanding-month.php');
                    break;
                case 4:
                    retive_outstanding('dashboard-engine/select-outstanding-year.php');
                    break;
            }
        }

        function showGraph_tickets(typegaph, target, data) {
            if (charts_tickets != null) {
                charts_tickets.destroy();
            }
            let chartsTarget = target;
            let typeGaph = typegaph; {
                var name = [];
                var marks = [];
                for (var i in data) {
                    name.push(data[i].request_date);
                    marks.push(data[i].count_tickets);
                }
                var chartdata = {
                    labels: name,
                    datasets: [{
                        label: 'ใบงาน',
                        data: marks,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)', //red
                            'rgba(54, 162, 235, 0.2)', //blue
                            'rgba(255, 206, 86, 0.2)', //yellow
                            'rgba(75, 192, 192, 0.2)', //green
                            'rgba(153, 102, 255, 0.2)', //purple
                            'rgba(255, 159, 64, 0.2)', //orange
                            'rgba(255, 99, 132, 0.2)', //red
                            'rgba(54, 162, 235, 0.2)', //blue
                            'rgba(255, 206, 86, 0.2)', //yellow
                            'rgba(75, 192, 192, 0.2)', //green
                            'rgba(153, 102, 255, 0.2)', //purple
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1,
                    }]
                };

                var graphTarget = $(chartsTarget);
                chart_tickets = new Chart(graphTarget, {
                    type: typeGaph,
                    data: chartdata,
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var xLabel = d.datasets[t.datasetIndex].label;
                                    var yLabel = t.yLabel + ' ใบ';
                                    return xLabel + ': ' + yLabel;
                                },
                            }
                        },
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'ใบงานทั้งหมด',
                            fontSize: '20',
                            fontColor: 'black'
                        },
                        animation: {
                            duration: 2000
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                        responsive: true
                    }
                });
            }
        }

        function showGraph_workee(typegaph, target, data) {
            if (charts_workee != null) {
                charts_workee.destroy();
            }
            let chartsTarget = target;
            let typeGaph = typegaph; {
                var name = [];
                var marks = [];
                for (var i in data) {
                    name.push(data[i].name);
                    marks.push(data[i].count_workee);
                }
                var chartdata = {
                    labels: name,
                    datasets: [{
                        label: 'แก้ไข',
                        data: marks,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)', //red
                            'rgba(54, 162, 235, 0.2)', //blue
                            'rgba(255, 206, 86, 0.2)', //yellow
                            'rgba(75, 192, 192, 0.2)', //green
                            'rgba(153, 102, 255, 0.2)', //purple
                            'rgba(255, 159, 64, 0.2)', //orange
                            'rgba(255, 99, 132, 0.2)', //red
                            'rgba(54, 162, 235, 0.2)', //blue
                            'rgba(255, 206, 86, 0.2)', //yellow
                            'rgba(75, 192, 192, 0.2)', //green
                            'rgba(153, 102, 255, 0.2)', //purple
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1,
                    }]
                };

                var graphTarget = $(chartsTarget);
                charts_workee = new Chart(graphTarget, {
                    type: typeGaph,
                    data: chartdata,
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var xLabel = d.datasets[t.datasetIndex].label;
                                    var yLabel = t.yLabel + ' ใบ';
                                    return xLabel + ': ' + yLabel;
                                },
                            }
                        },
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'การแก้ไข',
                            fontSize: '20',
                            fontColor: 'black'
                        },
                        animation: {
                            duration: 2000
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                        responsive: true
                    }
                });
            }
        }

        function showGraph_outstanding(typegaph, target, data) {
            // console.log(charts_outstanding);
            if (charts_outstanding != null) {
                charts_outstanding.destroy();
            }
            let chartsTarget = target;
            let typeGaph = typegaph; {
                var name = [];
                var marks = [];
                for (var i in data) {
                    name.push(data[i].request_status);
                    marks.push(data[i].count_outstanding);
                }
                var chartdata = {
                    labels: name,
                    datasets: [{
                        label: 'ใบงาน',
                        data: marks,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)', //red
                            'rgba(54, 162, 235, 0.2)', //blue
                            'rgba(255, 206, 86, 0.2)', //yellow
                            'rgba(75, 192, 192, 0.2)', //green
                            'rgba(153, 102, 255, 0.2)', //purple
                            'rgba(255, 159, 64, 0.2)', //orange
                            'rgba(255, 99, 132, 0.2)', //red
                            'rgba(54, 162, 235, 0.2)', //blue
                            'rgba(255, 206, 86, 0.2)', //yellow
                            'rgba(75, 192, 192, 0.2)', //green
                            'rgba(153, 102, 255, 0.2)', //purple
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1,
                    }]
                };

                var graphTarget = $(chartsTarget);
                charts_outstanding = new Chart(graphTarget, {
                    type: typeGaph,
                    data: chartdata,
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(t, d) {
                                    var xLabel = d.datasets[t.datasetIndex].label;
                                    var yLabel = t.yLabel + ' ใบ';
                                    return xLabel + ': ' + yLabel;
                                },
                            }
                        },
                        legend: {
                            display: false,
                        },
                        title: {
                            display: false,
                            text: 'ใบงานทั้งหมด',
                            fontSize: '20',
                            fontColor: 'black'
                        },
                        animation: {
                            duration: 2000
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    userCallback: function(label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                                    }
                                }
                            }]
                        },
                        maintainAspectRatio: false,
                        responsive: true
                    }
                });
            }
        }
    </script>