<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");

try {
    $select = "select id, CONCAT(fname,' (',nickname,')') as name from user where position = 'IT' ";
    $stmt_select = $PDO->query($select);
    $numRows = $stmt_select->rowCount();
    if ($numRows > 0) {
        $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        $answer["res"] = $result;
        $answer["success"] = 1;
        $answer["message"] = "";
        exit(json_encode($answer));
    } else {
        $answer["success"] = 0;
        $answer["message"] = "ไม่สามารถเปิดใบงานได้ " . $PDO->errorInfo();
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
