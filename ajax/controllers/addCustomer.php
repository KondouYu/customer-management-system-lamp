<?php
include('../libraries/connect.php');
$path = '../data/'.basename(__FILE__);
 
$id = $_POST['id'];
$nazwisko = $_POST['nazwisko'];
$kod_pocztowy = $_POST['kod_pocztowy'];
$miejscowosc = $_POST['miejscowosc'];
$adres = $_POST['adres'];
$kod_pocztowy2 = $_POST['kod_pocztowy2'];
$miejscowosc2 = $_POST['miejscowosc2'];
$adres2 = $_POST['adres2'];
$pesel = $_POST['pesel'];
$nr_dowodu = $_POST['nr_dowodu'];
$data_wydania_dowodu = $_POST['data_wydania_dowodu'];
$organ_wydajacy_dowod = $_POST['organ_wydajacy_dowod'];
$telefon = $_POST['telefon'];
$telefon2 = $_POST['telefon2'];
$kwota_netto = $_POST['kwota_netto'];
$kwota_prowizja = $_POST['kwota_prowizja'];
$kwota_brutto = $_POST['kwota_brutto'];
$termin_zawarcia = $_POST['termin_zawarcia'];
$termin_platnosci = $_POST['termin_platnosci'];
$nr_umowy = $_POST['nr_umowy'];
$informacje = $_POST['informacje'];
$agent = $_POST['agent'];
$spolka = $_POST['spolka'];
$flaga = $_POST['flaga'];
$pracownik = $_POST['pracownik'];

$nowy = $pdo->prepare("INSERT INTO klienci (nazwisko, kod_pocztowy, miejscowosc, adres, kod_pocztowy2, miejscowosc2, adres2, pesel, nr_dowodu, data_wydania_dowodu, organ_wydajacy_dowod, telefon, telefon2, kwota_netto, kwota_prowizja, kwota_brutto, termin_zawarcia, termin_platnosci, nr_umowy, informacje, agent, spolka, pracownik, flaga, last_change) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$nowy->bindParam(1, $nazwisko);
$nowy->bindParam(2, $kod_pocztowy);
$nowy->bindParam(3, $miejscowosc);
$nowy->bindParam(4, $adres);
$nowy->bindParam(5, $kod_pocztowy2);
$nowy->bindParam(6, $miejscowosc2);
$nowy->bindParam(7, $adres2);
$nowy->bindParam(8, $pesel);
$nowy->bindParam(9, $nr_dowodu);
$nowy->bindParam(10, $data_wydania_dowodu);
$nowy->bindParam(11, $organ_wydajacy_dowod);
$nowy->bindParam(12, $telefon);
$nowy->bindParam(13, $telefon2);
$nowy->bindParam(14, $kwota_netto);
$nowy->bindParam(15, $kwota_prowizja);
$nowy->bindParam(16, $kwota_brutto);
$nowy->bindParam(17, $termin_zawarcia);
$nowy->bindParam(18, $termin_platnosci);
$nowy->bindParam(19, $nr_umowy);
$nowy->bindParam(20, $informacje);
$nowy->bindParam(21, $agent);
$nowy->bindParam(22, $spolka);
$nowy->bindParam(23, $pracownik);
$nowy->bindParam(24, $flaga);
$nowy->bindParam(25, date("Y-m-d H:i:s"));
$nowy->execute();
            
        if($flaga == 1){
            $data = explode('-', date('Y-m-d'));
            $stmt = $pdo->query("SELECT COUNT(*) FROM new_graph WHERE data = '".$data[0].' '.$data[1]."'");
            $exists = $stmt->fetchAll(PDO::FETCH_NUM);
            $exists = $exists[0][0];

            if($exists){
                $pdo->query("UPDATE new_graph SET ilosc=ilosc+1 WHERE data = '".$data[0].' '.$data[1]."'");
            } else {
                $pdo->query("INSERT INTO new_graph (data, ilosc) VALUES ('".$data[0].' '.$data[1]."', 0)");
                $pdo->query("UPDATE new_graph SET ilosc=ilosc+1 WHERE data = '".$data[0].' '.$data[1]."'");
            }
        }

echo print_r($_POST);
?>