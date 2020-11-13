<?php
date_default_timezone_set('Asia/Bangkok');
// date_default_timezone_set('Asia/Bangkok');
// $date2 = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('Asia/Bangkok'));
// $date1 = new DateTime(date('14:15 T'), new DateTimeZone('Asia/Bangkok'));
// echo $date2->format('H:i:s');
// echo "<br>" . date("H:i:s");
// $interval = date_diff($date1, $date2);

// $date_format_y = $interval->format("%y");
// $date_format_m = $interval->format("%m");
// $date_format_d = $interval->format("%d");
// $date_format_h = $interval->format("%h");
// $date_format_i = $interval->format("%i");
// if ($date_format_y > 0) {
//     $res[] = [$interval->format("%y ปี %m เดือน %d วัน %h ชั่วโมง %i นาที")];
// } else if ($date_format_m > 0) {
//     $res[] = [$interval->format("%m เดือน %d วัน %h ชั่วโมง %i นาที")];
// } else if ($date_format_d > 0) {
//     $res[] = [$interval->format("%d วัน %h ชั่วโมง %i นาที")];
// } else if ($date_format_h > 0) {
//     $res[] = [$interval->format("%h ชั่วโมง %i นาที")];
// } else {
//     $res[] = [$interval->format("%i นาที")];
// }

// print_r($res);


$dT = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('Asia/Bangkok'));

//Lets subtract 4 hours.
$hoursToSubtract = (int)'72';

//Subtract the hours using DateTime::sub and DateInterval.
$dT->sub(new DateInterval("PT{$hoursToSubtract}M"));

//Format and print it out.
$SLA_time = $dT->format('Y-m-d H:i:s');
echo $SLA_time;
$date2 = new DateTime('2020-10-25', new DateTimeZone('Asia/Bangkok'));
$date1 = new DateTime('2020-10-25', new DateTimeZone('Asia/Bangkok'));
$interval = date_diff($date1, $date2);
