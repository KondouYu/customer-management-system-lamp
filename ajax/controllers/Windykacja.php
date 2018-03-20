<?php
include('../libraries/connect.php');
include('../libraries/display.php');
?>
  
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Windykacja
            <small>Lista klientów spóźnionych</small>
          </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Root</a></li>
            <li>Dashboard</li>
            <li class="active">Windykacja</li>
        </ol>
        
    </section>
        
    <!-- Main content -->
    <section class="content">
    
    <div class="row">
    <div class="col-md-8">
    <select class="selectpicker form-control" id="windykacjaZakres" onchange="windykacjaTable($('#windykacjaZakres').val(), $('#windykacjaAgent').val());" data-live-search="true">
        <option>Wybierz zakres dni</option>
        <option value="1">0 - 7</option>
        <option value="2">8 - 14</option>
        <option value="3">15 - 21</option>
        <option value="4">22 - 29</option>
        <option value="5">30 - 60</option>
        <option value="6">0 - 200</option>
    </select>
    </div>
    
    <div class="col-md-4">
    <select class="selectpicker form-control" id="windykacjaAgent" onchange="windykacjaTable($('#windykacjaZakres').val(), $('#windykacjaAgent').val());" data-live-search="true">
        <option value="-">Wybierz agenta</option>
        <option value="all">Wszyscy wyłączając Zabrze, Zabrze C9, Centrum 9</option>
        <?php
            foreach($pdo->query("SELECT * FROM agenci") as $row) {
                echo '<option value="'.$row['id'].'">'.$row['nazwa'].'</option>';
            }
        ?>
    </select>
    </div>
    </div>
    
    
    <div id="windykacja" style="margin-top: 15px;"></div>

    </section>
<!-- /.content -->