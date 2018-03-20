<?php
include('../libraries/connect.php');
include('../libraries/display.php');
?>
  
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Klienci
            <small>Lista wszystkich klientów</small>
          </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Root</a></li>
            <li>Dashboard</li>
            <li class="active">Lista klientów</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
        <table class="table table-hover table-striped table-condensed table-responsive dataTable">
            <thead>
                <tr>
                    <th>NAZWISKO</th>
                    <th class="text-center">NR. TELEFONU</th>
                    <th class="text-center">KOD POCZTOWY</th>
                    <th class="text-center">MIEJSCOWOŚĆ</th>
                    <th class="text-center">SPÓŹNIENIE</th>
                    <th class="text-center">KWOTA BRUTTO</th>
                    <th class="text-center">FLAGA</th>
                    <th class="text-right">AGENT</th>
                    <th class="text-right">SPOLKA</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                foreach($pdo->query("SELECT * FROM klienci") as $row) {
                    echo '<tr class="unselectable" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                    echo '<td>'.$row['nazwisko'].'</td>';
                    echo '<td class="text-center">'.$row['telefon'].'</td>';
                    echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                    echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                    echo '<td class="text-center">'.display_late($row['flaga'], $row['termin_platnosci']).'</td>';
                    echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                    echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                    echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                    echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                    echo '</tr>';
                }
                ?>
                
            </tbody>
        </table>

    </section>
<!-- /.content -->