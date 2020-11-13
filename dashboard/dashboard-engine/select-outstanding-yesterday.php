<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $select = "SELECT request_status,
                COUNT(request_status) AS count_outstanding
                from trickets_new
                WHERE request_status NOT IN('close') AND
                DATE(request_date) = DATE(NOW() - INTERVAL 1 DAY)
                GROUP BY request_status LIMIT 5;
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
        $answer["message"] = $PDO->errorInfo();
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
