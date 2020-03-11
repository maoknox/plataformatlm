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
var InfoMeter = function(){
    
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
    var self=this;
    self.dataTable="";
    /**
     * Constructor Method 
     */
    var InfoMeter = function() {
        self.div=$("#showMeters");        
    }();
    
    self.init=function(){
        setDefaults();
    }
     
    /**************************************************************************/
    /****************************** SETUP METHODS *****************************/
    /**************************************************************************/
    /**
     * Set defaults for Actividad
     * @returns {undefined}
     */
    function setDefaults(){
//        $('#datatables').DataTable({
//            "pagingType": "full_numbers",
//            "lengthMenu": [
//              [10, 25, 50, -1],
//              [10, 25, 50, "All"]
//            ],
//            responsive: true,
//            language: {
//              search: "_INPUT_",
//              searchPlaceholder: "Search records",
//            }
//        });
//        $('#datatables').DataTable( {
//        "ajax":{
//                url :"searchInfoDTables", // json datasource
//                type: "post",  // type of method  ,GET/POST/DELETE
////                data:{"table":"view_medidor_gen","namefunc":"search_info_meds",idEmpresa:idEmpresa},
//                error: function(xhr, error, thrown){
//                    console.log(xhr.responseText);
//                }
//            }
//    } );
        
        self.dataTable=$("#datatables").DataTable({
            "processing": false,
            "serverSide": false,
            dom: 'lBfrtip',            
            buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdfHtml5'
           ],
           lengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            responsive: true,
            fixedHeader: {
                header: true,
                footer: true
            },
            "ajax":{
                url :"searchInfoDTables", // json datasource
                type: "post",  // type of method  ,GET/POST/DELETE
//                data:{"table":"view_medidor_gen","namefunc":"search_info_meds",idEmpresa:idEmpresa},
                error: function(xhr, error, thrown){
                    console.log(xhr.responseText);
                }
            },
            "destroy" : true,
            oLanguage: Telemed.getDatatableLang(),
            scrollX: true
        });
    };    
    /**************************************************************************/
    /********************************** METHODS *******************************/
    /**************************************************************************/
    self.loadTree=function(data){
//      console.log("carga arbol");
        self.div.find('#treemeters')
        .jstree({
            "languages" : [ "es" ],
            'core' : {
                'multiple' : false,
                'check_callback': function (operation, node, node_parent, node_position, more) {
        // operation can be 'create_node', 'rename_node', 'delete_node', 'move_node', 'copy_node' or 'edit'
        // in case of 'rename_node' node_position is filled with the new node name
//                    console.log(operation);
                    if (operation === 'delete_node') {
                        var bool=confirm("Seguro de eliminar el nodo?");
                        if (!bool) {
                            return false;
                        }
                    }
                    if (operation === 'create_node') {
                        var bool=confirm("¿Desea crear un grupo?");
                        if (!bool) {
                            return false;
                        }
                    }
                    return true;
                },
                'data' : data,                	
            },
            'search': {
                'case_insensitive': true,
                'show_only_matches' : true,
                'show_only_matches_children':true
            },
            "types" : {               
                "root" : {
                  "icon" : "https://digital.nhs.uk/svg-magic/binaries/content/gallery/website/icons/tech/nodes.svg?colour=005eb8",
                  "valid_children" : ["default"]
                },
                "default" : {
                    "icon" : "https://digital.nhs.uk/svg-magic/binaries/content/gallery/website/icons/process/organisation-chart-vertical.svg?colour=005eb8",
                  "valid_children" : ["default","file"]
                },
                "file" : {
                  "icon" : "https://www.svgrepo.com/show/219809/gauge-meter.svg",
                  "valid_children" : []
                }
              },
            "plugins" : [
                    "contextmenu", "dnd", "search",
                    "state", "types"
            ],
            "contextmenu": {
                "items": function ($node) {
                    var tree = $("#treemeters").jstree(true);
                    return {
                        "create": {
                            "separator_before": false,
                            "separator_after": false,
                            "label": "Crear grupo",
                            "action": function (obj) {
//                                
                                    $node = tree.create_node($node, {
                                       text: 'Nuevo grupo',
                                       type: 'default'
                                     });
                                     if($node){
                                        tree.deselect_all();
                                        tree.select_node($node);
                                        tree.edit($node);
                                    }
//                                
                            }
                        },
                        "rename": {
                            "label": "Renombrar grupo",
                            "action": function (obj) {                           
                                tree.edit($node);
                            }
                        }
                    };
                }
            }
        }).on("move_node.jstree", function(e, data) {
            self.changeOrderNode(data);
        }).on('create_node.jstree', function (e, data) {
            self.createGroup(data.parent,data);
                //$.get('?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
//                        data.node.id=15;

        }).on('activate_node.jstree', function (e, data) {
            if(data.node && data.node.type==='file'){                
                console.log("Click node: " + data.node.text +" "+data.node.id);
            }
        }).on('rename_node.jstree', function (e, data) {
            self.renameGroup(data.node.text,data.node.id);
        }).on('search.jstree', function (nodes, str, res) {
            if (str.nodes.length===0) {
                $('#treemeters').jstree(true).hide_all();
            }
        });
    }
    /**************************************************************************/
    /******************************* SYNC METHODS *****************************/
    /**************************************************************************/ 
    /**
     * Filtra por texto digitado las empresas creadas
     */
    /**
     * Change group name
     */
    
    self.renameGroup=function(groupName,groupId){
         $.ajax({
            type:"post",
            url: 'renameGroup',
            data:{"groupName":groupName,"groupId":groupId},	        
            success: function(response) {
                response=JSON.parse(response);
                if(response.status=='success'){
                    Telemed.notifyMsg("Se modificó el nombre del grupo",response.status);
                }
            },
            error: function() {
                Telemed.notifyMsg("Creación no exitosa","error");
            }
        });
    }
    
    
    /**
     * Search groups,sub-groups and objects
     */
    
    
    self.searchGroupsAndLoadTree=function(){
        //User.showLoading();
        $.ajax({
            type: "POST",
            dataType:'json',
            url: 'getTree',
        }).done(function(response) {
            if(response.status=="nosession"){
                $.notify("La sesión ha caducado, debe hacer login de nuevo", "warn");
                setTimeout(function(){document.location.href="site/login";}, 3000);
                return;
            }
            else{                
                if(response.status==='success'){
//                    md.showNotification('top','right');
                    self.loadTree(response.tree);
                    $('#deliverable_search').keyup(function(){
                        $('#treemeters').jstree(true).show_all();
                        $('#treemeters').jstree('search', $(this).val());
                    });
                }
                else{
                   
                        
                }
            }
        }).fail(function(error, textStatus, xhr) {
            msg="Error al asociar el servicio, el código del error es: "+error.status+" "+xhr;
            typeMsg="error";
        });
    }
    /*Change node order*/
    self.changeOrderNode=function(data){       
        $.ajax({
            type:"post",
            data:{"children_id":data.node.id,"parent_id":data.parent},
            url: 'changeNode',
            success: function(response) {
                response=JSON.parse(response);
                if(response=='success'){
                    Telemed.notifyMsg("Modificación exitosa",response);
                }
            },
            error: function() {
                Telemed.notifyMsg("Modificación no exitosa","error");
            }
        });
    }
    self.createGroup=function(parentId,data){
        $.ajax({
            type:"post",
            url: 'createGroup',
            data:{"parentId":parentId,"childName":data.node.text},	        
            success: function(response) {
                response=JSON.parse(response);
                
                if(response.status=='success'){                    
                     data.instance.set_id(data.node, response.groupid);
                     console.log(data.node.id);
                    Telemed.notifyMsg("Se creo el grupo de manera exitosa","success");
                }
            },
            error: function() {
                Telemed.notifyMsg("Creación no exitosa","danger");
            }
        });
    }
    /**************************************************************************/
    /******************************* DOM METHODS ******************************/
    /**************************************************************************/
    
    /**************************************************************************/
    /****************************** OTHER METHODS *****************************/
    /**************************************************************************/
    
};
$(document).ready(function () {
        window.InfoMeter = new InfoMeter();
        InfoMeter.init();
        InfoMeter.searchGroupsAndLoadTree();
    });