<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $update = "update trickets_new set
                    request_by = :request_by,
                    request_title = :request_title ,
                    request_detail  = :request_detail,
                    request_img = :request_img where id =  '" . $JSONData['edit_ticket_id'] . "'  ";
    $stmt_update = $PDO->prepare($update);
    $stmt_update->bindParam(':request_by', $JSONData['request_by']);
    $stmt_update->bindParam(':request_title', $JSONData['request_title']);
    $stmt_update->bindParam(':request_detail', $JSONData['request_detail']);
    $stmt_update->bindParam(':request_img', $JSONData['request_img']);
    if ($stmt_update->execute()) {
        $answer["success"] = 1;
        $answer["message"] = "แก้ไข Tickets: " . $JSONData['edit_ticket_kkc_id'] . " เรียบร้อย";
        exit(json_encode($answer));
    } else {
        $answer["success"] = 0;
        $answer["message"] = "ไม่สามารถแก้ไข Ticket: " . $JSONData['edit_ticket_kkc_id'] . " ได้ " . $PDO->errorInfo();
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
