<?php
// ===========   TODAY OPERATIONS ==============
include('../libraries/connect.php');
include('../libraries/display.php');

$results = '<table class="table table-condensed table-responsive dataTable">';
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

$query = $_POST['query'];
$search_option = $_POST['search_option'];

switch($search_option){
    case 1:
        foreach($pdo->query("SELECT id, nazwisko, flaga, termin_platnosci, kwota_brutto, agent FROM klienci WHERE nazwisko LIKE '%$query%'") as $row) {
        $results .= '<tr class="unselectable" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">
                    <td>'.$row['nazwisko'].'</td>
                    <td class="text-center">'.display_late($row['flaga'], $row['termin_platnosci']).'</td>
                    <td  class="text-center">'.$row['kwota_brutto'].' zł</td>
                    <td class="text-center">'.display_flag($row['flaga']).'</td>
                    <td class="text-right">'.display_agent($row['agent']).'</td>
                    </tr>';
        }
        break;
    case 2:
        foreach($pdo->query("SELECT id, nazwisko, flaga, termin_platnosci, kwota_brutto, telefon, telefon2, agent FROM klienci WHERE telefon LIKE '%$query%' OR telefon2 LIKE '%$query%'") as $row) {
        $results .= '<tr class="unselectable" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">
                    <td>'.$row['nazwisko'].'</td>
                    <td class="text-center">'.display_late($row['flaga'], $row['termin_platnosci']).'</td>
                    <td  class="text-center">'.$row['kwota_brutto'].' zł</td>
                    <td class="text-center">'.display_flag($row['flaga']).'</td>
                    <td class="text-right">'.display_agent($row['agent']).'</td>
                    </tr>';
        }
        break;
    case 3:
        foreach($pdo->query("SELECT id, nazwisko, flaga, termin_platnosci, kwota_brutto, pesel, agent FROM klienci WHERE pesel LIKE '%$query%'") as $row) {
        $results .= '<tr class="unselectable" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">
                    <td>'.$row['nazwisko'].'</td>
                    <td class="text-center">'.display_late($row['flaga'], $row['termin_platnosci']).'</td>
                    <td  class="text-center">'.$row['kwota_brutto'].' zł</td>
                    <td class="text-center">'.display_flag($row['flaga']).'</td>
                    <td class="text-right">'.display_agent($row['agent']).'</td>
                    </tr>';
        }
        break;
}

$results .= '</tbody>';

$results .= '</table>';

$search = $results;

$pdo = null;
echo json_encode($search, JSON_HEX_QUOT | JSON_HEX_TAG);
?>