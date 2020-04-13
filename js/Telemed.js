/**
 * Actividad v.1.6.2
 * Pseudo-Class to manage all the Actividad process
 * @changelog
 *      - 1.6.2: Se reduce la cantidad de consultas para el barrio
 *      - 1.6.1: Función lambda para retornar la dirección
 *      - 1.6.0: Se agrega notificaciones y búsqueda de barrios
 *      - 1.5.1: Se agrega la verificación de si un elemento existe
 * @param {object} params Object with the class parameters
 * @param {function} callback Function to return the results
 */
var Telemed = function(){
    
    /**************************************************************************/
    /******************************* ATTRIBUTES *******************************/
    /**************************************************************************/
    var self = this;
    
    //DOM attributes
    /**************************************************************************/
    /********************* CONFIGURATION AND CONSTRUCTOR **********************/
    /**************************************************************************/
    //Mix the user parameters with the default parameters
    var def = {
        ajaxUrl:'../'
    };
    
    /**
     * Constructor Method 
     */
    var Telemed = function() {
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
    
    
        
//       
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    searchState=function(idCountry){
      console.log("consulta departamento");  
    };
     self.removeDiv=function(index,anchorName){
        var msg="";
        var typeMsg;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: self.getRootWebSitePath()+'/index.php/site/removeAnchorage',
            data:{anchorName:anchorName},   
            beforeSend:function(){
                $.LoadingOverlay("show");
            }
        }).done(function(response) {
           self.notifyMsg(response.msg,response.status);
           if(response.status=='success'){
               $( "#sm-"+index ).remove();
           }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al ejecutar la petición";
            typeMsg="danger";
            self.notifyMsg(msg,typeMsg);
        }).always(function(){
            $.LoadingOverlay("hide");
        });
    }
    self.anchorAtStart=function(index,controllerName,viewName,nameAnchor,serviceEntityId){
        console.log(index+" "+controllerName+" "+viewName+" "+nameAnchor);
        var msg="";
        var typeMsg;
        $.ajax({
            type: "POST",
            dataType:'json',
            url: self.getRootWebSitePath()+'/index.php/site/anchorageAtStart',
            data:{controllerName:controllerName,viewName:viewName,nameAnchor:nameAnchor,serviceEntityId:serviceEntityId,params:{"index":index}},   
            beforeSend:function(){
                $.LoadingOverlay("show");
            }
        }).done(function(response) {
           console.log(JSON.stringify(response));
           self.notifyMsg(response.msg,response.status);
        }).fail(function(error, textStatus, xhr) {
            msg="Error al ejecutar la petición";
            typeMsg="danger";
            self.notifyMsg(msg,typeMsg);
        }).always(function(){
            $.LoadingOverlay("hide");
        });
    }
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    
    
        self.getBaseUrl=function(){
            var re = new RegExp(/^.*\//);
            var baseUrl=re.exec(window.location.href);
            return baseUrl;
        }
        /**
         * Retorna la configuración del lenguaje para el plugin datatable
         * @returns {object} Objeto con la configuración de idioma para datatable
         */
        self.getDatatableLang=function(){
            return {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "_START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty":      "0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                buttons: {
                    colvis: 'Columnas visibles',
                    copy: 'Copiar al portapapeles',
                    excel: 'Excel',
                    selectAll: 'Seleccionar todo'
                },
                select: {
                    rows: {
                        _: "",
                        0: "",
                        1: ""
                    }
                }
            };
        };
        self.notifyMsg=function(msg,type){
            $.notify({
                icon: "add_alert",
                message: msg

            }, {
              type: type,
              timer: 3000,
              placement: {
                from: "top",
                align: "right"
              }
            });
        };
        self.getRootWebSitePath=function(){
            var _location = document.location.toString();
            var applicationNameIndex = _location.indexOf('/', _location.indexOf('://') + 3);
            var applicationName = _location.substring(0, applicationNameIndex) + '/';
            var webFolderIndex = _location.indexOf('/', _location.indexOf(applicationName) + applicationName.length);
            var webFolderFullPath = _location.substring(0, webFolderIndex);
            return webFolderFullPath;
        };
//        window.confirm = function(title,msg) {
//                $.confirm({
//                    title: title,
//                    content: msg,
//                    buttons: {
//                        si: function () {
//                            return true;
//                        },
//                        no: function () {
//                            return false;
//                        }
//                    }
//                });
//            }
        self.confirmDialog=function(title,msg){
            
        }
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function() {
    
    window.Telemed=new Telemed();
    
    
});