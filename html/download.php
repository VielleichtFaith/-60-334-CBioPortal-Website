<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=result_file.csv");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_POST['dl'])){
 $data = json_decode($_POST['dl']);
 outputCSV($data);
 }

function outputCSV($data) {
    $flag = false;
    $output = fopen("php://output", "w");
    foreach ($data as $row) {
        if (!$flag){
           $flag = true;
           fputcsv($output, array_keys((array)$row));
        }
        fputcsv($output, (array)$row);
    }
    fclose($output);
}
?>