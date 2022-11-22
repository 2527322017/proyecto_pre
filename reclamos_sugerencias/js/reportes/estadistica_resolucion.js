var URL_AJAX = proyecto_carpeta + 'procesar_datos/reportes__estadistica_resolucion';
$(document).ready(function () {
    consultar();
    $("#year_data").change(function (e) { 
        consultar();      
    });
});


function consultar() {
    $.ajax({
        type: "POST",
        url: URL_AJAX,
        dataType: "json",
        data: {year: $("#year_data").val()},
        beforeSend: function() {
            loader.open();
        },
        success: function (response) {
            loader.close();
            if(response.status == 'success') {
               //console.log(response.result);
               makeChart(response.result)
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           console.log(textStatus);
           loader.close();
        }
    });
}


function makeChart(dataChart) {
    $("#contenedorPrincipal").show();
    year_data = $("#year_data").val();
    Highcharts.chart('containerChart', {
        chart: {
            styledMode: true
        },
        title: {
            text: 'Casos por tipo de resolución, ' + year_data
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        series: [{
            name: "N° Casos",
            type: 'pie',
            allowPointSelect: true,
            keys: ['name', 'y'],
            data: dataChart.chart1,
            showInLegend: true
        }]
    });

    Highcharts.chart('containerChart2', {
        chart: {
            styledMode: true
        },
        title: {
            text: 'Resolución por tipo de registro, ' + year_data
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        series: [{
            name: "N° Casos",
            type: 'pie',
            allowPointSelect: true,
            keys: ['name', 'y'],
            data: dataChart.chart2,
            showInLegend: true
        }]
    });

    const chart = Highcharts.chart('containerChart3', {
        title: {
            text: 'Resolución de casos por mes, ' + year_data
        },
        xAxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Cantidad'
            }
        },
        series: [{
            type: 'column',
            name: 'N° Casos',
            colorByPoint: true,
            data: dataChart.chart3,
            showInLegend: false
        }]
    });
    
    document.getElementById('containerChart3_plain').addEventListener('click', () => {
        chart.update({
            chart: {
                inverted: false,
                polar: false
            }
        });
    });
    
    document.getElementById('containerChart3_inverted').addEventListener('click', () => {
        chart.update({
            chart: {
                inverted: true,
                polar: false
            }
        });
    });
    
    document.getElementById('containerChart3_polar').addEventListener('click', () => {
        chart.update({
            chart: {
                inverted: false,
                polar: true
            }
        });
        
    });

}