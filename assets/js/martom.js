// HELPERS

var windows = new Array();

var previous;

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

function format_commas(num){
    if(num != null){
    var n = num.toString(), p = n.indexOf('.');
    return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
        return p<0 || i<p ? ($0+' ') : $0;
    });
    } return 0;
}

function format_date(date) {
  var day = ('0' + date.getDate()).slice(-2);
  var month = ('0' + (date.getMonth() + 1)).slice(-2);
  var year = date.getFullYear();

  return year + '-' + month + '-' + day;
}

function date_time(now) {
  year = "" + now.getFullYear();
  month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
  day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
  hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
  minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
  second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
  return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
}

function search_type(n){
    switch(n){
        case 1:
            $('#search_type li:nth-child(1)').addClass('active');
            $('#search_type li:nth-child(2)').removeClass('active');
            $('#search_type li:nth-child(3)').removeClass('active');
            break;
        case 2:
            $('#search_type li:nth-child(2)').addClass('active');
            $('#search_type li:nth-child(1)').removeClass('active');
            $('#search_type li:nth-child(3)').removeClass('active');
            break;
        case 3:
            $('#search_type li:nth-child(3)').addClass('active');
            $('#search_type li:nth-child(1)').removeClass('active');
            $('#search_type li:nth-child(2)').removeClass('active');
            break;
    }
}

function search(){
    var query = $('#search').val();
    var search_option = $('#search_type .active').val();
    if(query != ''){
    if(search_option == null) search_option = 1;
    var queryString = {
        'query': query,
        'search_option': search_option
    };

    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/search.php',
        data: queryString,
        success: function (result) {
            
            //PARSE DATA
            var data = jQuery.parseJSON(result);
            
            $('#search_result').html('<div style="width: 100%; float: left;">'+data+'</div style="width: 100%;"><button id="search-close" onclick="$(\'#search_result\').hide(100);" class="btn"><i class="fa fa-caret-left"></i></button>');
            
            $('#search_result .dataTable').DataTable({
                //"stateSave": true,
                //"bSort": false,
                aaSorting: [],
                "bFilter": false,
                "bLengthChange": false,
                "lengthMenu": [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Wszystkie"]],
                "language": {
                    "sProcessing":   "Przetwarzanie...",
                    "sLengthMenu":   "Pokaż _MENU_ pozycji",
                    "sZeroRecords":  "Nie znaleziono pasujących pozycji",
                    "sInfoThousands":  " ",
                    "sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
                    "sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
                    "sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Szukaj:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Pierwsza",
                        "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span>",
                        "sNext":     "<span class='glyphicon glyphicon-chevron-right'></span>",
                        "sLast":     "Ostatnia"
                    },
                    "sEmptyTable":     "Brak danych",
                    "sLoadingRecords": "Wczytywanie...",
                    "oAria": {
                        "sSortAscending":  ": aktywuj, by posortować kolumnę rosnąco",
                        "sSortDescending": ": aktywuj, by posortować kolumnę malejąco"
                    }
                }
            });
            $('#search_result').show(100);
            
        },
        error: function() {search();}
    });
    }
}

function termin_zawarcia(id){
    var data = new Date($('#'+id+' input[name=termin_zawarcia]').val());
    var data2 = new Date();
    var roznica = 30 * 1000 * 3600 * 24;
    data2.setTime(data.getTime()+roznica);
    var termin = format_date(data2);
        if(termin == 0 || termin == 'NaN-aN-aN') termin = '';
    $('#'+id+' input[name=roznica]').val(30);
    $('#'+id+' input[name=termin_platnosci]').val(termin);
}

function termin_roznica(id){
    var data = new Date($('#'+id+' input[name=termin_zawarcia]').val());
    var data2 = new Date();
    var roznica = $('#'+id+' input[name=roznica]').val() * 1000 * 3600 * 24;
    data2.setTime(data.getTime()+roznica);
    var termin = format_date(data2);
        if(termin == 0 || termin == 'NaN-aN-aN') termin = '';
    $('#'+id+' input[name=termin_platnosci]').val(termin);
}

function termin_platnosci(id){
    var data = new Date($('#'+id+' input[name=termin_zawarcia]').val());
    var data2 = new Date($('#'+id+' input[name=termin_platnosci]').val());
    var roznica = roznica_dat(data, data2);
        if(roznica == 0 || roznica == 'NaN') roznica = '';
     $('#'+id+' input[name=roznica]').val(roznica);
}

function roznica_dat(date1, date2){
    var date1 = new Date(date1);
    var date2 = new Date(date2);
    var timeDiff = date2.getTime() - date1.getTime();
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    return diffDays;
}

function kwota_netto(id){
    var netto = Number($('#'+id+' input[name=kwota_netto]').val());
    var prowizja = netto*0.25;
        if(prowizja == 0 || isNaN(prowizja)) prowizja = '';
    var brutto = netto+prowizja;
        if(brutto == 0 || isNaN(brutto)) brutto = '';
    $('#'+id+' input[name=kwota_prowizja]').val(prowizja);
    $('#'+id+' input[name=kwota_brutto]').val(brutto);
}

function kwota_prowizja(id){
    var netto = Number($('#'+id+' input[name=kwota_netto]').val());
    var prowizja = Number($('#'+id+' input[name=kwota_prowizja]').val());
    var brutto = netto + prowizja;
        if(brutto == 0 || isNaN(brutto)) brutto = '';
    $('#'+id+' input[name=kwota_brutto]').val(brutto);
}

function kwota_brutto(id){
    var netto = Number($('#'+id+' input[name=kwota_netto]').val());
    var brutto = Number($('#'+id+' input[name=kwota_brutto]').val());
    var prowizja = brutto - netto;
        if(prowizja == 0 || isNaN(prowizja)) prowizja = '';
    $('#'+id+' input[name=kwota_prowizja]').val(prowizja);
}

function draggable_refresh(){
    $(".draggable").draggable({
        handle: ".box-header",
        drag: function(event, ui) {
            if( ui.position.left < 0){ ui.position.left=0;}
            if( ui.position.top< 0){ ui.position.top=0;}
            var maxRight = $(window).width() - $(this).width();
            if(ui.position.left > maxRight) {
            ui.position.left = maxRight;
            }
        }
    });
    $(".draggable").resizable({handles: 'e'});
}

function modal_index(id){
        $(".draggable").css('zIndex', 2000);
        $(".draggable").css('box-shadow', 'none');
        $(".draggable").removeClass("box-warning");
        $("#"+id).css('zIndex', 2001);
        $("#"+id).css('box-shadow', '0px 0px 15px silver');
        $("#"+id).addClass("box-warning");
        $(".draggable").css('height', 'auto');
        
    if(previous != id) {
        for(var i = 0; i < windows.length; i++) {
            if(typeof windows[i] != 'undefined'){
                windows[i].abort();
            }
        }
        updateWindow(id);
        previous = id;
    }

}

