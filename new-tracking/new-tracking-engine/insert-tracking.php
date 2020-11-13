<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $generate_bill = "select tracking_no,request_date from trickets_new order by request_date  DESC, tracking_no DESC ";
    $stmt_generate = $PDO->query($generate_bill);
    $result = $stmt_generate->fetch(PDO::FETCH_ASSOC);
    $toDay_forCompare =  date('Y-m-d');
    $newDate = substr($result['request_date'], 0, 10);
    if ($toDay_forCompare == $newDate) {
        $new_generate = $result['tracking_no'] += 1;
    } else {
        $new_generate = 1;
    }
    $today = date('Ymd');

    function invoice_num($input, $pad_len = 7, $prefix = null)
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
    $track_id = invoice_num($new_generate, 7, "KKC" . $today . "/");
    $defaultStatus = 'new';
    $insert_sql = "INSERT INTO 
                    trickets_new
                    (
                    tracking_no,
                    tracking_id,
                    request_by  ,
                    request_title ,
                    request_detail ,
                    request_img,
                    request_status
                    )
                    VALUES 
                    (
                     :tracking_no,
                     :tracking_id,
                     :request_by ,
                     :request_title ,
                     :request_detail ,
                     :request_img,
                     :request_status
                     )
                     ";
    $stmt_insert = $PDO->prepare($insert_sql);
    $stmt_insert->bindParam(':tracking_no', $new_generate);
    $stmt_insert->bindParam(':tracking_id', $track_id);
    $stmt_insert->bindParam(':request_by', $JSONData['request_by']);
    $stmt_insert->bindParam(':request_title', $JSONData['request_title']);
    $stmt_insert->bindParam(':request_detail', $JSONData['request_detail']);
    $stmt_insert->bindParam(':request_img', $JSONData['request_img']);
    $stmt_insert->bindParam(':request_status', $defaultStatus);
    if ($stmt_insert->execute()) {
        $answer["success"] = 1;
        $answer["message"] = "เปิดใบงานเรียบร้อย";
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
