<?php
include('../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try { //trickets_new
    // $request_status = 'assigned';
    $create_temp = "CREATE TEMPORARY TABLE all_action_tickets(
                    ticket_id VARCHAR(20),
                    request_by VARCHAR(255),
                    end_by VARCHAR(255),
                    ticket_status VARCHAR(10),
                    ticket_date datetime);";
    $PDO->query($create_temp);
    $insert_new = "INSERT INTO all_action_tickets
                    (ticket_id,
                    request_by,
                    ticket_status,
                    ticket_date)
                    SELECT tracking_id, 
                    request_by, 
                    IF(request_status <> 'new','new',request_status),
                    request_date
                    FROM trickets_new
                    WHERE  id = '" . $JSONData['ticketID'] . "' ;
                    ";
    $insert_assigned = "INSERT INTO all_action_tickets
                    (request_by,
                    end_by,
                    ticket_status,
                    ticket_date)
                    SELECT request_by, 
                    CONCAT(user.fname,' (',user.nickname,')') AS assigned_to,
                    request_status,
                    request_date
                    FROM trickets_assigned
		            LEFT JOIN user ON trickets_assigned.assigned_to = user.id
                    WHERE  tracking_new_id = '" . $JSONData['ticketID'] . "';;
                    ";
    $insert_pendding = "INSERT INTO all_action_tickets
                    (request_by,
                    ticket_status,
                    ticket_date)
                    SELECT CONCAT(user.fname,' (',user.nickname,')') AS pendding_by,
                    request_status,
                    request_date
                    FROM trickets_pendding
		            LEFT JOIN user ON trickets_pendding.pendding_by = user.id
                    WHERE  tracking_new_id = '" . $JSONData['ticketID'] . "';
                    ;;
                    ";
    $insert_close = "INSERT INTO all_action_tickets
                    (request_by,
                    ticket_status,
                    ticket_date)
                    SELECT CONCAT(user.fname,' (',user.nickname,')') AS close_by,
                    request_status,
                    request_date
                    FROM trickets_close
		            LEFT JOIN user ON trickets_close.assigned_to = user.id
                    WHERE  tracking_new_id = '" . $JSONData['ticketID'] . "';
                    ;
                    ";
    $insert_inprogress = "INSERT INTO all_action_tickets
                    (request_by,
                    ticket_status,
                    ticket_date)
                    SELECT CONCAT(user.fname,' (',user.nickname,')') AS inprogress_by, 
                    request_status,
                    request_date
                    FROM trickets_inprogress
		            LEFT JOIN user ON trickets_inprogress.assigned_to = user.id
                    WHERE  tracking_new_id = '" . $JSONData['ticketID'] . "';
                    ;
                    ";
    $PDO->query($insert_new);
    $PDO->query($insert_inprogress);
    $PDO->query($insert_assigned);
    $PDO->query($insert_pendding);
    $PDO->query($insert_close);
    $select = 'SELECT ticket_id ,request_by ,
                IF(end_by <> "",end_by,"-") AS end_by,ticket_status,ticket_date 
                FROM all_action_tickets
                ORDER BY ticket_date;
                ';
    $temp_select = $PDO->query($select);
    $numRows = $temp_select->rowCount();
    if ($numRows > 0) {
        $result = $temp_select->fetchAll(PDO::FETCH_ASSOC);
        $answer["res"] = $result;
        $answer["success"] = 1;
        $answer["message"] = "";
        exit(json_encode($answer));
    } else {
        $answer["success"] = 0;
        $answer["message"] = "ไม่มีใบงาน Assigned ในระบบ";
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