function minimize(e){
    if(e.className == "btn btn-box-tool maximized") {
        var parent1 = e.parentNode;
        var parent2 = parent1.parentNode;
        var parent3 = parent2.parentNode;
        parent3.style.width = "360px";
        $(parent3).find(".addition").hide();
        e.className = "btn btn-box-tool minimized";
    } else {
        var parent1 = e.parentNode;
        var parent2 = parent1.parentNode;
        var parent3 = parent2.parentNode;
        parent3.style.width = "90%";
        $(parent3).find(".addition").show();
        e.className = "btn btn-box-tool maximized";
    }
}

function create_task(data){
    task = jQuery.parseHTML(
        '<li id="'+data.id+'_task" onclick="createWindow(\''+data.id+'\');" style="cursor: pointer;" class="unselectable">' +
            '<a>' +
                '<i class="menu-icon fa fa-times bg-orange" onclick="event.stopPropagation();remove_task('+data.id+');windows['+data.id+'].abort();"></i>' +
                '<div class="menu-info">' +
                    '<h4 class="control-sidebar-subheading">'+data.nazwisko+'</h4>' +
                    '<p contenteditable="true" onclick="event.stopPropagation();" onkeydown="localStorage.tasks = $(\'#tasks\').html();" onkeyup="localStorage.tasks = $(\'#tasks\').html();" style="border: none;">...</p>' +
                '</div>' +
            '</a>' +
        '</li>'
    );
    $("#tasks").append(task);
    localStorage.tasks = $("#tasks").html();
}

function update_task(data){
    $('#'+data.id+'_task .control-sidebar-subheading').html(data.nazwisko);
    localStorage.tasks = $("#tasks").html();
}

function remove_task(id){
    $('#'+id+'_task').remove();
    $('#'+id).remove();
    localStorage.tasks = $("#tasks").html();
}

function delete_customer(id){
    if(confirm('Czy na pewno chcesz usunąć klienta?')){
    var queryString = {
        'id': id
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/deleteCustomer.php',
        data: queryString,
        success: function (result) {
            $('#'+id+'_task').remove();
            $('#'+id).remove();
            localStorage.tasks = $("#tasks").html();
        }
    });
    }
}

function deleteWpis(id){
    if(confirm('Czy na pewno chcesz usunąć wpis?')){
    var queryString = {
        'id': id
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/deleteWpis.php',
        data: queryString,
        success: function (result) {
        }
    });
    }
}

function deleteWindykacja(id){
    if(confirm('Czy na pewno chcesz usunąć wpis windykacyjny?')){
    var queryString = {
        'id': id
    }
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/deleteWindykacja.php',
        data: queryString,
        success: function (result) {
        }
    });
    }
}

function zmiana_dokumentu(id, n){
    $('#'+id+' .print-content1').hide();
    $('#'+id+' .print-content2').hide();
    $('#'+id+' .print-content3').hide();
    $('#'+id+' .print-content4').hide();
    $('#'+id+' .print-content5').hide();
    $('#'+id+' .print-content6').hide();
    $('#'+id+' .print-content'+n).show();
}

function zmiana_adresu(id, kod_pocztowy, miejscowosc, adres, kod_pocztowy2, miejscowosc2, adres2){
    if($('#'+id+' #zmiana_adresu option:selected').val() == "adr1") {
        $('#'+id+' .a1').html('ul. '+adres);
        $('#'+id+' .a2').html(kod_pocztowy+' '+miejscowosc);
    } else{
        $('#'+id+' .a1').html('ul. '+adres2);
        $('#'+id+' .a2').html(kod_pocztowy2+' '+miejscowosc2);
    }
}

function zmiana_banku(id){
    if($('#'+id+' #zmiana_banku option:selected').val() == "bank1") {
        $('#'+id+' .b1').html('BZ WBK O/Zabrze');
        $('#'+id+' .b2').html('34 1090 2590 0000 0001 3246 8987');
    }
    if($('#'+id+' #zmiana_banku option:selected').val() == "bank2") {
        $('#'+id+' .b1').html('BZ WBK O/Zabrze');
        $('#'+id+' .b2').html('15 1090 2590 0000 0001 3231 0734');
    }
    if($('#'+id+' #zmiana_banku option:selected').val() == "bank3") {
        $('#'+id+' .b1').html('BZ WBK O/Tychy');
        $('#'+id+' .b2').html('70 1090 1652 0000 0001 1980 4266');
    }
}

function drukuj(id){
    var w = window.open();
    var html = $('#'+id+' #druk').html();
    $(w.document.body).html(html);
    w.print();
}

function new_customer() {
if($('#nowy').length == 0){
$.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/selects.php',
        success: function (result) {
            var data = jQuery.parseJSON(result);
            new_customer_modal(data);
        },
        //error: function() {new_customer();}
    });
}
}

