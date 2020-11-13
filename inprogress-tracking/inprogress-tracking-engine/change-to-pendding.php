<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $request_status = 'pendding';
    $update = "update trickets_new set
                     request_status = '" . $request_status . "'
                     where id =  '" . $JSONData['ticketNo'] . "'  ";
    $stmt_update = $PDO->query($update);

    $insert = "INSERT INTO trickets_pendding(
                    tracking_new_id,
                    tracking_id,
                    assigned_to,
                    pendding_by,
                    request_status) 
                VALUES(
                    :ticket_no,
                    :ticket_id,
                    :assigned_to,
                    :pendding_by,
                    :request_status)";
    $stmt_insert = $PDO->prepare($insert);
    $stmt_insert->bindParam(':ticket_no', $JSONData['ticketNo']);
    $stmt_insert->bindParam(':ticket_id', $JSONData['ticketId']);
    $stmt_insert->bindParam(':assigned_to', $JSONData['assingedTo']);
    $stmt_insert->bindParam(':pendding_by', $JSONData['assingedTo']);
    $stmt_insert->bindParam(':request_status', $request_status);
    if ($stmt_insert->execute()) {
        $answer["success"] = 1;
        $answer["message"] = "Pendding Tickets: " . $JSONData['ticketId'] . " เรียบร้อย";
        exit(json_encode($answer));
    } else {
        $answer["success"] = 0;
        $answer["message"] = "ไม่สามารถ Pendding Ticket: " . $JSONData['ticketId'] . " ได้ " . $PDO->errorInfo();
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
