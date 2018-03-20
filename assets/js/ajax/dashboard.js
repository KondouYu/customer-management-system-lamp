function Dashboard(data) {
    var queryString = {
        'data': data
    };

    $.ajax({
        type: 'POST',
        url: 'http://localhost/ajax/controllers/dashboard.php',
        data: queryString,
        success: function (result) {
            
            //PARSE DATA
            var display = jQuery.parseJSON(result);
            
            //TODAY OPERATIONS
            $('#today').html('');
            $('#today').html(display.today);
            
            $('#today .dataTable').DataTable({
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
            
            //DASHBOARD STATS
            $('#wszystkich').html(format_commas(display.stats.wszystkich));
            $('#nowych').html(format_commas(display.stats.nowych));
            $('#u_komornika').html(format_commas(display.stats.u_komornika));
            $('#splaconych').html(format_commas(display.stats.splaconych));
            $('#w_sadzie').html(format_commas(display.stats.w_sadzie));
            $('#czynnych').html(format_commas(display.stats.czynnych));
            $('#c_nowych').html(format_commas(display.stats.c_nowych));
            $('#netto').html(format_commas(display.stats.netto) + ' zł');
            $('#brutto').html(format_commas(display.stats.brutto) + ' zł');
            $('#kapital').html(format_commas(display.stats.kapital) + ' zł');
            $('#ugoda').html(format_commas(display.stats.ugoda) + ' zł');
            Dashboard(result);
            
        //end of 'success:' event
        },
        error: function() {Dashboard();}
    });
}

// initialize jQuery
$(function () {
    Dashboard();
});