function new_customer_modal(data){
    html = jQuery.parseHTML('<div class="box box-success draggable" id="nowy" style="position: absolute;z-index: 2005; width: 90%; max-width: 900px; min-width: 360px;" onmousedown="this.style.zIndex = \'2005\';this.style.height = \'auto\';" ontouchstart="this.style.zIndex = \'2005\';this.style.height = \'auto\';">' +
            '<div class="box-header with-border">' +
                '<h3 class="box-title text-uppercase" style="cursor: default;">Formularz dodania nowego klienta</h3>' +
                '<div class="box-tools pull-right">' +
                    '<a class="btn btn-box-tool bg-green" onclick="add_customer();">DODAJ</a> ' +
                    '<button class="btn btn-box-tool maximized" data-widget="collapse" onclick="minimize(this);"><i class="fa fa-minus"></i></button>' +
                    '<button class="btn btn-box-tool" onclick="$(\'#nowy\').remove();"><i class="fa fa-times"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="box-body">' +
            '<div class="col-md-12">' +
                '<div class="nav-tabs-custom">' +
                    '<ul class="nav nav-tabs" role="tablist" style="text-transform: uppercase;">' +
                        '<li role="presentation" class="active"><a href="#osobowe" aria-controls="home" role="tab" data-toggle="tab">Dane osobowe</a></li>' +
                        '<li role="presentation"><a href="#kredytowe" aria-controls="profile" role="tab" data-toggle="tab">Dane kredytowe</a></li>' +
                        '<li role="presentation"><a href="#informacje" aria-controls="settings" role="tab" data-toggle="tab">Informacje</a></li>' +
                    '</ul>' +
                '</div>' +
                     
                '<div class="tab-content">' +
                    '<div role="tabpanel" class="tab-pane active fade in" id="osobowe">' +
                        '<div class="box box-success">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-user"></span> Podstawowe informacje</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                            
                                '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Nazwisko</label>' +
                                        '<input type="text" class="form-control text-center nazwisko">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Pesel</label>' +
                                        '<input type="text" class="form-control text-center pesel">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Nr. dowodu osobistego</label>' +
                                        '<input type="text" class="form-control text-center nr_dowodu">' +
                                    '</div>' +
                                '</div>' +    
                            
                                '<div class="form-group text-center">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Data wydania dowodu osobistego</label>' +
                                        '<input type="text" class="form-control text-center data_wydania_dowodu">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-8">' +
                                        '<label class="text-uppercase" for="textinput">Organ wydający dowód</label>' +
                                        '<input type="text" class="form-control text-center organ_wydajacy_dowod">' +
                                    '</div>' +        
                                '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-info">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-home"></span> Dane kontaktowe</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                                
                                '<div class="form-group text-center">' +
                                '<h4 class="text-uppercase">Adres podstawowy</h4>' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kod pocztowy</label>' +
                                        '<input type="text" class="form-control text-center kod_pocztowy">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Miejscowość</label>' +
                                        '<input type="text" class="form-control text-center miejscowosc">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Adres</label>' +
                                        '<input type="text" class="form-control text-center adres">' +
                                    '</div>' +
                                '</div>' +
                                
                                '<br /><br /><br />' +
                                
                                '<div class="form-group text-center">' +
                                '<h4 class="text-uppercase">Adres Alternatywny</h4>' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kod pocztowy</label>' +
                                        '<input type="text" class="form-control text-center kod_pocztowy2">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Miejscowość</label>' +
                                        '<input type="text" class="form-control text-center miejscowosc2">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Adres</label>' +
                                        '<input type="text" class="form-control text-center adres2">' +
                                    '</div>' +
                                '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-danger">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-phone-square"></span> Kontakt telefoniczny</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                                
                            '<div class="form-group text-center">' +
                                '<h4 class="text-uppercase">Numery telefonów</h4>' +
                                    '<div class="col-md-6">' +
                                        '<label class="text-uppercase" for="textinput">Telefon podstawowy</label>' +
                                        '<input type="text" class="form-control text-center telefon">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-6">' +
                                        '<label class="text-uppercase" for="textinput">Telefon alternatywny</label>' +
                                        '<input type="text" class="form-control text-center telefon2">' +
                                    '</div>' +      
                            
                                '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                    '</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="kredytowe">' +
                     
                        '<div class="box box-success">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-money"></span> Informacje o kredycie</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                            
                                '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kwota netto</label>' +
                                        '<input type="text" class="form-control bg-green text-center kwota_netto" name="kwota_netto" onkeyup="kwota_netto(\'nowy\');">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kwota prowizji</label>' +
                                        '<input type="text" class="form-control bg-yellow text-center kwota_prowizja" name="kwota_prowizja" onkeyup="kwota_prowizja(\'nowy\');">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kwota brutto</label>' +
                                        '<input type="text" class="form-control bg-red text-center kwota_brutto" name="kwota_brutto" onkeyup="kwota_brutto(\'nowy\');">' +
                                    '</div>' +
                                '</div>' +    
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-info">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-calendar"></span> Informacje o terminach</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                            
                                '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Termin zawarcia</label>' +
                                        '<input type="text" class="form-control text-center termin_zawarcia" name="termin_zawarcia" onchange="termin_zawarcia(\'nowy\');">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Długość w dniach</label>' +
                                        '<input type="text" class="form-control bg-aqua text-center roznica_dat" name="roznica" onkeyup="termin_roznica(\'nowy\');">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Termin płatności</label>' +
                                        '<input type="text" class="form-control text-center termin_platnosci" name="termin_platnosci" onchange="termin_platnosci(\'nowy\');">' +
                                    '</div>' +
                                '</div>' +    
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-danger">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-info-circle"></span> Inne</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                                
                            '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Agent</label>' +
                                        data.select_agent +
                                '</div>' +
                                        
                                '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Flaga</label>' +
                                        data.select_flaga +
                                '</div>' +
                            
                                '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Spółka</label>' +
                                        data.select_spolka +
                                '</div>' +
                            '</div>' +
                            
                            '<div class="form-group text-center">' +
                                '<div class="col-md-6 col-md-offset-3">' +
                                        '<label class="text-uppercase" for="textinput">Numer umowy</label>' +
                                        '<input type="text" class="form-control text-center nr_umowy">' +
                                '</div>' +
                            '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                        
                    '</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="informacje">' +
                        '<textarea class="form-control informacje" style="border: none; background: #ededed; height: 400px; resize: vertical; padding: 25px 50px; text-align: justify;"></textarea>' +
                        '<br />' +
                    '</div>' +
                '</div>' +
                    
            '</div>' +
            '</div>' +
    '</div>'
    );
    $("body").append(html);
    $('#nowy').css('left', $(window).width()/2 - $('#nowy').width()/2);
    $('#nowy').css('top', 65);
    draggable_refresh();
    
    $('#nowy .agent').selectpicker();
        $('#nowy .agent').val();
        $('#nowy .agent').selectpicker('refresh');
    $('#nowy .flaga').selectpicker();
        $('#nowy .flaga').val();
        $('#nowy .flaga').selectpicker('refresh');
    $('#nowy .spolka').selectpicker();
        $('#nowy .spolka').val();
        $('#nowy .spolka').selectpicker('refresh');
    $.fn.datepicker.dates['pl'] = {
        days: ["niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota"],
        daysShort: ["niedz.", "pon.", "wt.", "śr.", "czw.", "piąt.", "sob."],
        daysMin: ["ndz.", "pn.", "wt.", "śr.", "czw.", "pt.", "sob."],
        months: ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"],
        monthsShort: ["sty.", "lut.", "mar.", "kwi.", "maj", "cze.", "lip.", "sie.", "wrz.", "paź.", "lis.", "gru."],
        today: "dzisiaj",
        weekStart: 1,
        clear: "wyczyść",
        format: "yyyy-mm-dd"
    };
    $('#nowy .data_wydania_dowodu').datepicker({
        language: 'pl'
    });
    $('#nowy .termin_zawarcia').datepicker({
        language: 'pl'
    });
    $('#nowy .termin_platnosci').datepicker({
        language: 'pl'
    });
    $('#nowy .informacje').wysihtml5({
        locale: "pl-PL",
        "font-styles": true,
        "emphasis": true,
        "lists": true,
        "html": false,
        "link": true,
        "image": true,
        "color": true
    });
}

