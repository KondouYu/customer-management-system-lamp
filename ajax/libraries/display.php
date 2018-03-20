<?php
function display_flag($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM flagi WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute(); 
    $flaga = $stmt->fetch();   
    return '<span class="label" style="background: '.$flaga['kolor'].'; text-transform: uppercase; text-shadow: 0px 0px 3px black;" onclick="event.stopPropagation();">'.$flaga['nazwa'].'</span>';
}

function display_flag_color($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM flagi WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute(); 
    $flaga = $stmt->fetch();
    return $flaga['kolor'];
}

function display_flag_name($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM flagi WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute(); 
    $flaga = $stmt->fetch();   
    return $flaga['nazwa'];
}

function display_agent($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM agenci WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute(); 
    $agent = $stmt->fetch();
    return $agent['nazwa'];
}

function display_spolka($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM spolki WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute(); 
    $spolka = $stmt->fetch();
    return $spolka['nazwa'];
}

function display_late($flaga, $termin_platnosci){
    $spoznienie = '-';
    if($flaga == 1 OR $flaga == 2 OR $flaga == 4 OR $flaga == 5 OR $flaga == 11)
    {
        $dzis = strtotime(date('Y-m-d'));
        $data = strtotime($termin_platnosci);
        $dzis = floor($dzis/86400);
        $data = floor($data/86400);
        $roznica =  $dzis - $data;
        if($roznica >= 0)
            $spoznienie = $roznica;
        if($roznica < 0) $spoznienie = $roznica;
        if($roznica >= 0) $spoznienie = '<span style="color: red; font-weight: bold;">'.$roznica.'</span>';
    }
    return $spoznienie;
}

?>