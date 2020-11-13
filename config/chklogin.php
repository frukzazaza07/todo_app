<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php");
}
