/**
 * Actividad v.1.6.2
 * Pseudo-Class to manage all the Actividad process

 */
var ViewMeterData = function(){
    
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
    var ViewMeterData = function() {
        self.div=$("#divViewMeterData");
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
   
    
    
      self.drawMap=function(){
        geocoder = new google.maps.Geocoder();
        var latLong="";
        var lat="";
        var lng="";
        //In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
        console.log(self.div.find("#city").val()+" "+self.div.find("#address").val());
        geocoder.geocode( { 'address' : self.div.find("#city").val()+" "+self.div.find("#address").val() }, function( results, status ) {
            if( status == google.maps.GeocoderStatus.OK ) {

                //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
               console.log(JSON.stringify(results[0].geometry.location.lat)+" direcciongoogle-----");
                    latLong=results[0].geometry.location;
                    lat=latLong.lat();
                    lng=latLong.lng();
               
            } else {
                    lat='4.596953';
                    lng='-74.081125';
                    latLong={"lat":4.596953, lng:-74.081125}
            }
            
            var map = L.map( 'map', {
                center: [10.0, 5.0],
                minZoom: 2,
                zoom: 2
            });

            L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                subdomains: ['a','b','c']
            }).addTo( map );

//        var myURL = jQuery( 'script[src$="leaf-demo.js"]' ).attr( 'src' ).replace( 'leaf-demo.js', '' );

           
            var myIcon = L.icon({
                iconUrl: Telemed.getRootWebSitePath() + '/images/pin24.png',
                iconRetinaUrl: Telemed.getRootWebSitePath() + '/images/pin48.png',
                iconSize: [29, 24],
                iconAnchor: [9, 21],
                popupAnchor: [0, -14]
            });

            var markerClusters = L.markerClusterGroup();

//        for ( var i = 0; i < markers.length; ++i ){
//            var popup = markers[i].name +
//                '<br/>' + markers[i].city +
//                '<br/><b>IATA/FAA:</b> ' + markers[i].iata_faa +
//                '<br/><b>ICAO:</b> ' + markers[i].icao +
//                '<br/><b>Altitude:</b> ' + Math.round( markers[i].alt * 0.3048 ) + ' m' +
//                '<br/><b>Timezone:</b> ' + markers[i].tz;
           
            var m = L.marker( [lat, lng], {icon: myIcon} )//.bindPopup( popup );
            markerClusters.addLayer( m );
//        }
            
            map.addLayer( markerClusters );   
            map.setView([lat, lng],25);
//                console.log(latLong+" direccion-----!!!");
        } );
        
        
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
$(document).ready(function() {
//    console.log($("#divRegPerson").html()+"-----------------------------------");

    window.ViewMeterData=new ViewMeterData();
    ViewMeterData.drawMap();
    
});