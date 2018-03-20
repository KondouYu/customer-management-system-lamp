<?php
global $pdo;

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM klienci WHERE id = '$id'");
$query = $query->fetchAll(PDO::FETCH_NUM);
$query = $query[0];

$select_agent = '<select class="selectpicker agent" onchange="save_customer('.$id.');" data-live-search="true">';
$select_agent .= '<option>-</option>';
foreach($pdo->query("SELECT * FROM agenci") as $ag) {
$select_agent .= '<option value="'.$ag['id'].'">'.$ag['nazwa'].'</option>';
}
$select_agent .= '</select>';
    
$select_flaga = '<select class="selectpicker flaga" onchange="save_customer('.$id.');" data-live-search="true">';
$select_flaga .= '<option>-</option>';
foreach($pdo->query("SELECT * FROM flagi") as $fl) {
$select_flaga .= '<option value="'.$fl['id'].'" style="background: '.$fl['kolor'].'; color: white; text-transform: uppercase; text-shadow: 0px 0px 3px black; text-align: center;">'.$fl['nazwa'].'</option>';
}
$select_flaga .= '</select>';
    
$select_spolka = '<select class="selectpicker spolka" onchange="save_customer('.$id.');" data-live-search="true">';
$select_spolka .= '<option>-</option>';
foreach($pdo->query("SELECT * FROM spolki") as $sp) {
$select_spolka .= '<option value="'.$sp['id'].'">'.$sp['nazwa'].'</option>';
}
$select_spolka .= '</select>';


//WPISY

$wpisy = '<table class="table table-striped table-hover wpisyT">';
$wpisy .= '    <thead>';
$wpisy .= '        <tr>';
$wpisy .= '            <th>DATA</th>';
$wpisy .= '            <th>WPIS</th>';
$wpisy .= '            <th>PRACOWNIK</th>';
$wpisy .= '            <th></th>';
$wpisy .= '        </tr>';
$wpisy .= '    </thead>';
$wpisy .= '    <tbody>';
        foreach($pdo->query("SELECT * FROM  wpisy WHERE id_klienta = '$id' ORDER BY data DESC") as $row) {
            $wpisy .= '<tr>';
            $data = explode(" ", $row['data']);
            if($data[1] == '00:00:00') $data[1] = "";
            else $data[1] = ' '.$data[1];
            $wpisy .= '<td class="text-center" style="width: 100px; min-width: 100px; border-top: 1px solid rgba(192, 192, 192, 0.3);">'.$data[0].$data[1].'</td>';
            $wpisy .= '<td style="border-top: 1px solid rgba(192, 192, 192, 0.3);">'.$row['wpis'].'</td>';
            $wpisy .= '<td class="text-nowrap text-right" style="border-top: 1px solid rgba(192, 192, 192, 0.3); width: 100px;">'.$row['pracownik'].'</td>';
            $wpisy .= '<td class="text-center" style="width: 20px;"><span class="btn btn-default" style="border-radius: 0px;cursor: pointer;" onclick="deleteWpis('.$row['id'].');"><i class="fa fa-trash-o"></i></span></td>';
            $wpisy .= '</tr>';
        }
$wpisy .= '</tbody>';
$wpisy .= '</table>';

//WINDYKACJA

$windykacja = '<table class="table table-striped table-hover windykacjaT">';
$windykacja .= '    <thead>';
$windykacja .= '        <tr>';
$windykacja .= '            <th>DATA</th>';
$windykacja .= '            <th>WPIS</th>';
$windykacja .= '            <th>PRACOWNIK</th>';
$windykacja .= '            <th></th>';
$windykacja .= '        </tr>';
$windykacja .= '    </thead>';
$windykacja .= '    <tbody>';
        foreach($pdo->query("SELECT * FROM  windykacja WHERE id_klienta = '$id' ORDER BY data DESC") as $row) {
            $windykacja .= '<tr>';
            $data = explode(" ", $row['data']);
            if($data[1] == '00:00:00') $data[1] = "";
            else $data[1] = ' '.$data[1];
            $windykacja .= '<td class="text-center" style="width: 100px; min-width: 100px; border-top: 1px solid rgba(192, 192, 192, 0.3);">'.$data[0].$data[1].'</td>';
            $windykacja .= '<td style="border-top: 1px solid rgba(192, 192, 192, 0.3);">'.$row['wpis'].'</td>';
            $windykacja .= '<td class="text-nowrap text-right" style="border-top: 1px solid rgba(192, 192, 192, 0.3); width: 100px;">'.$row['pracownik'].'</td>';
            $windykacja .= '<td class="text-center" style="width: 20px;"><span class="btn btn-default" style="border-radius: 0px; cursor: pointer;" onclick="deleteWindykacja('.$row['id'].');"><i class="fa fa-trash-o"></i></span></td>';
            $windykacja .= '</tr>';
        }
$windykacja .= '</tbody>';
$windykacja .= '</table>';

//DRUKOWANIE

