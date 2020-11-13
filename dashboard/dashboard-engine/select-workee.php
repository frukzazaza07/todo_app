<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $select = "SELECT user.nickname as name,
                COUNT(DISTINCT trickets_close.tracking_new_id) AS count_workee
                from trickets_close
                LEFT JOIN user ON trickets_close.assigned_to = user.id
                GROUP BY trickets_close.assigned_to LIMIT 5;
                 ";
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
        $answer["message"] = "ไม่มีใบงาน New ในระบบ";
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
