<?php
error_reporting(E_ALL ^ E_NOTICE);
$servername = 'localhost';
$dbname = 'servicetracking-dev';
$username = 'root';
$password = '';
$PDO = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$PDO->exec("set names utf8");
date_default_timezone_set('Asia/Bangkok');
