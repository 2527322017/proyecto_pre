var URL_AJAX = proyecto_carpeta + 'procesar_datos/reportes__estadistica_casos';
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
    Highcharts.chart('containerChart1', {
        chart: {
            styledMode: true
        },
        title: {
            text: 'Casos registrados por área de salud, ' + year_data
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
            text: 'Casos por tipo de registro, ' + year_data
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

    Highcharts.chart('containerChart3', {
        chart: {
            styledMode: true
        },
        title: {
            text: 'Casos registrados por género, ' + year_data
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        series: [{
            name: "N° Casos",
            type: 'pie',
            allowPointSelect: true,
            keys: ['name', 'y'],
            data: dataChart.chart3,
            showInLegend: true
        }]
    });

    Highcharts.chart('containerChart4', {
        chart: {
            styledMode: true
        },
        title: {
            text: 'Casos registrados por tipo cliente, ' + year_data
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        series: [{
            name: "N° Casos",
            type: 'pie',
            allowPointSelect: true,
            keys: ['name', 'y'],
            data: dataChart.chart4,
            showInLegend: true
        }]
    });


    const chart5 = Highcharts.chart('containerChart5', {
        title: {
            text: 'Registro de casos por mes, ' + year_data
        },
        xAxis: {
            categories: ['Registrado', 'Asignado', 'Análisis', 'Verificación', 'Finalizado']
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
            data: dataChart.chart5,
            showInLegend: false
        }]
    });
    
    document.getElementById('containerChart5_plain').addEventListener('click', () => {
        chart5.update({
            chart: {
                inverted: false,
                polar: false
            }
        });
    });
    
    document.getElementById('containerChart5_inverted').addEventListener('click', () => {
        chart5.update({
            chart: {
                inverted: true,
                polar: false
            }
        });
    });
    
    document.getElementById('containerChart5_polar').addEventListener('click', () => {
        chart5.update({
            chart: {
                inverted: false,
                polar: true
            }
        });
        
    });


    const chart6 = Highcharts.chart('containerChart6', {
        title: {
            text: 'Registro de casos por mes, ' + year_data
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
            data: dataChart.chart6,
            showInLegend: false
        }]
    });
    
    document.getElementById('containerChart6_plain').addEventListener('click', () => {
        chart6.update({
            chart: {
                inverted: false,
                polar: false
            }
        });
    });
    
    document.getElementById('containerChart6_inverted').addEventListener('click', () => {
        chart6.update({
            chart: {
                inverted: true,
                polar: false
            }
        });
    });
    
    document.getElementById('containerChart6_polar').addEventListener('click', () => {
        chart6.update({
            chart: {
                inverted: false,
                polar: true
            }
        });
        
    });

}