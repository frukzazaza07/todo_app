<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<body style="font-family: Sukhumvit Set; height: 100%;">
    <?php if (isset($_GET['aside'])) { ?>
    <?php echo '
        <aside style="width: 300px; height: auto;">
            <header style="border-bottom: 1px solid #E0DEDD;">
                <nav style="margin-bottom: 25px">
                    <header class="logo-body">
                        <div class="logo-head">
                            <img src="component/img/kkc.png" alt="homepage" id="" height="129px" width="209px">
                        </div>
                        <div class="close-open-aside" style="padding-top: 20px;padding-left:35px;">
                            <!-- <i class="fas fa-toggle-off"></i> -->
                            <i class="fas fa-toggle-on"></i>
                        </div>
                    </header>
                    <article class="icon-branch">
                        <span><i class="fas fa-house-user"></i></span><span> สาขา: </span><span style="color: orange;">สำนักงานใหญ่</span>
                    </article>
                </nav>
            </header>
            <article style="height: 540px">
                <nav>
                    <ul style="padding-left: 0px;">
                         <li onclick="changePage(\'dashboard/dashboard\')" id="dashboard">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-hospital-alt"></i> ภาพรวม/Dashboard</span>
                            </a>
                        </li>
                        <li onclick="changePage(\'new-tracking/new-tracking\')" id="newTracking">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-clinic-medical"></i> เพิ่มใบงานใหม่</span>
                            </a>
                        </li>
                        <li id="assignedTracking" onclick="changePage(\'new-tracking/new-assigned\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-gift"></i> ใบงาน New</span>
                            </a>
                        </li>
                        <li id="assignedTracking" onclick="changePage(\'assigned-tracking/assigned-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-money-check-alt"></i> ใบงาน Assigned</span>
                            </a>
                        </li>
                        <li id="inprogressTracking" onclick="changePage(\'inprogress-tracking/inprogress-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-money-check-alt"></i> ใบงาน Inprogress</span>
                            </a>
                        </li>
                        <li id="penddingTracking" onclick="changePage(\'pendding-tracking/pendding-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-user-alt"></i> ใบงาน Pendding</span>
                            </a>
                        </li>
                        <li id="closeTracking" onclick="changePage(\'close-tracking/close-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-user-alt"></i> ใบงาน Closed</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-cart-plus"></i> เมนูผู้ใช้งาน</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </article>
        </aside>
        ';
    } else {
        echo '
        <aside style="width: 300px; height: auto;">
        <header style="border-bottom: 1px solid #E0DEDD;">
            <nav>
                <header class="logo-body">
                    <div class="logo-head">
                        <img src="../component/img/kkc.png" alt="homepage" id="" height="129px" width="209px">
                    </div>
                    <div class="close-open-aside" style="padding-top: 20px;padding-left:35px;">
                        <!-- <i class="fas fa-toggle-off"></i> -->
                        <i class="fas fa-toggle-on"></i>
                    </div>
                </header>
                <article class="icon-branch">
                    <span><i class="fas fa-house-user"></i></span><span> สาขา: </span><span style="color: orange;">สำนักงานใหญ่</span>
                </article>
            </nav>
        </header>
        <article style="height: 540px">
            <nav>
                <ul style="padding-left: 0px;">
                        <li onclick="changePage(\'../dashboard/dashboard\')" id="dashboard">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-hospital-alt"></i> ภาพรวม/Dashboard</span>
                            </a>
                        </li>
                        <li onclick="changePage(\'../new-tracking/new-tracking\')" id="newTracking">
                            <a href="javascript:void(0)"  class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-clinic-medical"></i> เพิ่มใบงานใหม่</span>
                            </a>
                        </li>
                        <li id="newToAssigned" onclick="changePage(\'../new-tracking/new-assigned\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-gift"></i> ใบงาน New</span>
                            </a>
                        </li>
                        <li id="assignedTracking" onclick="changePage(\'../assigned-tracking/assigned-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-money-check-alt"></i> ใบงาน Assigned</span>
                            </a>
                        </li>
                        <li id="inprogressTracking" onclick="changePage(\'../inprogress-tracking/inprogress-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-money-check-alt"></i> ใบงาน Inprogress</span>
                            </a>
                        </li>
                        <li id="penddingTracking" onclick="changePage(\'../pendding-tracking/pendding-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-user-alt"></i> ใบงาน Pendding</span>
                            </a>
                        </li>
                        <li id="closeTracking" onclick="changePage(\'../close-tracking/close-tracking\')">
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-money-check-alt"></i> ใบงาน Closed</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="nav-change" onclick="toggleDropdown(this)">
                                <span><i class="fas fa-cart-plus"></i> เมนูผู้ใช้งาน</span>
                            </a>
                        </li>
                </ul>
            </nav>
        </article>
    </aside>
';
    } ?>

</body>

</html>
<script>
    // toggle dropdown
    var curlentactiveElem = "";
    var clicked = false;
    var curlentDropdowElem = "";

    function toggleDropdown(elem) {
        $('.nav-change').removeClass("menu-active");
        let firstElem = elem.parentElement;
        let activeElem = firstElem.querySelector("a");
        // let dropDownElem = firstElem.querySelector("ul");
        // $(dropDownElem).toggleClass("dropdown-active");
        $(activeElem).toggleClass("menu-active");
    }

    function changePage(url) {
        window.location = url;
    }
</script>