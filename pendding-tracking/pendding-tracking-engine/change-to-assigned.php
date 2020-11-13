<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $dT = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('Asia/Bangkok'));

    //Lets subtract 4 hours.
    $hoursToSubtract = (int) $JSONData['SLA_time'];

    //Subtract the hours using DateTime::sub and DateInterval.
    $dT->sub(new DateInterval("PT{$hoursToSubtract}M"));

    //Format and print it out.
    $SLA_time = $dT->format('Y-m-d H:i:s');
    $request_status = 'assigned';
    $update = "update trickets_new set
                    request_status = '" . $request_status . "'
                     where id =  '" . $JSONData['ticketNo'] . "'  ";
    $stmt_update = $PDO->query($update);


    $insert = "INSERT INTO trickets_assigned(
                    tracking_new_id,
                    tracking_id,
                    assigned_to,
                    request_status,
                    request_date) 
                VALUES(
                    :ticket_no,
                    :ticket_id,
                    :assigned_to,
                    :request_status,
                    :request_date)";
    $stmt_insert = $PDO->prepare($insert);
    $stmt_insert->bindParam(':ticket_no', $JSONData['ticketNo']);
    $stmt_insert->bindParam(':ticket_id', $JSONData['ticketId']);
    $stmt_insert->bindParam(':assigned_to', $JSONData['assingedTo']);
    $stmt_insert->bindParam(':request_status', $request_status);
    $stmt_insert->bindParam(':request_date', $SLA_time);
    if ($stmt_insert->execute()) {
        $answer["success"] = 1;
        $answer["message"] = "Assigned Tickets: " . $JSONData['ticketId'] . " เรียบร้อย" . $SLA_time . 'gggggggggggg';
        exit(json_encode($answer));
    } else {
        $answer["success"] = 0;
        $answer["message"] = "ไม่สามารถAssigned Ticket: " . $JSONData['ticketId'] . " ได้ " . $PDO->errorInfo();
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