function create_modal(data){
    html = jQuery.parseHTML('<div class="box box-warning draggable" id="'+data.id+'" style="position: absolute;z-index: 2000; width: 90%; max-width: 900px; min-width: 360px;" onmousedown="modal_index('+data.id+');" ontouchstart="modal_index('+data.id+');">' +
            '<div class="box-header with-border">' +
                '<h3 class="box-title" style="cursor: default;"><span class="badge" style="line-height: 2em; border-radius: 3px;">'+data.id+'</span> <span class="nazwisko">'+data.nazwisko+'</span><span class="addition spoznienie"> - Spóźnienie: '+data.spoznienie+'</span></h3>' +
                '<div class="box-tools pull-right">' +
                    '<button class="btn btn-box-tool" onclick="delete_customer('+data.id+');windows['+data.id+'].abort();"><i class="fa fa-trash-o"></i></button>' +
                    '<button class="btn btn-box-tool"><i class="fa fa-bookmark-o"></i></button> | ' +
                    '<button class="btn btn-box-tool maximized" data-widget="collapse" onclick="minimize(this);"><i class="fa fa-minus"></i></button>' +
                    '<button class="btn btn-box-tool" onclick="$(\'#'+data.id+'\').remove();windows['+data.id+'].abort();"><i class="fa fa-times"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="box-body">' +
            '<div class="col-md-12">' +
                '<div class="nav-tabs-custom">' +
                    '<ul class="nav nav-tabs" role="tablist" style="text-transform: uppercase;">' +
                        '<li role="presentation" class="active"><a href="#osobowe'+data.id+'" aria-controls="home" role="tab" data-toggle="tab">Dane osobowe</a></li>' +
                        '<li role="presentation"><a href="#kredytowe'+data.id+'" aria-controls="profile" role="tab" data-toggle="tab">Dane kredytowe</a>    </li>' +
                        '<li role="presentation"><a href="#informacje'+data.id+'" aria-controls="settings" role="tab" data-toggle="tab">Informacje</a></li>' +
                        '<li role="presentation"><a href="#operacje'+data.id+'" aria-controls="messages" role="tab" data-toggle="tab">Operacje</a></li>' +
                        '<li role="presentation"><a href="#windykacja'+data.id+'" aria-controls="settings" role="tab" data-toggle="tab">Windykacja</a></li>' +
                        '<li role="presentation"><a href="#drukowanie'+data.id+'" aria-controls="settings" role="tab" data-toggle="tab">Drukowanie</a></li>' +
                        '<li role="presentation"><a href="#sms'+data.id+'" aria-controls="settings" role="tab" data-toggle="tab">Sms</a></li>' +
                    '</ul>' +
                '</div>' +
                     
                '<div class="tab-content">' +
                    '<div role="tabpanel" class="tab-pane active fade in" id="osobowe'+data.id+'">' +
                        '<div class="box box-success">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-user"></span> Podstawowe informacje</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                            
                                '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Nazwisko</label>' +
                                        '<input type="text" class="form-control text-center nazwisko" onchange="save_customer('+data.id+');"; value="'+data.nazwisko+'">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Pesel</label>' +
                                        '<input type="text" class="form-control text-center pesel" onchange="save_customer('+data.id+');"; value="'+data.pesel+'">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Nr. dowodu osobistego</label>' +
                                        '<input type="text" class="form-control text-center nr_dowodu" onchange="save_customer('+data.id+');"; value="'+data.nr_dowodu+'">' +
                                    '</div>' +
                                '</div>' +    
                            
                                '<div class="form-group text-center">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Data wydania dowodu osobistego</label>' +
                                        '<input type="text" class="form-control text-center data_wydania_dowodu" onchange="save_customer('+data.id+');"; value="'+data.data_wydania_dowodu+'">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-8">' +
                                        '<label class="text-uppercase" for="textinput">Organ wydający dowód</label>' +
                                        '<input type="text" class="form-control text-center organ_wydajacy_dowod" onchange="save_customer('+data.id+');"; value="'+data.organ_wydajacy_dowod+'">' +
                                    '</div>' +        
                                '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-info">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-home"></span> Dane kontaktowe</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                                
                                '<div class="form-group text-center">' +
                                '<h4 class="text-uppercase">Adres podstawowy</h4>' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kod pocztowy</label>' +
                                        '<input type="text" class="form-control text-center kod_pocztowy" onchange="save_customer('+data.id+');"; value="'+data.kod_pocztowy+'">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Miejscowość</label>' +
                                        '<input type="text" class="form-control text-center miejscowosc" onchange="save_customer('+data.id+');"; value="'+data.miejscowosc+'">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Adres</label>' +
                                        '<input type="text" class="form-control text-center adres" onchange="save_customer('+data.id+');"; value="'+data.adres+'">' +
                                    '</div>' +
                                '</div>' +
                                
                                '<br /><br /><br />' +
                                
                                '<div class="form-group text-center">' +
                                '<h4 class="text-uppercase">Adres Alternatywny</h4>' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kod pocztowy</label>' +
                                        '<input type="text" class="form-control text-center kod_pocztowy2" onchange="save_customer('+data.id+');"; value="'+data.kod_pocztowy2+'">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Miejscowość</label>' +
                                        '<input type="text" class="form-control text-center miejscowosc2" onchange="save_customer('+data.id+');"; value="'+data.miejscowosc2+'">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Adres</label>' +
                                        '<input type="text" class="form-control text-center adres2" onchange="save_customer('+data.id+');"; value="'+data.adres2+'">' +
                                    '</div>' +
                                '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-danger">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-phone-square"></span> Kontakt telefoniczny</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                                
                            '<div class="form-group text-center">' +
                                '<h4 class="text-uppercase">Numery telefonów</h4>' +
                                    '<div class="col-md-6">' +
                                        '<label class="text-uppercase" for="textinput">Telefon podstawowy</label>' +
                                        '<input type="text" class="form-control text-center telefon" onchange="save_customer('+data.id+');"; value="'+data.telefon+'">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-6">' +
                                        '<label class="text-uppercase" for="textinput">Telefon alternatywny</label>' +
                                        '<input type="text" class="form-control text-center telefon2" onchange="save_customer('+data.id+');"; value="'+data.telefon2+'">' +
                                    '</div>' +      
                            
                                '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                        
                        '<div class="form-group text-center">' +
                            '<div class="col-md-12 pracownik">' +
                                data.pracownik +
                            '</div>' +        
                        '</div>' +
                            
                    '</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="kredytowe'+data.id+'">' +
                     
                        '<div class="box box-success">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-money"></span> Informacje o kredycie</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                            
                                '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kwota netto</label>' +
                                        '<input type="text" class="form-control bg-green text-center kwota_netto" name="kwota_netto" onkeyup="kwota_netto('+data.id+');" onchange="save_customer('+data.id+');" value="'+data.kwota_netto+'">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kwota prowizji</label>' +
                                        '<input type="text" class="form-control bg-yellow text-center kwota_prowizja" name="kwota_prowizja" onkeyup="kwota_prowizja('+data.id+');" onchange="save_customer('+data.id+');" value="'+data.kwota_prowizja+'">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Kwota brutto</label>' +
                                        '<input type="text" class="form-control bg-red text-center kwota_brutto" name="kwota_brutto" onkeyup="kwota_brutto('+data.id+');" onchange="save_customer('+data.id+');" value="'+data.kwota_brutto+'">' +
                                    '</div>' +
                                '</div>' +    
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-info">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-calendar"></span> Informacje o terminach</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                            
                                '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Termin zawarcia</label>' +
                                        '<input type="text" class="form-control text-center termin_zawarcia" name="termin_zawarcia" onchange="termin_zawarcia('+data.id+');save_customer('+data.id+');" value="'+data.termin_zawarcia+'">' +
                                    '</div>' +
                                    
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Długość w dniach</label>' +
                                        '<input type="text" class="form-control bg-aqua text-center roznica_dat" name="roznica" onkeyup="termin_roznica('+data.id+');" onchange="save_customer('+data.id+');" value="'+roznica_dat(data.termin_zawarcia, data.termin_platnosci)+'">' +
                                    '</div>' +        
                            
                                    '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Termin płatności</label>' +
                                        '<input type="text" class="form-control text-center termin_platnosci" name="termin_platnosci" onchange="termin_platnosci('+data.id+');save_customer('+data.id+');" value="'+data.termin_platnosci+'">' +
                                    '</div>' +
                                '</div>' +    
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="box box-danger">' +
                            '<div class="box-header with-border">' +
                                '<h3 class="box-title" style="text-transform: uppercase;"><span class="fa fa-info-circle"></span> Inne</h3>' +
                                '<div class="box-tools pull-right">' +
                                    '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>' +
                                    '</button>' +
                                '</div>' +
                            '<!-- /.box-tools -->' +
                            '</div>' +
                            '<!-- /.box-header -->' +
                            '<div class="box-body" style="display: block;">' +
                                
                            '<div class="form-group text-center" style="margin-bottom: 68px;">' +
                                '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Agent</label>' +
                                        data.select_agent +
                                '</div>' +
                                        
                                '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Flaga</label>' +
                                        data.select_flaga +
                                '</div>' +
                            
                                '<div class="col-md-4">' +
                                        '<label class="text-uppercase" for="textinput">Spółka</label>' +
                                        data.select_spolka +
                                '</div>' +
                            '</div>' +
                            
                            '<div class="form-group text-center">' +
                                '<div class="col-md-6 col-md-offset-3">' +
                                        '<label class="text-uppercase" for="textinput">Numer umowy</label>' +
                                        '<input type="text" class="form-control text-center nr_umowy" onchange="save_customer('+data.id+');" value="'+data.nr_umowy+'">' +
                                '</div>' +
                            '</div>' +
                            
                            '</div>' +
                            '<!-- /.box-body -->' +
                        '</div>' +
                        '<!-- /.box -->' +
                            
                        '<div class="form-group text-center">' +
                            '<div class="col-md-12 pracownik">' +
                                data.pracownik +
                            '</div>' +        
                        '</div>' +
                        
                    '</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="informacje'+data.id+'">' +
                        '<textarea class="form-control informacje" style="border: none; background: #ededed; height: 400px; resize: vertical; padding: 25px 50px; text-align: justify;" onchange="save_customer('+data.id+');">'+data.informacje+'</textarea>' +
                        '<br />' +
                        '<div class="form-group text-center">' +
                            '<div class="col-md-12 pracownik">' +
                                data.pracownik +
                            '</div>' +        
                        '</div>' +
                    '</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="operacje'+data.id+'"><div class="wpisy">'+data.wpisy+'</div>' +
                    '<div class="row">' +
                    '<div class="col-md-8 col-sm-8 col-xs-8"><input type="text" class="form-control nowy_wpis" /></div>' +
                    '<div class="col-md-4 col-sm-4 col-xs-4"><a class="btn btn-info btn-block" style="border-radius: 0px;" onclick="newWpis('+data.id+');">DODAJ</a></div>' +
                    '</div>' +
                    '</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="windykacja'+data.id+'"><div class="windykacja">'+data.windykacja+'</div>' +
                    '<div class="row">' +
                    '<div class="col-md-8 col-sm-8 col-xs-8"><input type="text" class="form-control nowa_windykacja" /></div>' +
                    '<div class="col-md-4 col-sm-4 col-xs-4"><a class="btn btn-danger btn-block" style="border-radius: 0px;" onclick="newWindykacja('+data.id+');">DODAJ</a></div>' +
                    '</div>' +
                    '</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="drukowanie'+data.id+'">'+data.drukowanie+'</div>' +
                    '<div role="tabpanel" class="tab-pane fade" id="sms'+data.id+'">'+data.sms+'</div>' +
                '</div>' +
                    
            '</div>' +
            '</div>' +
    '</div>'
    );
    $("body").append(html);
    $('#'+data.id).css('left', $(window).width()/2 - $('#'+data.id).width()/2);
    $('#'+data.id).css('top', 65);
    draggable_refresh();
    
    $('#'+data.id+' .agent').selectpicker();
        $('#'+data.id+' .agent').val(data.agent_id);
        $('#'+data.id+' .agent').selectpicker('refresh');
    $('#'+data.id+' .flaga').selectpicker();
        $('#'+data.id+' .flaga').val(data.flaga_id);
        $('#'+data.id+' .flaga').selectpicker('refresh');
        if(data.flaga_kolor == null) data.flaga_kolor = '#ededed';
        $('#'+data.id+' .dropdown-toggle[title="'+data.flaga_nazwa+'"]').css({'background':data.flaga_kolor, 'color':'white', 'text-shadow':'0px 0px 5px black, 0px 0px 1px black', 'text-transform':'uppercase'});
    $('#'+data.id+' .spolka').selectpicker();
        $('#'+data.id+' .spolka').val(data.spolka_id);
        $('#'+data.id+' .spolka').selectpicker('refresh');
    $.fn.datepicker.dates['pl'] = {
        days: ["niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota"],
        daysShort: ["niedz.", "pon.", "wt.", "śr.", "czw.", "piąt.", "sob."],
        daysMin: ["ndz.", "pn.", "wt.", "śr.", "czw.", "pt.", "sob."],
        months: ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"],
        monthsShort: ["sty.", "lut.", "mar.", "kwi.", "maj", "cze.", "lip.", "sie.", "wrz.", "paź.", "lis.", "gru."],
        today: "dzisiaj",
        weekStart: 1,
        clear: "wyczyść",
        format: "yyyy-mm-dd"
    };
    $('#'+data.id+' .data_wydania_dowodu').datepicker({
        language: 'pl'
    });
    $('#'+data.id+' .termin_zawarcia').datepicker({
        language: 'pl'
    });
    $('#'+data.id+' .termin_platnosci').datepicker({
        language: 'pl'
    });
    $('#'+data.id+' .wpisyT, #'+data.id+' .windykacjaT').DataTable({
        //"stateSave": true,
        //"bSort": false,
        aaSorting: [],
        "lengthMenu": [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Wszystkie"]],
        "language": {
            "sProcessing":   "Przetwarzanie...",
            "sLengthMenu":   "Pokaż _MENU_ pozycji",
            "sZeroRecords":  "Nie znaleziono pasujących pozycji",
            "sInfoThousands":  " ",
            "sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
            "sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
            "sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
            "sInfoPostFix":  "",
            "sSearch":       "Szukaj:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Pierwsza",
                "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span>",
                "sNext":     "<span class='glyphicon glyphicon-chevron-right'></span>",
                "sLast":     "Ostatnia"
            },
            "sEmptyTable":     "Brak danych",
            "sLoadingRecords": "Wczytywanie...",
            "oAria": {
                "sSortAscending":  ": aktywuj, by posortować kolumnę rosnąco",
                "sSortDescending": ": aktywuj, by posortować kolumnę malejąco"
            }
        }
    });
    $('#'+data.id+' .informacje').wysihtml5({
        locale: "pl-PL",
        "font-styles": true,
        "emphasis": true,
        "lists": true,
        "html": false,
        "link": true,
        "image": true,
        "color": true,
        events: {
        "change": function() { 
            save_customer(data.id);
        }
        }
    });
    $('#'+data.id+' #zmiana_dokumentu').selectpicker();
    $('#'+data.id+' #zmiana_adresu').selectpicker();
    $('#'+data.id+' #zmiana_banku').selectpicker();
    $('#'+data.id+' #zmiana_numeru').selectpicker();
}

