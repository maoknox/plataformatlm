/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Actividad v.1.6.2
 * Pseudo-Class to manage all the Actividad process

 */
var ChartsWater = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    //DOM attributes
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    
   
    /**
     * Constructor Method 
     */
    var ChartsWater = function() {
        setDefaults();
    }();
     
    /**************************************************************************/
    /****************************** SETUP METHODS *****************************/
    /**************************************************************************/
    /**
     * Set defaults for Actividad
     * @returns {undefined}
     */
    function setDefaults(){
         Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        Highcharts.setOptions({
            lang: {
                loading: 'Cargando...',
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                exportButtonTitle: "Exportar",
                printButtonTitle: "Importar",
                rangeSelectorFrom: "Desde",
                rangeSelectorTo: "Hasta",
                rangeSelectorZoom: "Período",
                downloadPNG: 'Descargar imagen PNG',
                downloadJPEG: 'Descargar imagen JPEG',
                downloadPDF: 'Descargar imagen PDF',
                downloadSVG: 'Descargar imagen SVG',
                printChart: 'Imprimir',
                resetZoom: 'Reiniciar zoom',
                resetZoomTitle: 'Reiniciar zoom',
                thousandsSep: ",",
                decimalPoint: '.'
            }
        });
    };    
    
   
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.drawChart=function(index,jsonData){
//        chartReadingConsum0001572
        $('#chartReadingConsum'+index).highcharts({
            chart: {
                defaultSeriesType: 'spline',
                animation: Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                zoomType: 'y'
            },
            plotOptions: {
                spline: {
                    turboThreshold: 9000,
                    lineWidth: 2,
                    states: {
                        hover: {
                            enabled: true,
                            lineWidth: 3
                        }
                    },
                    marker: {
                        enabled: true,
                        states: {
                            hover: {
                                enabled : true,
                                radius: 5,
                                lineWidth: 1
                            }
                        }  
                    }      
                }
            },
            title: {
                text: 'Histórico de consumos'
            },
            xAxis: {
                    title: {
                        text: 'Fecha'
                    },
                    dateTimeLabelFormats: { // don't display the dummy year
                        month: '%e. %b',
                        year: '%b'
                    },
                    type: 'datetime',
//                tickInterval: 1
            },
            yAxis: {
                title: {
                    text: $("#"+index).find("#magnitude").val()
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function () {
                    return 'Fecha: '+Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                    'Medición: '+Highcharts.numberFormat(this.y, 2)+' m3';
                }
            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: true
            },
            series: jsonData,
        }); 
    }
    
   
     
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    
    
    

    
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
