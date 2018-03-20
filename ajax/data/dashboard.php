<?php
// =========== DASHBOARD STATS ==============
global $pdo;
$query = $pdo->query("SELECT COUNT(*) FROM klienci");
$query = $query->fetchAll(PDO::FETCH_NUM);
$wszystkich = $query[0][0];

$data = explode('-', date('Y-m-d'));
$stmt = $pdo->query("SELECT ilosc FROM new_graph WHERE data = '".$data[0].' '.$data[1]."'");
$nowi = $stmt->fetchAll(PDO::FETCH_NUM);
$nowi = $nowi[0][0];
if($nowi == '') $nowi = 0;

$query = $pdo->query("SELECT COUNT(*) FROM klienci WHERE flaga = '7'");
$query = $query->fetchAll(PDO::FETCH_NUM);
$w_sadzie = $query[0][0];

$query = $pdo->query("SELECT COUNT(*) FROM klienci WHERE flaga = '9'");
$query = $query->fetchAll(PDO::FETCH_NUM);
$u_komornika = $query[0][0];

$query = $pdo->query("SELECT COUNT(*) FROM klienci WHERE flaga = '3'");
$query = $query->fetchAll(PDO::FETCH_NUM);
$splaconych = $query[0][0];

$query = $pdo->query("SELECT COUNT(*) FROM klienci WHERE flaga = '2'");
$query = $query->fetchAll(PDO::FETCH_NUM);
$czynnych = $query[0][0];

$query = $pdo->query("SELECT COUNT(*) FROM klienci WHERE flaga = '1'");
$query = $query->fetchAll(PDO::FETCH_NUM);
$c_nowi = $query[0][0];

$query = $pdo->query("SELECT SUM(kwota_netto) AS netto, SUM(kwota_brutto) AS brutto FROM klienci WHERE flaga = '1' OR flaga = '2'");
$query = $query->fetchAll(PDO::FETCH_ASSOC);
$kwota = $query[0];

$query = $pdo->query("SELECT SUM(kwota_brutto) AS brutto FROM klienci WHERE flaga = '4'");
$query = $query->fetchAll(PDO::FETCH_ASSOC);
$kapital = $query[0];

$query = $pdo->query("SELECT SUM(kwota_brutto) AS brutto FROM klienci WHERE flaga = '11'");
$query = $query->fetchAll(PDO::FETCH_ASSOC);
$ugoda = $query[0];
            
$results = array(
    'wszystkich' => $wszystkich,
    'netto' => $kwota['netto'],
    'brutto' => $kwota['brutto'],
    'kapital' => $kapital['brutto'],
    'ugoda' => $ugoda['brutto'],
    'nowych' => $nowi,
    'w_sadzie' => $w_sadzie,
    'u_komornika' => $u_komornika,
    'splaconych' => $splaconych,
    'czynnych' => $czynnych,
    'c_nowych' => $c_nowi,
);

$result['stats'] = $results;

// ===========   TODAY OPERATIONS ==============

$results = '<table class="table table-hover table-striped table-condensed table-responsive dataTable">';
$results .= '<thead>';

$results .= '<tr>
            <th>NAZWISKO</th>
            <th class="text-center">SPÓŹNIENIE</th>
            <th class="text-center">KWOTA BRUTTO</th>
            <th class="text-center">FLAGA</th>
            <th class="text-right">AGENT</th>
            </tr>';

$results .= '</thead>';

$results .= '<tbody>';

$dzis = date('Y-m-d');
foreach($pdo->query("SELECT * FROM  klienci WHERE last_change LIKE '$dzis%' AND (FLAGA = '1' OR FLAGA = '2' OR FLAGA = '3' OR FLAGA = '4' OR FLAGA = '11') ORDER BY last_change DESC") as $row) {
    $results .= '<tr class="unselectable" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">
                <td>'.$row['nazwisko'].'</td>
                <td class="text-center">'.display_late($row['flaga'], $row['termin_platnosci']).'</td>
                <td  class="text-center">'.$row['kwota_brutto'].' zł</td>
                <td class="text-center">'.display_flag($row['flaga']).'</td>
                <td class="text-right">'.display_agent($row['agent']).'</td>
                </tr>';
}
$results .= '</tbody>';

$results .= '</table>';

$result['today'] = $results;

$pdo = null;
return json_encode($result, JSON_HEX_QUOT | JSON_HEX_TAG);
?>