//setup before functions
//var typingTimer;                //timer identifier
//var doneTypingInterval = 300;  //time in ms, 5 second for example

function update_modal(data){
    //clearTimeout(typingTimer);
    //typingTimer = setTimeout(function(){
    $('#'+data.id+' .nazwisko').html(data.nazwisko);
        $('#'+data.id+' .nazwisko').val(data.nazwisko);
    $('#'+data.id+' .spoznienie').html(' - Spóźnienie: '+data.spoznienie);
    $('#'+data.id+' .kod_pocztowy').val(data.kod_pocztowy);
    $('#'+data.id+' .miejscowosc').val(data.miejscowosc);
    $('#'+data.id+' .adres').val(data.adres);
    $('#'+data.id+' .kod_pocztowy2').val(data.kod_pocztowy2);
    $('#'+data.id+' .miejscowosc2').val(data.miejscowosc2);
    $('#'+data.id+' .adres2').val(data.adres2);
    $('#'+data.id+' .pesel').val(data.pesel);
    $('#'+data.id+' .nr_dowodu').val(data.nr_dowodu);
    $('#'+data.id+' .data_wydania_dowodu').val(data.data_wydania_dowodu);
    $('#'+data.id+' .organ_wydajacy_dowod').val(data.organ_wydajacy_dowod);
    $('#'+data.id+' .telefon').val(data.telefon);
    $('#'+data.id+' .telefon2').val(data.telefon2);
    $('#'+data.id+' .kwota_netto').val(data.kwota_netto);
    $('#'+data.id+' .kwota_prowizja').val(data.kwota_prowizja);
    $('#'+data.id+' .kwota_brutto').val(data.kwota_brutto);
    $('#'+data.id+' .termin_zawarcia').val(data.termin_zawarcia);
    $('#'+data.id+' .roznica_dat').val(roznica_dat(data.termin_zawarcia, data.termin_platnosci));
    $('#'+data.id+' .termin_platnosci').val(data.termin_platnosci);
    $('#'+data.id+' .nr_umowy').val(data.nr_umowy);
    $('#'+data.id+' .informacje').html(data.informacje);
    $('#'+data.id+' .pracownik').html(data.pracownik);
    $('#'+data.id+' .agent').val(data.agent_id);
    $('#'+data.id+' .agent').selectpicker('refresh');
    $('#'+data.id+' .flaga').val(data.flaga_id);
    $('#'+data.id+' .flaga').selectpicker('refresh');
    if(data.flaga_kolor == null) data.flaga_kolor = '#ededed';
    $('#'+data.id+' .dropdown-toggle[title="'+data.flaga_nazwa+'"]').css({'background':data.flaga_kolor, 'color':'white', 'text-shadow':'0px 0px 5px black, 0px 0px 1px black', 'text-transform':'uppercase'});
    $('#'+data.id+' .spolka').val(data.spolka_id);
    $('#'+data.id+' .spolka').selectpicker('refresh');
    $('#'+data.id+' .wpisy').html(data.wpisy);
    $('#'+data.id+' .windykacja').html(data.windykacja);
    $('#'+data.id+' .wpisyT, #'+data.id+' .windykacjaT').DataTable({
        //"stateSave": true,
        //"bSort": false,
        aaSorting: [],
        "lengthMenu": [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Wszystkie"]],
        "language": {
            "sProcessing":   "Przetwarzanie...",
            "sLengthMenu":   "Pokaż _MENU_ pozycji",
            "sZeroRecords":  "Nie znaleziono pasujących pozycji",
            "sInfoThousands":  " ",
            "sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
            "sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
            "sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
            "sInfoPostFix":  "",
            "sSearch":       "Szukaj:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Pierwsza",
                "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span>",
                "sNext":     "<span class='glyphicon glyphicon-chevron-right'></span>",
                "sLast":     "Ostatnia"
            },
            "sEmptyTable":     "Brak danych",
            "sLoadingRecords": "Wczytywanie...",
            "oAria": {
                "sSortAscending":  ": aktywuj, by posortować kolumnę rosnąco",
                "sSortDescending": ": aktywuj, by posortować kolumnę malejąco"
            }
        }
    });
    $('#'+data.id+' #zmiana_dokumentu').selectpicker();
    $('#'+data.id+' #zmiana_adresu').selectpicker();
    $('#'+data.id+' #zmiana_banku').selectpicker();
    $('#'+data.id+' #zmiana_numeru').selectpicker();
    //}, doneTypingInterval*2);
}

