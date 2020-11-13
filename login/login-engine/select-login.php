<?php
session_start();
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $select = "SELECT * from user 
    where 
    username = :username
    AND
    password = :password
     ";
    $stmt_select = $PDO->prepare($select);
    $stmt_select->bindParam(':username', $JSONData['username']);
    $stmt_select->bindParam(':password', $JSONData['password']);
    $stmt_select->execute();
    $numRows = $stmt_select->rowCount();
    if ($numRows == 1) {
        $result = $stmt_select->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $result['id'];
        $_SESSION['name'] = $result['fname'] . ' ' . $result['lname'];
        $_SESSION['request_name'] = $result['fname'] . ' (' . $result['nickname'] . ')';
        $_SESSION['user_status'] = $result['user_status'];
        $_SESSION['user_position'] = $result['position'];
        $answer["res"] = $result;
        $answer["success"] = 1;
        $answer["message"] = "";
        exit(json_encode($answer));
    } else {
        $answer["success"] = 0;
        $answer["message"] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