if(substr(trim($query[1]), -1) == 'a') {
    $zwrot[0] = "Szanowna Pani";
    $zwrot[1] = "Pani";
    $zwrot[2] = "Pani";
    $zwrot[3] = "Panią";
    $zwrot[4] = "Pani";
} else {
    $zwrot[0] = "Szanowny Pan";
    $zwrot[1] = "Pan";
    $zwrot[2] = "Pana";
    $zwrot[3] = "Pana";
    $zwrot[4] = "Panu";
}

$drukowanie = '
<select class="form-control selectpicker" id="zmiana_dokumentu" onchange="zmiana_dokumentu(\''.$query[0].'\', $(\'#'.$query[0].' #zmiana_dokumentu\').val());">
<option value="1">Wezwanie do Cesji P-Finanse</option>
<option value="2">Wezwanie do Cesji Tomasz Finanse</option>
<option value="3">Cesja wierzytelności wekslowej P-Finanse</option>
<option value="4">Cesja wierzytelności wekslowej Tomasz Finanse</option>
<option value="5">Zawiadomienie o cesji P-Finanse</option>
<option value="6">Zawiadomienie o cesji Tomasz Finanse</option>
</select>

<style>
.zmienna {
color: blue;
}
</style>

<div id="druk">

<div class="print-content1">
<p class="MsoNormal" align="right" style="margin-bottom:0cm;margin-bottom:.0001pt;
text-align:right"><span style="font-size:10.0pt;line-height:115%;font-family:
&quot;Bookman Old Style&quot;,serif" class="zmienna" contenteditable="true">Zabrze, dnia '.date("d.m.Y").' r.<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">Martom
Finanse S.C. <o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">Marek
Dybowski, Tomasz Bachur<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">ul.
Goethego 28/4<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">41-800
Zabrze<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif">'.$zwrot[0].'<o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif">'.$query[1].'<o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><span class="a1">ul. '.$query[4].'</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><span class="a2">'.$query[2].' '.$query[3].'</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" align="center" style="margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center"><b><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">Wezwanie
do wykupu weksla<o:p></o:p></span></b></p>

<p class="MsoNormal" align="center" style="margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center"><b><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" style="text-align:justify;text-indent:35.4pt;line-height:
150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">W związku z nabyciem w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span> 
przez Martom Finanse S.C. Marek Dybowski, Tomasz Bachur
wierzytelności wekslowej w kwocie <span class="zmienna" contenteditable="true">2.100,00 zł</span> przysługującej <nobr>P-Finanse Sp.
z o.o.</nobr> wobec '.$zwrot[2].', wzywam '.$zwrot[3].' do wykupu weksla własnego wystawionego w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>
na kwotę <span class="zmienna" contenteditable="true">2.100,00 zł</span>, z terminem płatności w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>
Oryginał weksla znajduje się do wglądu w siedzibie Martom Finanse S.C. Marek
Dybowski, Tomasz Bachur przy ul. Goethego 28/4 w Zabrzu.<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify;text-indent:35.4pt;line-height:
150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">Wskazaną kwotę pieniężną należy
wpłacić na rachunek bankowy wierzyciela o numerze:<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify;text-indent:18.0pt;line-height:
150%"><b><span style="font-size:10.0pt;
line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;mso-fareast-font-family:
&quot;Bookman Old Style&quot;;mso-bidi-font-family:&quot;Bookman Old Style&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></b><b><span style="font-size:10.0pt;line-height:
150%;font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><span>BZ WBK O/Tychy</span> <span>70 1090 1652 0000 0001 1980 4266</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nieuregulowanie
przedmiotowej należności spowoduje skierowanie sprawy na drogę postępowania
sądowego, co narazi '.$zwrot[3].' na&nbsp;poniesienie dodatkowych kosztów.<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">W przypadku pytań prosimy o kontakt
telefoniczny z działem windykacji tel: 690&nbsp;900&nbsp;660. <o:p></o:p></span></p>

</div>

<div class="print-content2" style="display: none;">
<p class="MsoNormal" align="right" style="margin-bottom:0cm;margin-bottom:.0001pt;
text-align:right"><span style="font-size:10.0pt;line-height:115%;font-family:
&quot;Bookman Old Style&quot;,serif" class="zmienna" contenteditable="true">Zabrze, dnia '.date("d.m.Y").' r.<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">Martom
Finanse S.C. <o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">Marek
Dybowski, Tomasz Bachur<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">ul.
Goethego 28/4<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">41-800
Zabrze<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif">'.$zwrot[0].'<o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif">'.$query[1].'<o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><span class="a1">ul. '.$query[4].'</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:212.4pt;margin-bottom:.0001pt;text-indent:35.4pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><span class="a2">'.$query[2].' '.$query[3].'</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt"><b><span style="font-size:10.0pt;line-height:
115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt"><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" align="center" style="margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center"><b><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif">Wezwanie
do wykupu weksla<o:p></o:p></span></b></p>

