<?php
include('../../config/connect.php');
$answer = array("success" => 0, "message" => "");
if (!isset($_POST['json'])) {
    $answer["message"] = "No data is received!";
    exit(json_encode($answer));
}
$JSONData = json_decode($_POST['json'], true);

try {
    $request_status = 'inprogress';
    $select = "SELECT trickets_new.id,
                      trickets_new.request_by,
                      trickets_new.tracking_id,
                      trickets_new.request_status,
                      trickets_new.request_date AS SLA_time,
                      trickets_new.pendding_time_period,
                      trickets_inprogress.assigned_to,
                      trickets_inprogress.request_date,
                      CONCAT(user.fname,' (',user.nickname,')') as name
                      FROM trickets_inprogress
                      RIGHT JOIN trickets_new ON trickets_inprogress.tracking_new_id = trickets_new.id
                      RIGHT JOIN user ON trickets_inprogress.assigned_to = user.id
                      WHERE trickets_inprogress.id IN (
                      SELECT Max(trickets_inprogress.id)
                      FROM trickets_inprogress
                      GROUP BY trickets_inprogress.tracking_new_id
                      ) AND trickets_new.request_status = '" . $request_status . "'";
    $stmt_select = $PDO->query($select);
    $numRows = $stmt_select->rowCount();
    if ($numRows > 0) {
        $res = [];
        $date2 = new DateTime(date('Y-m-d H:i:s T'), new DateTimeZone('Asia/Bangkok'));
        while ($result = $stmt_select->fetch(PDO::FETCH_ASSOC)) {

            if ($result['pendding_time_period'] != null) {
                $date1_havedPendding = new DateTime($result['SLA_time'], new DateTimeZone('Asia/Bangkok'));
                $dT = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('Asia/Bangkok'));
                //Lets subtract 4 hours.
                $minuteToSubtract = (int) $result['pendding_time_period'];
                //Subtract the hours using DateTime::sub and DateInterval.
                $dT->sub(new DateInterval("PT{$minuteToSubtract}M"));
                //Format and print it out.
                $SLA_time = $dT->format('Y-m-d H:i:s');

                $date2_havedPendding = new DateTime($SLA_time, new DateTimeZone('Asia/Bangkok'));
                $interval = date_diff($date1_havedPendding, $date2_havedPendding);
                $date_format_y = $interval->format("%y");
                $date_format_m = $interval->format("%m");
                $date_format_d = $interval->format("%d");
                $date_format_h = $interval->format("%h");
                $date_format_i = $interval->format("%i");
            } else {
                $date1 = new DateTime($result['SLA_time'], new DateTimeZone('Asia/Bangkok'));
                $interval = date_diff($date1, $date2);
                $date_format_y = $interval->format("%y");
                $date_format_m = $interval->format("%m");
                $date_format_d = $interval->format("%d");
                $date_format_h = $interval->format("%h");
                $date_format_i = $interval->format("%i");
            }
            if ($date_format_y > 0) {
                $res[] = [$result, $interval->format("%y ปี %m เดือน %d วัน %h ชั่วโมง %i นาที")];
            } else if ($date_format_m > 0) {
                $res[] = [$result, $interval->format("%m เดือน %d วัน %h ชั่วโมง %i นาที")];
            } else if ($date_format_d > 0) {
                $res[] = [$result, $interval->format("%d วัน %h ชั่วโมง %i นาที")];
            } else if ($date_format_h > 0) {
                $res[] = [$result, $interval->format("%h ชั่วโมง %i นาที")];
            } else {
                $res[] = [$result, $interval->format("%i นาที")];
            }
        }
        $answer["res"] = $res;
        $answer["success"] = 1;
        $answer["message"] = "";
        exit(json_encode($answer));
    } else {
        $answer["success"] = 0;
        $answer["message"] = "ไม่มีใบงาน Inprogress ในระบบ";
        exit(json_encode($answer));
    }
} catch (PDOException $e) {
    $answer["success"] = 0;
    $answer["message"] = $e->getMessage();
    //echo json_encode(array("data" => $answer));
    exit(json_encode($answer));
}
