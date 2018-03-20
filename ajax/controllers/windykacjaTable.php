<?php
include('../libraries/connect.php');
include('../libraries/display.php');
?>

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
        
                $dni = $_POST['n'];
                $agent = $_POST['agent'];
        
            if($agent != '-' && $agent != 'all'){
				if($dni == 1) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent = '$agent'") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
				        $data = strtotime($row['termin_platnosci']);
				        $dzis = floor($dzis/86400);
				        $data = floor($data/86400);
				        $spoznienie = $roznica =  $dzis - $data;
				        if($spoznienie >= 0 && $spoznienie <= 7){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                       }
				    }
				}
				 
				if($dni == 2) {
                    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent = '$agent'") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
				        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 8 && $spoznienie <= 14){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
				 
				if($dni == 3) {
                    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent = '$agent'") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 15 && $spoznienie <= 21){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
                    }
				}
				 
				if($dni == 4) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent = '$agent'") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 22 && $spoznienie <= 29){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
				 
				if($dni == 5) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent = '$agent'") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 30 && $spoznienie <= 60){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
            
                if($dni == 6) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent = '$agent'") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 0 && $spoznienie <= 200){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
                
            }
            
            if($agent == "all") {
                
                if($dni == 1) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent != 2 AND agent != 26 AND agent != 27") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
				        $data = strtotime($row['termin_platnosci']);
				        $dzis = floor($dzis/86400);
				        $data = floor($data/86400);
				        $spoznienie = $roznica =  $dzis - $data;
				        if($spoznienie >= 0 && $spoznienie <= 7){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                       }
				    }
				}
				 
				if($dni == 2) {
                    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent != 2 AND agent != 26 AND agent != 27") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
				        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 8 && $spoznienie <= 14){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
				 
				if($dni == 3) {
                    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent != 2 AND agent != 26 AND agent != 27") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 15 && $spoznienie <= 21){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
                    }
				}
				 
				if($dni == 4) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent != 2 AND agent != 26 AND agent != 27") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 22 && $spoznienie <= 29){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
				 
				if($dni == 5) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent != 2 AND agent != 26 AND agent != 27") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 30 && $spoznienie <= 60){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
            
                if($dni == 6) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE (flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5) AND agent != 2 AND agent != 26 AND agent != 27") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 0 && $spoznienie <= 200){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
                
            } 
            
            if($agent == '-') {
                if($dni == 1) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
				        $data = strtotime($row['termin_platnosci']);
				        $dzis = floor($dzis/86400);
				        $data = floor($data/86400);
				        $spoznienie = $roznica =  $dzis - $data;
				        if($spoznienie >= 0 && $spoznienie <= 7){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                       }
				    }
				}
				 
				if($dni == 2) {
                    foreach($pdo->query("SELECT * FROM klienci WHERE flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
				        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 8 && $spoznienie <= 14){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
				 
				if($dni == 3) {
                    foreach($pdo->query("SELECT * FROM klienci WHERE flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 15 && $spoznienie <= 21){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
                    }
				}
				 
				if($dni == 4) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 22 && $spoznienie <= 29){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
				 
				if($dni == 5) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 30 && $spoznienie <= 60){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
            
                if($dni == 6) {
				    foreach($pdo->query("SELECT * FROM klienci WHERE flaga = 1 OR flaga = 2 OR Flaga = 4 OR Flaga = 5") as $row) {
                        $dzis = strtotime(date('Y-m-d'));
                        $data = strtotime($row['termin_platnosci']);
                        $dzis = floor($dzis/86400);
                        $data = floor($data/86400);
                        $spoznienie = $roznica =  $dzis - $data;
                        if($spoznienie >= 0 && $spoznienie <= 200){
                            echo '<tr class="" style="cursor: pointer;" onclick="createWindow(\''.$row['id'].'\');">';
                            echo '<td>'.$row['nazwisko'].'</td>';
                            echo '<td class="text-center">'.$row['telefon'].'</td>';
                            echo '<td class="text-center">'.$row['kod_pocztowy'].'</td>';
                            echo '<td class="text-center">'.$row['miejscowosc'].'</td>';
                            echo '<td class="text-center">'.$spoznienie.'</td>';
                            echo '<td  class="text-center">'.$row['kwota_brutto'].' zł</td>';
                            echo '<td class="text-center">'.display_flag($row['flaga']).'</td>';
                            echo '<td class="text-right">'.display_agent($row['agent']).'</td>';
                            echo '<td class="text-right">'.display_spolka($row['spolka']).'</td>';
                            echo '</tr>';
                        }
				    }
				}
            }
                ?>

        </tbody>
    </table>