<p class="MsoNormal" align="center" style="margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center"><b><span style="font-size:10.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" style="text-align:justify;text-indent:35.4pt;line-height:
150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">W związku z nabyciem w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span> 
przez Martom Finanse S.C. Marek Dybowski, Tomasz Bachur
wierzytelności wekslowej w kwocie <span class="zmienna" contenteditable="true">2.100,00 zł</span> przysługującej <nobr>Tomasz Finanse Sp.
z o.o.</nobr> wobec '.$zwrot[2].', wzywam '.$zwrot[3].' do wykupu weksla własnego wystawionego w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>
na kwotę <span class="zmienna" contenteditable="true">2.100,00 zł</span>, z terminem płatności w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>
Oryginał weksla znajduje się do wglądu w siedzibie Martom Finanse S.C. Marek
Dybowski, Tomasz Bachur przy ul. Goethego 28/4 w Zabrzu.<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify;text-indent:35.4pt;line-height:
150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">Wskazaną kwotę pieniężną należy
wpłacić na rachunek bankowy wierzyciela o numerze:<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify;text-indent:18.0pt;line-height:
150%"><b><span style="font-size:10.0pt;
line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;mso-fareast-font-family:
&quot;Bookman Old Style&quot;;mso-bidi-font-family:&quot;Bookman Old Style&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></b><b><span style="font-size:10.0pt;line-height:
150%;font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><span>BZ WBK O/Tychy</span> <span>70 1090 1652 0000 0001 1980 4266</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nieuregulowanie
przedmiotowej należności spowoduje skierowanie sprawy na drogę postępowania
sądowego, co narazi '.$zwrot[3].' na&nbsp;poniesienie dodatkowych kosztów.<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-family:&quot;Bookman Old Style&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;line-height:150%"><span style="font-size:10.0pt;line-height:150%;font-family:&quot;Bookman Old Style&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">W przypadku pytań prosimy o kontakt
telefoniczny z działem windykacji tel: 690&nbsp;900&nbsp;660. <o:p></o:p></span></p>

</div>

<div class="print-content3" style="display: none;">
<p class="text-center" align="center" style="margin:0cm;margin-bottom:.0001pt;
text-align:center;line-height:115%;background:white"><b><span style="font-size:
8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">UMOWA</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p class="text-center" align="center" style="margin:0cm;margin-bottom:.0001pt;
text-align:center;line-height:115%;background:white"><b><span style="font-size:
8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">cesji
wierzytelności wekslowej<o:p></o:p></span></b></p>

<p class="text-center" style="margin:0cm;margin-bottom:.0001pt;text-align:justify;
line-height:115%;background:white"><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;"><o:p>&nbsp;</o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">Zawarta w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span> pomiędzy:<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><b><span style="font-size: 8pt; font-family: Cambria, serif;">P-Finanse Sp. z o.o. </span></b><span style="font-size: 8pt; font-family: Cambria, serif;">z siedzibą w Gliwicach, ul. Lipowa 14, 44-102
Gliwice, wpisaną do Krajowego Rejestru Przedsiębiorców prowadzonego przez Sąd
Rejonowy w Gliwicach X Wydział Gospodarczy KRS, pod numerem KRS 0000612172, NIP
631-266-21-80, REGON 364179238, kapitał zakładowy 200.000,00 zł, <o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-size: 8pt; font-family: Cambria, serif;">reprezentowana przez:<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-size: 8pt; font-family: Cambria, serif;">Przemysława Stolarka – Prezesa Zarządu<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-size:8.0pt;font-family:&quot;Cambria&quot;,serif">Dawida
Yerginyan&nbsp; - Członka Zarządu</span><span style="font-size: 8pt; font-family: Cambria, serif;"><o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt; text-align: justify;"><span style="font-size:8.0pt;font-family:&quot;Cambria&quot;,serif;
mso-bidi-font-family:&quot;Open Sans&quot;">zwana dalej<span class="apple-converted-space">&nbsp;</span><b>Cedentem</b>,</span><span style="font-size: 8pt; font-family: Cambria, serif;"><o:p></o:p></span></p>

<p style="margin-top:6.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">a<o:p></o:p></span></p>

<p style="margin-top:6.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">Markiem Dybowskim, zam. 41-800 Zabrze, ul. Franklina Roosevelta
6/8 legitymującym się dowodem osobistym wydanym przez Prezydent Miasta Zabrze
seria AWN nr 462571 PESEL 70053006155, NIP 648-151-53-75 REGON 240483515<o:p></o:p></span></p>