function save_customer(id){
    //clearTimeout(typingTimer);
    //typingTimer = setTimeout(function(){
    var dzis = new Date();
    var last_change = date_time(dzis);
    var queryString = {
        'id': id,
        'nazwisko': $('#'+id+' input.nazwisko').val(),
        'kod_pocztowy': $('#'+id+' .kod_pocztowy').val(),
        'miejscowosc': $('#'+id+' .miejscowosc').val(),
        'adres': $('#'+id+' .adres').val(),
        'kod_pocztowy2': $('#'+id+' .kod_pocztowy2').val(),
        'miejscowosc2': $('#'+id+' .miejscowosc2').val(),
        'adres2': $('#'+id+' .adres2').val(),
        'pesel': $('#'+id+' .pesel').val(),
        'nr_dowodu': $('#'+id+' .nr_dowodu').val(),
        'data_wydania_dowodu': $('#'+id+' .data_wydania_dowodu').val(),
        'organ_wydajacy_dowod': $('#'+id+' .organ_wydajacy_dowod').val(),
        'telefon': $('#'+id+' .telefon').val(),
        'telefon2': $('#'+id+' .telefon2').val(),
        'kwota_netto': $('#'+id+' .kwota_netto').val(),
        'kwota_prowizja': $('#'+id+' .kwota_prowizja').val(),
        'kwota_brutto': $('#'+id+' .kwota_brutto').val(),
        'termin_zawarcia': $('#'+id+' .termin_zawarcia').val(),
        'termin_platnosci': $('#'+id+' .termin_platnosci').val(),
        'nr_umowy': $('#'+id+' .nr_umowy').val(),
        'informacje': $('#'+id+' .informacje').val(),
        'agent': $('#'+id+' .agent').find("option:selected").val(),
        'flaga': $('#'+id+' .flaga').find("option:selected").val(),
        'spolka': $('#'+id+' .spolka').find("option:selected").val(),
        'pracownik': $('body > div.wrapper > header > nav > div > ul > li.dropdown.user.user-menu > a > span').html(),
        'last_change': last_change
    }
    
            $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/saveCustomer.php',
        data: queryString,
        success: function (result) {
            console.log(result);
        }
    });
    //}, doneTypingInterval);
}

