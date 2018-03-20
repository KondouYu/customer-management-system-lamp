<?php
include('../libraries/connect.php');
$path = '../data/'.basename(__FILE__);

$select_agent = '<select class="selectpicker agent" data-live-search="true">';
$select_agent .= '<option>-</option>';
foreach($pdo->query("SELECT * FROM agenci") as $ag) {
$select_agent .= '<option value="'.$ag['id'].'">'.$ag['nazwa'].'</option>';
}
$select_agent .= '</select>';
    
$select_flaga = '<select class="selectpicker flaga" data-live-search="true">';
$select_flaga .= '<option>-</option>';
foreach($pdo->query("SELECT * FROM flagi") as $fl) {
$select_flaga .= '<option value="'.$fl['id'].'" style="background: '.$fl['kolor'].'; color: white; text-transform: uppercase; text-shadow: 0px 0px 3px black; text-align: center;">'.$fl['nazwa'].'</option>';
}
$select_flaga .= '</select>';
    
$select_spolka = '<select class="selectpicker spolka" data-live-search="true">';
$select_spolka .= '<option>-</option>';
foreach($pdo->query("SELECT * FROM spolki") as $sp) {
$select_spolka .= '<option value="'.$sp['id'].'">'.$sp['nazwa'].'</option>';
}
$select_spolka .= '</select>';


$results = array(
    'select_agent' => $select_agent,
    'select_flaga' => $select_flaga,
    'select_spolka' => $select_spolka
);

$pdo = null;
echo json_encode($results, JSON_HEX_QUOT | JSON_HEX_TAG);
?>