<p style="margin-top:6.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">Tomaszem Bachur, zam.41-800 Zabrze, ul. Wolności 231/4
legitymującym się dowodem osobisty wydanym przez Prezydent Miasta Zabrze seria
nr APD nr 593876 PESEL 81110715437,NIP 648-263-80-97, REGON 242608814,
prowadzącymi wspólnie działalność gospodarczą pod firmą <b>Martom Finanse S.C.
Marek Dybowski, Tomasz Bachur &nbsp;&nbsp;&nbsp;</b>z
siedzibą przy ul. Goethego 28/4 41-800 Zabrze<b><o:p></o:p></b></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;;mso-bidi-font-weight:bold">NIP:
648-276-35-72, REGON: 242774783<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;;mso-bidi-font-weight:bold">reprezentowanymi
przez:<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;;mso-bidi-font-weight:bold">Marka
Dybowskiego – Wspólnika<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;;mso-bidi-font-weight:bold"><o:p>&nbsp;</o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">zwanymi dalej<span class="apple-converted-space">&nbsp;</span><b>Cesjonariuszem</b>.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;1</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">1. Cedent oświadcza, że
względem '.$query[1].' zam. przy <span class="a1">ul. '.$query[4].'</span>, <span class="a2">'.$query[2].' '.$query[3].'</span>, PESEL '.$query[8].', przysługuje mu wierzytelność wekslowa w kwocie
<span class="zmienna" contenteditable="true">2.100,00 zł (słownie: dwa tysiące sto złotych 00/100)</span>.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">2. Istnienie wyżej
wymienionej wierzytelności stwierdzone zostało wekslem własnym wystawionym nie
na zlecenie przez Dłużnika w<span class="zmienna" contenteditable="true"> ___ </span>w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>,
płatnym za okazaniem lecz nie wcześniej niż dnia <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span><o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;2</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">Cedent oświadcza, że:<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">1) określona w § 1 wierzytelność istnieje, jest nieprzedawniona i
wolna od obciążeń oraz wad prawnych, a żaden przepis prawa, ani umowa nie
wyłączają możliwości zbycia wierzytelności;<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">2) w dniu zawarcia umowy cesji wierzytelności nie posiada względem
Dłużnika żadnych zobowiązań, które mogłyby być przedmiotem wzajemnych potrąceń;<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">3) nie dokonał z dłużnikiem zapisu na sąd polubowny;<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">4) wierzytelność nie jest przedmiotem postępowania sądowego ani
egzekucji komorniczej, jak również umowy Cedenta z firmą windykacyjną oraz nie
jest objęta postępowaniem upadłościowym ani likwidacyjnym.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;3</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">1. Cedent przelewa na rzecz
Cesjonariusza wierzytelność. Przeniesienie wierzytelności następuje z chwilą
przekazania Cesjonariuszowi weksla.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">2. Na Cesjonariusza
przechodzą wszelkie prawa związane z wierzytelnością.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">3. Za przeniesienie
wierzytelności Cesjonariusz zapłaci Cedentowi kwotę<span class="zmienna" contenteditable="true"> 625 zł (słownie: sześćset dwadzieścia pięć złotych)</span>. Kwota przekazana Cedentowi wyczerpuje w całości
roszczenia Cedenta wynikające z niniejszej umowy.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">4. Cedent zobowiązany jest do
poinformowania dłużnika o przelewie wierzytelności w terminie 7 dni od
dokonania przelewu wierzytelności. Zawiadomienie powinno zawierać imię,
nazwisko i adres Cesjonariusza oraz wskazanie rachunku bankowego Cesjonariusza,
na który dłużnik dokonać ma wpłaty.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">5. </span><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-fareast-font-family:
Calibri;mso-bidi-font-family:&quot;Bookman Old Style&quot;">W przypadku zapłaty przez
Dłużnika </span><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">w</span><span style="font-size:8.0pt;
line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-fareast-font-family:Calibri;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">ierzytelności na rzecz Cedenta
zamiast na&nbsp;rzecz Cesjonariusza, Cedent zobowiązuje się do niezwłocznego
przelania otrzymanej kwoty na&nbsp;rachunek </span><span style="font-size:8.0pt;
line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;">bankowy
Cesjonariusza o numerze :<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Bookman Old Style&quot;"><span>BZ WBK O/Tychy</span> <span>70 1090 1652 0000 0001 1980 4266</span><o:p></o:p></span></b></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">6. Cedent zobowiązany jest do
przedstawienia Cesjonariuszowi dowodu poinformowania dłużnika o dokonaniu
przelewu w sposób określony w ust. 4.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;4</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">Cedent nie ponosi
odpowiedzialności za wypłacalność dłużnika.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;5<o:p></o:p></span></b></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">1. Wszelkie zmiany i
uzupełnienia niniejszej umowy wymagają formy pisemnej pod rygorem nieważności.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">2. W kwestiach
nieuregulowanych postanowieniami niniejszej umowy, zastosowanie znajdują
przepisy kodeksu cywilnego, kodeksu postępowania cywilnego, Prawa wekslowego
oraz inne obowiązujące przepisy prawa.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">3. Sądem właściwym dla
rozstrzygania sporów z niniejszej umowy będzie właściwy dla siedziby Cedenta.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">4. Umowa została sporządzona
w dwóch jednobrzmiących egzemplarzach, po jednym dla każdej ze stron.<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify;tab-stops:center 70.9pt 13.0cm"><span style="font-size:8.0pt;
line-height:115%;font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ………………………………&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ………………………………<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify;tab-stops:center 70.9pt 13.0cm"><b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cedent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cesjonariusz<o:p></o:p></span></b></p>