function newWpis(id){
    //clearTimeout(typingTimer);
    //typingTimer = setTimeout(function(){
    var queryString = {
        'id_klienta': id,
        'wpis': $('#'+id+' .nowy_wpis').val(),
        'pracownik': $('body > div.wrapper > header > nav > div > ul > li.dropdown.user.user-menu > a > span').html(),
    }
    
            $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/newWpis.php',
        data: queryString,
        success: function (result) {
            console.log(result);
            $('#'+id+' .nowy_wpis').val("");
        }
    });
    //}, doneTypingInterval);
}

function newWindykacja(id){
    //clearTimeout(typingTimer);
    //typingTimer = setTimeout(function(){
    var queryString = {
        'id_klienta': id,
        'wpis': $('#'+id+' .nowa_windykacja').val(),
        'pracownik': $('body > div.wrapper > header > nav > div > ul > li.dropdown.user.user-menu > a > span').html(),
    }
    
            $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/newWindykacja.php',
        data: queryString,
        success: function (result) {
            console.log(result);
            $('#'+id+' .nowa_windykacja').val("");
        }
    });
    //}, doneTypingInterval);
}



function add_customer(){
    var dzis = new Date();
    var last_change = date_time(dzis);
    var queryString = {
        'nazwisko': $('#nowy input.nazwisko').val(),
        'kod_pocztowy': $('#nowy .kod_pocztowy').val(),
        'miejscowosc': $('#nowy .miejscowosc').val(),
        'adres': $('#nowy .adres').val(),
        'kod_pocztowy2': $('#nowy .kod_pocztowy2').val(),
        'miejscowosc2': $('#nowy .miejscowosc2').val(),
        'adres2': $('#nowy .adres2').val(),
        'pesel': $('#nowy .pesel').val(),
        'nr_dowodu': $('#nowy .nr_dowodu').val(),
        'data_wydania_dowodu': $('#nowy .data_wydania_dowodu').val(),
        'organ_wydajacy_dowod': $('#nowy .organ_wydajacy_dowod').val(),
        'telefon': $('#nowy .telefon').val(),
        'telefon2': $('#nowy .telefon2').val(),
        'kwota_netto': $('#nowy .kwota_netto').val(),
        'kwota_prowizja': $('#nowy .kwota_prowizja').val(),
        'kwota_brutto': $('#nowy .kwota_brutto').val(),
        'termin_zawarcia': $('#nowy .termin_zawarcia').val(),
        'termin_platnosci': $('#nowy .termin_platnosci').val(),
        'nr_umowy': $('#nowy .nr_umowy').val(),
        'informacje': $('#nowy .informacje').val(),
        'agent': $('#nowy .agent').find("option:selected").val(),
        'flaga': $('#nowy .flaga').find("option:selected").val(),
        'spolka': $('#nowy .spolka').find("option:selected").val(),
        'pracownik': $('body > div.wrapper > header > nav > div > ul > li.dropdown.user.user-menu > a > span').html(),
    }
    
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/addCustomer.php',
        data: queryString,
        success: function (result) {
            $('#nowy').remove();
        }
    });
}

function updateWindow(id, data) {
    var queryString = {
        'id': id,
        'data': data
    };
    
    windows[id] = $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/customerData.php',
        data: queryString,
        success: function (result) {
            if(isJson(result)){
            var data = jQuery.parseJSON(result);
            update_modal(data);
            updateWindow(id, result);
            }
        },
        //error: function() {updateWindow(id, data);}
    });
}

function createWindow(id, data) {
    
    var queryString = {
        'id': id,
        'data': data
    };

    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/customerData.php',
        data: queryString,
        success: function (result) {
            var data = jQuery.parseJSON(result);
            if(!$("#"+id).length) {create_modal(data); modal_index(id);}
            else{}
            if(!$("#"+data.id+"_task").length) create_task(data);
            else update_task(data);
        },
        //error: function() {createWindow();}
    });
}

function wyslij_sms(id) {
    
    var queryString = {
        'wiadomosc': $('#'+id+' #wiadomosc').val(),
        'numer': $('#'+id+' #zmiana_numeru').val()
    };
    
    $('#'+id+' #sms_submit').attr("onclick","");
    $('#'+id+' #sms_submit').attr("disabled", "disabled");

    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/sendSMS.php',
        data: queryString,
        success: function (result) {
            if(result == '002') {
                $('#'+id+' #sms_submit').removeClass('btn-default');
                $('#'+id+' #sms_submit').addClass('btn-success');
                setTimeout(function(){
                    $('#'+id+' #sms_submit').attr("onclick","wyslij_sms("+id+")");
                    $('#'+id+' #sms_submit').removeClass('btn-success');
                    $('#'+id+' #sms_submit').addClass('btn-default');
                    $('#'+id+' #sms_submit').removeAttr("disabled");
                }, 3000);
            } else {
                $('#'+id+' #sms_submit').removeClass('btn-default');
                $('#'+id+' #sms_submit').addClass('btn-danger');
                setTimeout(function(){
                    $('#'+id+' #sms_submit').attr("onclick","wyslij_sms("+id+")");
                    $('#'+id+' #sms_submit').removeClass('btn-danger');
                    $('#'+id+' #sms_submit').addClass('btn-default');
                    $('#'+id+' #sms_submit').removeAttr("disabled");
                }, 3000);
            }
        },
        //error: function() {createWindow();}
    });
}

function customSMS(){
    var queryString = {
        'numer': '+48'+$('#custom_numer').val(),
        'wiadomosc': $('#custom_wiadomosc').val()
    };
    
    $('#custom_submit').attr("onclick","");
    $('#custom_submit').attr("disabled", "disabled");

    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/sendSMS.php',
        data: queryString,
        success: function (result) {
            if(result == '002') {
                $('#custom_submit').removeClass('btn-warning');
                $('#custom_submit').addClass('btn-success');
                setTimeout(function(){
                    $('#custom_submit').attr("onclick","customSMS()");
                    $('#custom_submit').removeClass('btn-success');
                    $('#custom_submit').addClass('btn-warning');
                    $('#custom_submit').removeAttr("disabled");
                }, 3000);
            } else {
                $('#custom_submit').removeClass('btn-warning');
                $('#custom_submit').addClass('btn-danger');
                setTimeout(function(){
                    $('#custom_submit').attr("onclick","customSMS()");
                    $('#custom_submit').removeClass('btn-danger');
                    $('#custom_submit').addClass('btn-warning');
                    $('#custom_submit').removeAttr("disabled");
                }, 3000);
            }
        },
        //error: function() {createWindow();}
    });
}

function showAll() {
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/showAll.php',
        beforeSend: function() {
            $('.content-wrapper').css({'background-color': 'white'}); 
            $('.content-wrapper').html('<img class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3" style="margin-top: 10%;" src="http://localhost/assets/img/loading.gif" />');
        },

        success: function (result) {
            
            $('.content-wrapper').html(result);
            
            $('.content-wrapper .dataTable').DataTable({
                "stateSave": true,
                "lengthMenu": [[25, 50, -1], [25, 50, "Wszystkie"]],
                "language": {
                    "sProcessing":   "Przetwarzanie...",
                    "sLengthMenu":   "Pokaż _MENU_ pozycji",
                    "sZeroRecords":  "Nie znaleziono pasujących pozycji",
                    "sInfoThousands":  " ",
                    "sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
                    "sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
                    "sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Szukaj:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Pierwsza",
                        "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span>",
                        "sNext":     "<span class='glyphicon glyphicon-chevron-right'></span>",
                        "sLast":     "Ostatnia"
                    },
                    "sEmptyTable":     "Brak danych",
                    "sLoadingRecords": "Wczytywanie...",
                    "oAria": {
                        "sSortAscending":  ": aktywuj, by posortować kolumnę rosnąco",
                        "sSortDescending": ": aktywuj, by posortować kolumnę malejąco"
                    }
                }
            });
        },
        //error: function() {createWindow();}
    });
}

