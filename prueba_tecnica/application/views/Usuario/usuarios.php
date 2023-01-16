<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container'>
            <div class='card'>
                <div class='card-header'>
                    <h1>Usuarios de sistema</h1>
                </div>
                <div class='card-body'>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal_Insert" data-bs-whatever="@mdo" onclick="form_user();">
                        <i class="fa fa-user"></i> Nuevo Usuario
                    </button><br><br>
                    <nav class="float-right">
                        <div class="col-sm-12">
                            <div class="alert alert-success" id="registroCorrecto" style="display: none;"></div>
                        </div>
                    </nav>
                    <div id="gridContainer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal_Insert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >
        <div class="col-md-12">
            <div id="validacion" style="color:red"></div>
        </div>
        <div id="formContainer"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="insertar();">Ingresar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Modal_Edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <div id="validacion2" style="color:red"></div>
        </div>
         <div id="formContainer2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editar();">Modificar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Modal_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Inactivar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <div id="validacion3" style="color:red">Esta seguro de inactivar este usuario?</div>
        </div>
         <div id="formContainer3"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="eliminar();">Inactivar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Modal_cambio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Inactivar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <div id="validacion4" style="color:red">Esta seguro de que le quiere cambiar la contraseña a este usuario?</div>
        </div>
         <div id="formContainer4"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="cambio_contra();">Cambiar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    show_data();
    function show_data(){
        $.ajax({
            type  : 'POST',
            url: '<?php echo site_url('Inicio/usuarios_prueba')?>',
            async : false,
            dataType : 'JSON',
            data : {},
            success : function(data){
                $('#gridContainer').dxDataGrid({
                    dataSource: data,
                    keyExpr: 'id_usuario',
                    allowColumnReordering: true,
                    allowColumnResizing: true,
                    columnAutoWidth: true,
                    showBorders: true,
                    columnFixing: {
                      enabled: true,
                    },
                    paging: {
                      pageSize: 10,
                    },
                    pager: {
                      showPageSizeSelector: true,
                      allowedPageSizes: [10, 25, 50, 100],
                    },
                    searchPanel: {
                      visible: true,
                      highlightCaseSensitive: true,

                    },
                    columns: [{
                      caption: 'Usuario',
                      fixed: true,
                      calculateCellValue(data) {
                        return [data.nombre,
                          data.apellido]
                          .join(' ');
                      },
                    },
                    {
                      dataField: 'email',
                      dataType: 'string',
                    },
                    {
                      caption: 'Rol',
                      //fixed: true,
                      calculateCellValue(data) {
                        if(data.rol == 1){
                            rol = 'Administrator';
                        }else if(data.rol == 2){
                            rol = 'Usuario';
                        }
                        return [rol]
                          .join(' ');
                      },
                    },
                    {
                      caption: 'Estado',
                      //fixed: true,
                      calculateCellValue(data) {
                        if(data.estado == 1){
                            estado = 'Activo';
                        }else if(data.estado == 0){
                            estado = 'No activo';
                        }
                        return [estado]
                          .join(' ');
                      },
                    },
                    {
                        caption: 'Editar',
                        type: "buttons",
                        buttons: ["edit", {
                            text: "Editar",
                            cssClass: "btn btn-outline-success",
                            onClick: function (e) {
                                get_edit(e.row.data.id_usuario);
                            }
                        }]
                    },
                    {
                        caption: 'Desactivar',
                        type: "buttons",
                        buttons: ["delete",  {
                            text: "Inactivo/a",
                            cssClass: "btn btn-outline-danger",
                            onClick: function (e) {
                                get_delete(e.row.data.id_usuario);
                            }
                        }]
                    },
                    {
                        caption: 'Contraseña',
                        type: "buttons",
                        buttons: ["delete",  {
                            text: "Cambiar contraseña",
                            cssClass: "btn btn-outline-primary",
                            onClick: function (e) {
                                cambio(e.row.data.id_usuario);
                            }
                        }]
                    }
                    ], 
                });
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });     
    };

    function form_user(){
        roles = [
        {
            ID: 1,
            Name: 'Admin',
        },{
            ID: 2,
            Name: 'Usuario',
        },
        ];
        $("#formContainer").dxForm({
            labelLocation: 'top',
            items: [{
                dataField: "Nombre",
                editorType: "dxTextBox",
                value: '',
                
            }, {
                dataField: "Apellido",
                editorType: "dxTextBox",
                value: '',
                
            }, {
                dataField: "Correo",
                editorType: "dxTextBox",
                value: '',

            }, {
                dataField: "Rol",
                editorType: "dxSelectBox",
                editorOptions: {
                    dataSource: roles,
                    valueExpr: 'ID',
                    displayExpr: 'Name',
                    searchEnabled: true,
                    value: 2,
                }
            },],

        });
        limpiar();
    }

    function insertar(){
        nombre = $('[name="Nombre"]').val();
        apellido = $('[name="Apellido"]').val();
        correo = $('[name="Correo"]').val();
        rol = $('[name="Rol"]').val();
        
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Inicio/insertar_user')?>",
            dataType : "JSON",
            data : {nombre:nombre,apellido:apellido,correo:correo,rol:rol},
            success: function(data){
                console.log(data);
                if(data.validacion == ''){
                    show_data();
                    document.getElementById('validacion').innerHTML = '';
                    $('#formContainer').empty();
                    $("#Modal_Insert").modal('toggle');
                    Swal.fire({
                      icon: 'success',
                      title: 'Ingreso',
                      text: 'El usuario ingresado con exito!!',
                    });
                    document.getElementById('registroCorrecto').innerHTML = data.contra;
                    $('#registroCorrecto').show();

                }else{
                    document.getElementById('validacion').innerHTML = data.validacion;
                }
            },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }

        });
    }

    function limpiar(){
        $('[name="Nombre"]').val('');
        $('[name="Apellido"]').val("");
        $('[name="Correo"]').val("");
    }

    function get_edit(id_usuario){
        $.ajax({
            type  : "POST",
            url   : "<?php echo site_url('Inicio/get_user')?>",
            dataType : "JSON",
            data : {id_usuario:id_usuario},
            success : function(data){
                roles = [
                {
                    ID: 1,
                    Name: 'Admin',
                },{
                    ID: 2,
                    Name: 'Usuario',
                },
                ];
                $("#formContainer2").dxForm({
                    labelLocation: 'top',
                    items: [{
                        dataField: "Nombre_edit",
                        label: {
                            text: "Nombre"
                        },
                        editorType: "dxTextBox",
                        editorOptions: {
                            value: data[0].nombre,
                        }
                        
                    }, {
                        dataField: "Apellido_edit",
                        editorType: "dxTextBox",
                        label: {
                            text: "Apellido"
                        },
                        editorOptions: {
                            value: data[0].apellido,
                        }
                        
                    }, {
                        dataField: "Correo_edit",
                        editorType: "dxTextBox",
                        label: {
                            text: "Correo"
                        },
                        editorOptions: {
                            value: data[0].email,
                        }
                        

                    }, {
                        dataField: "Rol_edit",
                        editorType: "dxSelectBox",
                        label: {
                            text: "Rol"
                        },
                        editorOptions: {
                            dataSource: roles,
                            valueExpr: 'ID',
                            displayExpr: 'Name',
                            searchEnabled: true,
                            value: parseInt(data[0].rol),
                        }
                    },{
                        dataField: "id_usuario",
                        editorType: "dxTextBox",
                        //visible: false,
                        label: {
                            text: "Id usuario",
                            visible: false
                        },
                        editorOptions: {
                            value: data[0].id_usuario,
                            disabled: true,
                            visible: false
                        },
                        

                    }],

                });

                $('#Modal_Edit').modal('show');
                   
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function editar(){
        id_usuario = $('[name="id_usuario"]').val();
        nombre_edit = $('[name="Nombre_edit"]').val();
        apellido_edit = $('[name="Apellido_edit"]').val();
        correo_edit = $('[name="Correo_edit"]').val();
        rol_edit = $('[name="Rol_edit"]').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Inicio/editar_user')?>",
            dataType : "JSON",
            data : {id_usuario:id_usuario,nombre_edit:nombre_edit,apellido_edit:apellido_edit,correo_edit:correo_edit,rol_edit:rol_edit},
            success: function(data){
                console.log(data);
                if(data.validacion == ''){
                    show_data();
                    document.getElementById('validacion2').innerHTML = '';
                    $("#Modal_Edit").modal('toggle');
                    Swal.fire({
                      icon: 'success',
                      title: 'Modificado',
                      text: 'El usuario fue actualizado con exito!!',
                    });

                }else{
                    document.getElementById('validacion2').innerHTML = data.validacion;
                }
            },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }

        });
    }

    function get_delete(id_usuario){
        $("#formContainer2").dxForm({
            labelLocation: 'top',
            items: [{
                dataField: "id_usuario_delete",
                editorType: "dxTextBox",
                label: {
                    text: "Id usuario",
                    visible: false
                },
                editorOptions: {
                    value: id_usuario,
                    disabled: true,
                    visible: false
                },
                        
            }],

        });
        $('#Modal_delete').modal('show');
    }

    function eliminar(){
        id_usuario = $('[name="id_usuario_delete"]').val();
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Inicio/delete_user')?>",
            dataType : "JSON",
            data : {id_usuario:id_usuario},
            success: function(data){
                show_data();
                $("#Modal_delete").modal('toggle');
                Swal.fire({
                    icon: 'success',
                    title: 'Inactivo',
                    text: 'El usuario fue inativado con exito!!',
                });

            },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }

        });
    }

    function cambio(id_usuario){
      $("#formContainer4").dxForm({
            labelLocation: 'top',
            items: [{
                dataField: "id_usuario_cambio",
                editorType: "dxTextBox",
                label: {
                    text: "Id usuario",
                    visible: false
                },
                editorOptions: {
                    value: id_usuario,
                    disabled: true,
                    visible: false
                },
                        
            }],

        });
        $('#Modal_cambio').modal('show');  
    }

    function cambio_contra(){
        id_usuario = $('[name="id_usuario_cambio"]').val();
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Inicio/cambiar_contra')?>",
            dataType : "JSON",
            data : {id_usuario:id_usuario},
            success: function(data){
                $("#Modal_cambio").modal('toggle');
                Swal.fire({
                    icon: 'success',
                    title: 'Cambio',
                    text: 'La contraseña fue actualizada correctamente!!',
                });
                document.getElementById('registroCorrecto').innerHTML = data;
                $('#registroCorrecto').show();

            },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }

        });
    }
</script>