</div>



<div class="print-content4" style="display: none;">
<p class="text-center" align="center" style="margin:0cm;margin-bottom:.0001pt;
text-align:center;line-height:115%;background:white"><b><span style="font-size:
8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">UMOWA</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p class="text-center" align="center" style="margin:0cm;margin-bottom:.0001pt;
text-align:center;line-height:115%;background:white"><b><span style="font-size:
8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">cesji
wierzytelności wekslowej<o:p></o:p></span></b></p>

<p class="text-center" align="center" style="margin:0cm;margin-bottom:.0001pt;
text-align:center;line-height:115%;background:white"><span style="font-size:
8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;"><o:p>&nbsp;</o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">Zawarta w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span> pomiędzy:<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt;"><b><span style="font-size: 8pt; font-family: Cambria, serif;">Tomasz Finanse Sp. z o.o. </span></b><span style="font-size: 8pt; font-family: Cambria, serif;">z siedzibą w Zabrzu, ul. Wolności 231/4, 41-800
Zabrze, , wpisaną do Krajowego Rejestru Przedsiębiorców prowadzonego przez Sąd
Rejonowy w Gliwicach X Wydział Gospodarczy KRS, pod numerem<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt;"><span style="font-size: 8pt; font-family: Cambria, serif;">KRS 0000607423, NIP 648-277-73-09, REGON 363986149,
kapitał zakładowy 200.000,00 zł,<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt;"><span style="font-size: 8pt; font-family: Cambria, serif;">reprezentowana przez:<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt;"><span style="font-size: 8pt; font-family: Cambria, serif;">Teresę Janoszek – Pełnomocnika powołanego uchwałą
zgromadzenia wspólników z dnia 10 czerwca 2016 zgodnie z art. 210 § 1 k.s.h.<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt;"><span style="font-size: 8pt; font-family: Cambria, serif;"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="margin-bottom: 0.0001pt;"><span style="font-size:8.0pt;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">zwana dalej<span class="apple-converted-space">&nbsp;</span><b>Cedentem</b>,</span><span style="font-size: 8pt; font-family: Cambria, serif;"><o:p></o:p></span></p>

<p style="margin-top:6.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;
margin-bottom:.0001pt;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">a<o:p></o:p></span></p>

<p style="margin-top:6.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">Markiem Dybowskim, zam. 41-800 Zabrze, ul. Franklina Roosevelta
6/8 legitymującym się dowodem osobistym wydanym przez Prezydent Miasta Zabrze
seria AWN nr 462571 PESEL 70053006155, NIP 648-151-53-75 REGON 240483515<o:p></o:p></span></p>

<p style="margin-top:6.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">Tomaszem Bachur, zam.41-800 Zabrze, ul. Wolności 231/4
legitymującym się dowodem osobisty wydanym przez Prezydent Miasta Zabrze seria
nr APD nr 593876 PESEL 81110715437,NIP 648-263-80-97, REGON 242608814,
prowadzącymi wspólnie działalność gospodarczą pod firmą <b>Martom Finanse S.C.
Marek Dybowski, Tomasz Bachur&nbsp; </b>z siedzibą przy ul. Goethego 28/4 41-800
Zabrze<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;;mso-bidi-font-weight:bold">NIP:
648-276-35-72, REGON: 242774783<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;;mso-bidi-font-weight:bold">reprezentowanymi
przez:<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;;mso-bidi-font-weight:bold">Marka
Dybowskiego – Wspólnika<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;;mso-bidi-font-weight:bold"><o:p>&nbsp;</o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">zwanym dalej<span class="apple-converted-space">&nbsp;</span><b>Cesjonariuszem</b>.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;1</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">1. Cedent oświadcza, że
względem Dłużnika '.$query[1].', zam. przy <span class="a1">ul. '.$query[4].'</span>, <span class="a2">'.$query[2].' '.$query[3].'</span>, PESEL
'.$query[8].', przysługuje mu wierzytelność wekslowa w kwocie <span class="zmienna" contenteditable="true">2.100,00 zł
(słownie: dwa tysiące sto złotych 00/100)</span>.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">2. Istnienie wyżej
wymienionej wierzytelności stwierdzone zostało wekslem własnym wystawionym nie
na zlecenie przez Dłużnika w<span class="zmienna" contenteditable="true"> ___ </span>w
dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>, płatnym za okazaniem lecz nie wcześniej niż dnia <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span><o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;2</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">Cedent oświadcza, że:<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">1) określona w § 1 wierzytelność istnieje, jest nieprzedawniona i
wolna od obciążeń oraz wad prawnych, a żaden przepis prawa, ani umowa nie
wyłączają możliwości zbycia wierzytelności;<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">2) w dniu zawarcia umowy cesji wierzytelności nie posiada względem
Dłużnika żadnych zobowiązań, które mogłyby być przedmiotem wzajemnych potrąceń;<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">3) nie dokonał z dłużnikiem zapisu na sąd polubowny;<o:p></o:p></span></p>