function showFlag(flaga) {
    
    var queryString = {
        'flaga': flaga
    };
    
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/showFlag.php',
        data: queryString,
        beforeSend: function() {
            $('.content-wrapper').css({'background-color': 'white'}); 
            $('.content-wrapper').html('<img class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3" style="margin-top: 10%;" src="http://localhost/assets/img/loading.gif" />');
        },

        success: function (result) {
            
            $('.content-wrapper').html(result);
            
            $('.content-wrapper .dataTable').DataTable({
                "stateSave": true,
                "lengthMenu": [[25, 50, -1], [25, 50, "Wszystkie"]],
                "language": {
                    "sProcessing":   "Przetwarzanie...",
                    "sLengthMenu":   "Pokaż _MENU_ pozycji",
                    "sZeroRecords":  "Nie znaleziono pasujących pozycji",
                    "sInfoThousands":  " ",
                    "sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
                    "sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
                    "sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Szukaj:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Pierwsza",
                        "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span>",
                        "sNext":     "<span class='glyphicon glyphicon-chevron-right'></span>",
                        "sLast":     "Ostatnia"
                    },
                    "sEmptyTable":     "Brak danych",
                    "sLoadingRecords": "Wczytywanie...",
                    "oAria": {
                        "sSortAscending":  ": aktywuj, by posortować kolumnę rosnąco",
                        "sSortDescending": ": aktywuj, by posortować kolumnę malejąco"
                    }
                }
            });
        },
        //error: function() {createWindow();}
    });
}

function Windykacja() {
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/Windykacja.php',
        beforeSend: function() {
            $('.content-wrapper').css({'background-color': 'white'}); 
            $('.content-wrapper').html('<img class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3" style="margin-top: 10%;" src="http://localhost/assets/img/loading.gif" />');
        },

        success: function (result) {
            
            $('.content-wrapper').html(result);
            $('.content-wrapper .selectpicker').selectpicker();
            
        },
        //error: function() {createWindow();}
    });
}

function windykacjaTable(n, agent) {
    
    var queryString = {
        'n': n,
        'agent': agent
    };
    
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/windykacjaTable.php',
        data: queryString,
        beforeSend: function() {
            $('.content-wrapper #windykacja').css({'background-color': 'white'}); 
            $('.content-wrapper #windykacja').html('<img class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3" style="margin-top: 10%;" src="http://localhost/assets/img/loading.gif" />');
        },

        success: function (result) {
            
            $('#windykacja').html(result);
            $('#windykacja .dataTable').DataTable({
                "stateSave": true,
                "lengthMenu": [[25, 50, -1], [25, 50, "Wszystkie"]],
                "language": {
                    "sProcessing":   "Przetwarzanie...",
                    "sLengthMenu":   "Pokaż _MENU_ pozycji",
                    "sZeroRecords":  "Nie znaleziono pasujących pozycji",
                    "sInfoThousands":  " ",
                    "sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
                    "sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
                    "sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Szukaj:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Pierwsza",
                        "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span>",
                        "sNext":     "<span class='glyphicon glyphicon-chevron-right'></span>",
                        "sLast":     "Ostatnia"
                    },
                    "sEmptyTable":     "Brak danych",
                    "sLoadingRecords": "Wczytywanie...",
                    "oAria": {
                        "sSortAscending":  ": aktywuj, by posortować kolumnę rosnąco",
                        "sSortDescending": ": aktywuj, by posortować kolumnę malejąco"
                    }
                }
            });
            
        },
        //error: function() {createWindow();}
    });
}

function showAgent(agent) {
    
    var queryString = {
        'agent': agent
    };
    
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/showAgent.php',
        data: queryString,
        beforeSend: function() {
            $('.content-wrapper').css({'background-color': 'white'}); 
            $('.content-wrapper').html('<img class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3" style="margin-top: 10%;" src="http://localhost/assets/img/loading.gif" />');
        },

        success: function (result) {
            
            $('.content-wrapper').html(result);
            
            $('.content-wrapper .dataTable').DataTable({
                "stateSave": true,
                "lengthMenu": [[25, 50, -1], [25, 50, "Wszystkie"]],
                "language": {
                    "sProcessing":   "Przetwarzanie...",
                    "sLengthMenu":   "Pokaż _MENU_ pozycji",
                    "sZeroRecords":  "Nie znaleziono pasujących pozycji",
                    "sInfoThousands":  " ",
                    "sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
                    "sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
                    "sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Szukaj:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Pierwsza",
                        "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span>",
                        "sNext":     "<span class='glyphicon glyphicon-chevron-right'></span>",
                        "sLast":     "Ostatnia"
                    },
                    "sEmptyTable":     "Brak danych",
                    "sLoadingRecords": "Wczytywanie...",
                    "oAria": {
                        "sSortAscending":  ": aktywuj, by posortować kolumnę rosnąco",
                        "sSortDescending": ": aktywuj, by posortować kolumnę malejąco"
                    }
                }
            });
        },
        //error: function() {createWindow();}
    });
}

function smsSaldo(){
    
    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/smsBalance.php',
        success: function (result) {
            var balance = result;
            var Tbalance = balance.split(" ");
            Tbalance[1] = parseFloat(Tbalance[1], "10");
            Tbalance[1] = Tbalance[1].toFixed(2);
            $("#saldo").html(Tbalance[1]+' PLN');
        },
    });
}

// ============================================================

// EXECUTABLES

$(".sidebar-mini .sidebar-toggle").click(function(){
            var sidebar = getCookie('sidebar');
            if(sidebar == 0 || sidebar == "")
                setCookie('sidebar', 1, '3600');
            else
                setCookie('sidebar', 0, '3600');
});

$(document).ready(function(){
    $(".draggable").draggable({
        handle: ".box-header",
        drag: function(event, ui) {
            if( ui.position.left < 0){ ui.position.left=0;}
            if( ui.position.top< 0){ ui.position.top=0;}
            var maxRight = $(window).width() - $(this).width();
            if(ui.position.left > maxRight) {
            ui.position.left = maxRight;
            }
        }
    });
    $(".draggable").resizable({handles: 'e'});
    $(".draggable").css('height', 'auto');
    $("#tasks").html(localStorage.tasks);
    smsSaldo();
});

//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 500;  //time in ms (5 seconds)

//on keyup, start the countdown
$('#search').keyup(function(){
    clearTimeout(typingTimer);
    if ($('#search').val()) {
        typingTimer = setTimeout(search, doneTypingInterval);
    }
});