<p style="margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:21.3pt;
margin-bottom:.0001pt;text-align:justify;line-height:115%;background:white"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;">4) wierzytelność nie jest przedmiotem postępowania sądowego ani
egzekucji komorniczej, jak również umowy Cedenta z firmą windykacyjną oraz nie
jest objęta postępowaniem upadłościowym ani likwidacyjnym.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;3</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">1. Cedent przelewa na rzecz
Cesjonariusza wierzytelność. Przeniesienie wierzytelności następuje z chwilą
przekazania Cesjonariuszowi weksla.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">2. Na Cesjonariusza
przechodzą wszelkie prawa związane z wierzytelnością.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">3. Za przeniesienie
wierzytelności Cesjonariusz zapłaci Cedentowi kwotę<span class="zmienna" contenteditable="true"> 625 zł (słownie: sześćset dwadzieścia pięć złotych)</span>. Kwota przekazana Cedentowi wyczerpuje w całości
roszczenia Cedenta wynikające z niniejszej umowy.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">4. Cedent zobowiązany jest do
poinformowania dłużnika o przelewie wierzytelności w terminie 7 dni od
dokonania przelewu wierzytelności. Zawiadomienie powinno zawierać imię,
nazwisko i adres Cesjonariusza oraz wskazanie rachunku bankowego Cesjonariusza,
na który dłużnik dokonać ma wpłaty.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">5. </span><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-fareast-font-family:
Calibri;mso-bidi-font-family:&quot;Bookman Old Style&quot;">W przypadku zapłaty przez
Dłużnika </span><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">w</span><span style="font-size:8.0pt;
line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-fareast-font-family:Calibri;
mso-bidi-font-family:&quot;Bookman Old Style&quot;">ierzytelności na rzecz Cedenta
zamiast na&nbsp;rzecz Cesjonariusza, Cedent zobowiązuje się do niezwłocznego
przelania otrzymanej kwoty na&nbsp;rachunek </span><span style="font-size:8.0pt;
line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Bookman Old Style&quot;">bankowy
Cesjonariusza o numerze :<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Bookman Old Style&quot;"><span>BZ WBK O/Tychy</span> <span>70 1090 1652 0000 0001 1980 4266</span><o:p></o:p></span></b></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">6. Cedent zobowiązany jest do
przedstawienia Cesjonariuszowi dowodu poinformowania dłużnika o dokonaniu
przelewu w sposób określony w ust. 4.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;4</span></b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:
&quot;Open Sans&quot;"><o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">Cedent nie ponosi
odpowiedzialności za wypłacalność dłużnika.<o:p></o:p></span></p>

<p class="text-center" align="center" style="margin-top:6.0pt;margin-right:0cm;
margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
line-height:115%;background:white"><b><span style="font-size:8.0pt;line-height:
115%;font-family:&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">§&nbsp;5<o:p></o:p></span></b></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">1. Wszelkie zmiany i
uzupełnienia niniejszej umowy wymagają formy pisemnej pod rygorem nieważności.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">2. W kwestiach
nieuregulowanych postanowieniami niniejszej umowy, zastosowanie znajdują
przepisy kodeksu cywilnego, kodeksu postępowania cywilnego, Prawa wekslowego
oraz inne obowiązujące przepisy prawa.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">3. Sądem właściwym dla rozstrzygania
sporów z niniejszej umowy będzie właściwy dla siedziby Cedenta.<o:p></o:p></span></p>

<p style="margin:0cm;margin-bottom:.0001pt;text-align:justify;line-height:115%;
background:white"><span style="font-size:8.0pt;line-height:115%;font-family:
&quot;Cambria&quot;,serif;mso-bidi-font-family:&quot;Open Sans&quot;">4. Umowa została sporządzona
w dwóch jednobrzmiących egzemplarzach, po jednym dla każdej ze stron.<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify"><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify;tab-stops:center 70.9pt 13.0cm"><span style="font-size:8.0pt;
line-height:115%;font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ………………………………&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ………………………………<o:p></o:p></span></p>

<p class="MsoNormal" style="margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify;tab-stops:center 70.9pt 13.0cm"><b><span style="font-size:8.0pt;line-height:115%;font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cedent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cesjonariusz<o:p></o:p></span></b></p>

</div>

<div class="print-content5" style="display: none;">

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif"><span style="float: left;">P-Finanse Sp. z o.o.</span><span style="float: right;">Zabrze, dnia <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span></span><o:p></o:p></span></p>

<br />

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">ul. Lipowa 14<o:p></o:p></span>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">44-102 Gliwice<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">KRS: 0000612172<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">NIP: 631-266-21-80<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">REGON: 364179238<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$zwrot[0].'<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$query[1].'<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="a1">ul. '.$query[4].'</span><o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;<span class="a2">'.$query[2].' '.$query[3].'</span><o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:12.0pt;line-height:107%;font-family:
&quot;Cambria&quot;,serif"><br>
<!--[if !supportLineBreakNewLine]--><br>
<!--[endif]--><o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:12.0pt;line-height:107%;font-family:
&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:12.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif">Zawiadomienie
<o:p></o:p></span></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:12.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif">o cesji
wierzytelności wekslowej<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Niniejszym informujemy, iż w
dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").'</span> roku została zawarta pomiędzy 
<b><nobr>P-Finanse&nbsp;Sp.&nbsp;z&nbsp;o.o.</nobr> </b>z siedzibą w
Gliwicach, ul. Lipowa 14, 44-102 Gliwice (Cedent) a&nbsp;Tomaszem Bachur
oraz Markiem Dybowskim prowadzącymi działalność gospodarczą pod firmą <b><nobr>Martom Finanse S.C.</nobr></b> Tomasz Bachur,
Marek Dybowski z siedzibą w Zabrzu przy ul. Goethego 28/4 (Cesjonariusz), umowa
przelewu wierzytelności wekslowej w kwocie&nbsp;
<span class="zmienna" contenteditable="true">2.100,00 zł (słownie: dwa tysiące sto złotych 00/100)</span> przysługującej
P-Finanse Sp. z o.o. wobec '.$zwrot[2].' z tytułu – weksla własnego wystawionego przez
'.$zwrot[3].' nie na zlecenie w<span class="zmienna" contenteditable="true"> ___ </span>w dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span> płatnego za okazaniem, lecz
nie wcześniej niż dnia <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>, na mocy, której <b>Cesjonariusz</b> nabył przedmiotową wierzytelność w całości tj. w
kwocie <span class="zmienna" contenteditable="true">2.100,00 zł</span> wraz &nbsp;z wszelkimi odsetkami
i innymi kosztami.<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;text-indent:35.4pt"><span style="font-family:&quot;Cambria&quot;,serif">Wobec powyższego informujemy '.$zwrot[3].', że z
chwilą otrzymania niniejszego zawiadomienia, zapłata wierzytelności winna
zostać dokonana na rachunek bankowy<b>
Cesjonariusza</b> o numerze:<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><b><span style="font-size:12.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif"><span>BZ WBK O/Tychy</span> <span>70 1090 1652 0000 0001 1980 4266</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="text-align:justify"><b><span style="font-size:14.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
…………………………………………..&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cedent&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<o:p></o:p></span></p>
</div>

<div class="print-content6" style="display: none;">

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif"><span style="float: left;">Tomasz Finanse Sp. z o.o.</span><span style="float: right;">Zabrze, dnia <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span></span><o:p></o:p></span></p>

<br />

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">ul. Wolności 231/4<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">41-800 Zabrze<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">KRS: 0000607423<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">NIP: 648-277-73-09<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">REGON: 363986149<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$zwrot[0].'<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$query[1].'<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="a1">ul. '.$query[4].'</span><o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="a2">'.$query[2].' '.$query[3].'</span><o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><span style="font-size:12.0pt;line-height:107%;font-family:
&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:12.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif">Zawiadomienie
<o:p></o:p></span></p>

<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:12.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif">o cesji
wierzytelności wekslowej<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Niniejszym informujemy, iż w
dniu <span class="zmienna" contenteditable="true">'.date("d.m.Y").'</span> roku została zawarta pomiędzy 
<b><nobr>Tomasz Finanse Sp. z o.o.</nobr> </b>z siedzibą w Zabrzu, ul. Wolności 231/4,
41-800 Zabrze (Cedent) a&nbsp;Tomaszem Bachur oraz Markiem Dybowskim prowadzącymi
działalność gospodarczą pod firmą <b><nobr>Martom
Finanse S.C.</nobr></b> Tomasz Bachur, Marek Dybowski z siedzibą w Zabrzu przy ul.
Goethego 28/4 (Cesjonariusz), umowa przelewu wierzytelności wekslowej w
kwocie&nbsp; <span class="zmienna" contenteditable="true">2.100,00 zł (słownie: dwa tysiące
sto złotych 00/100)</span> przysługującej Tomasz Finanse Sp. z o.o. wobec '.$zwrot[2].' z
tytułu – weksla własnego wystawionego przez '.$zwrot[3].' nie na zlecenie w<span class="zmienna" contenteditable="true"> ___ </span>w dniu
<span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span> płatnego za okazaniem, lecz nie wcześniej niż dnia <span class="zmienna" contenteditable="true">'.date("d.m.Y").' r.</span>,
na mocy, której <b>Cesjonariusz</b> nabył
przedmiotową wierzytelność w całości tj. w kwocie <span class="zmienna" contenteditable="true">2.100,00 zł</span> wraz z wszelkimi
odsetkami i innymi kosztami.<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><span style="font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal" style="text-align:justify;text-indent:35.4pt"><span style="font-family:&quot;Cambria&quot;,serif">Wobec powyższego informujemy '.$zwrot[3].', że z
chwilą otrzymania niniejszego zawiadomienia, zapłata wierzytelności winna
zostać dokonana na rachunek bankowy<b>
Cesjonariusza</b> o numerze:<o:p></o:p></span></p>

<p class="MsoNormal" style="text-align:justify"><b><span style="font-size:12.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif"><span>BZ WBK O/Tychy</span> <span>70 1090 1652 0000 0001 1980 4266</span><o:p></o:p></span></b></p>

<p class="MsoNormal" style="text-align:justify"><b><span style="font-size:12.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal" style="text-align:justify"><b><span style="font-size:14.0pt;line-height:107%;font-family:&quot;Cambria&quot;,serif"><o:p>&nbsp;</o:p></span></b></p>

<p class="MsoNormal"><span style="font-family:&quot;Cambria&quot;,serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; …………………………………………..&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cedent&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<o:p></o:p></span></p>
</div>

</div>

<div class="row">
<div class="col-md-8 col-sm-8 col-xs-8">
<select class="form-control selectpicker" id="zmiana_adresu" onchange="zmiana_adresu('.$query[0].', \''.$query[2].'\', \''.$query[3].'\', \''.$query[4].'\', \''.$query[5].'\', \''.$query[6].'\', \''.$query[7].'\')">
<option value="adr1">'.$query[2].' '.$query[3].', '.$query[4].'</option>
<option value="adr2">'.$query[5].' '.$query[6].', '.$query[7].'</option>
</select>
</div>
<div class="col-md-4 col-sm-4 col-xs-4" style="display: none;">
<select class="form-control" id="zmiana_banku" onchange="zmiana_banku('.$query[0].')">
<option value="bank1">BZ WBK O/Zabrze 34 1090 2590 0000 0001 3246 8987</option>
<option value="bank2">BZ WBK O/Zabrze 15 1090 2590 0000 0001 3231 0734</option>
<option value="bank3">BZ WBK O/Tychy 70 1090 1652 0000 0001 1980 4266</option>
</select>
</div>
<div class="col-md-4 col-sm-4 col-xs-4">
<a class="btn btn-success btn-block" style="border-radius: 0px;" onclick="drukuj('.$query[0].');">DRUKUJ</a>
</div>
</div>
';

$sms = '
<div class="row">
    <div class="col-md-12">
        <p class="text-center"><b>Odbiorca:</b> '.$query[1].'</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <textarea id="wiadomosc" class="form-control" style="border: none; background: #ededed; height: 400px; resize: none; padding: 25px 50px; text-align: justify;"></textarea>
        </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-8">
        <select class="form-control selectpicker" id="zmiana_numeru">
            <option value="'.$query[12].'">'.$query[12].'</option>
            <option value="'.$query[13].'">'.$query[13].'</option>
        </select>
    </div>
    <div class="col-md-4">
        <a id="sms_submit" class="btn btn-default btn-block" style="border-radius: 0px;" onclick="wyslij_sms('.$query[0].');">WYŚLIJ</a>
    </div>
</div>
';

$results = array(
    'id' => $query[0],
    'nazwisko' => $query[1],
    'kod_pocztowy' => $query[2],
    'miejscowosc' => $query[3],
    'adres' => $query[4],
    'kod_pocztowy2' => $query[5],
    'miejscowosc2' => $query[6],
    'adres2' => $query[7],
    'pesel' => $query[8],
    'nr_dowodu' => $query[9],
    'data_wydania_dowodu' => $query[10],
    'organ_wydajacy_dowod' => $query[11],
    'telefon' => $query[12],
    'telefon2' => $query[13],
    'kwota_netto' => $query[14],
    'kwota_prowizja' => $query[15],
    'kwota_brutto' => $query[16],
    'termin_zawarcia' => $query[17],
    'termin_platnosci' => $query[18],
    'nr_umowy' => $query[19],
    'informacje' => $query[20],
    'agent' => display_agent($query[21]),
    'agent_id' => $query[21],
    'spolka' => display_spolka($query[22]),
    'spolka_id' => $query[22],
    'pracownik' => $query[23],
    'flaga' => display_flag($query[24]),
    'flaga_id' => $query[24],
    'plec' => $query[25],
    'lease' => $query[26],
    'lease_time' => $query[27],
    'spoznienie' => display_late($query[24], $query[18]),
    'select_agent' => $select_agent,
    'select_flaga' => $select_flaga,
    'select_spolka' => $select_spolka,
    'flaga_kolor' => display_flag_color($query[24]),
    'flaga_nazwa' => display_flag_name($query[24]),
    'wpisy' => $wpisy,
    'windykacja' => $windykacja,
    'drukowanie' => $drukowanie,
    'sms' => $sms
);

$pdo = null;
return json_encode($results, JSON_HEX_QUOT | JSON_HEX_TAG);
?>