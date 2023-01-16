<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container'>
            <div class='card'>
                <div class='card-header'>
                    <h1>Clases</h1>
                </div>
                <div class='card-body'>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal_Insert" data-bs-whatever="@mdo" onclick="nueva_class();">
                        <i class="fas fa-plus-square"></i> Nuevo Clase
                    </button><br><br>
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
        <h5 class="modal-title" id="exampleModalLabel">Nuevo clase</h5>
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
        <h5 class="modal-title" id="exampleModalLabel">Editar clase</h5>
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
            url: '<?php echo site_url('Clases/get_clases')?>',
            async : false,
            dataType : 'JSON',
            data : {},
            success : function(data){
                $('#gridContainer').dxDataGrid({
                    dataSource: data,
                    keyExpr: 'id_clase',
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
                      caption: 'Profesor',
                      fixed: true,
                      calculateCellValue(data) {
                        return [data.profe]
                          .join(' ');
                      },
                    },
                    {
                      caption: 'Tipo clases',
                      fixed: true,
                      calculateCellValue(data) {
                        if(data.tipo_clase == 1){
                            tipo_clase = 'Presencial';
                        }else if(data.tipo_clase == 2){
                            tipo_clase = 'Online';
                        }
                        return [tipo_clase]
                          .join(' ');
                      },
                    },
                    {
                      caption: 'Cantidad horas',
                      fixed: true,
                      calculateCellValue(data) {
                        return [data.cantidad]
                          .join(' ');
                      },
                    },
                    {
                      caption: 'Cantidad por hora ($)',
                      fixed: true,
                      calculateCellValue(data) {
                        return ['$ ',parseFloat(data.pagar_hora).toFixed(2)]
                          .join(' ');
                      },
                    },
                    {
                      caption: 'Total de horas ($)',
                      fixed: true,
                      calculateCellValue(data) {
                        return ['$ ',parseFloat(data.total).toFixed(2)]
                          .join(' ');
                      },
                    },
                    {
                        dataField: 'fecha_pagar',
                        label: {
                            text: "Fecha a pagar"
                        },
                        dataType: 'date',
                    },
                    {
                        dataField: 'comentario',
                        label: {
                            text: "Comentario"
                        },
                        dataType: 'string',
                    },
                    {
                      caption: 'Pagada',
                      fixed: true,
                      calculateCellValue(data) {
                        if(data.pagada == 2){
                            pagada = 'No';
                        }else if(data.pagada == 1){
                            pagada = 'Si';
                        }
                        return [pagada]
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
                                get_edit(e.row.data.id_clase);
                            }
                        }]
                    },
                    
                    
                    ], 
                });
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });     
    };

    function nueva_class(){
        const now = new Date();
        data = <?php echo json_encode($usuario);?>;
        roles = [
        {
            ID: 1,
            Name: 'Presencial',
        },{
            ID: 2,
            Name: 'Online',
        },
        ];

        pago = [
        {
            ID: 1,
            Name: 'Si',
        },{
            ID: 2,
            Name: 'No',
        },
        ];
        $("#formContainer").dxForm({
            labelLocation: 'top',
            items: [{
                dataField: "profesor",
                label: {
                    text: "Profesor"
                },
                editorType: "dxSelectBox",
                editorOptions: {
                    dataSource: data,
                    valueExpr: 'id_usuario',
                    displayExpr: 'nombre',
                    searchEnabled: true,
                }
            },
            {
                dataField: "tipo_clase",
                label: {
                    text: "Tipos Clase"
                },
                editorType: "dxSelectBox",
                editorOptions: {
                    dataSource: roles,
                    valueExpr: 'ID',
                    displayExpr: 'Name',
                    searchEnabled: true,
                    value: 1,
                }
            },
            {
                dataField: "cantidad_hora",
                label: {
                    text: "Cantidad de hora"
                },
                editorType: "dxNumberBox",
                editorOptions: {
                    min: 0,
                    showSpinButtons: true,
                    onKeyDown(e) {
                      const { event } = e;
                      const str = event.key || String.fromCharCode(event.which);
                      if (/^[.,e]$/.test(str)) {
                        event.preventDefault();
                      }
                    },
                },
                value: '',
                
            },
            {
                dataField: "cantidad_pagar",
                label: {
                    text: "Cantidad por hora ($)"
                },
                editorType: "dxNumberBox",
                editorOptions: {
                    min: 0,
                    showSpinButtons: true,
                },
                value: '',
                
            }, 
            {
                dataField: "fecha_pagar",
                label: {
                    text: "Fecha pagar"
                },
                editorType: "dxDateBox",
                editorOptions: {
                    pickerType: 'rollers',
                    value: now,
                }

            }, 
            {
                dataField: "comentario",
                label: {
                    text: "Comentario"
                },
                editorType: "dxTextArea",
                        
            },
            {
                dataField: "pagado",
                label: {
                    text: "Pagado"
                },
                editorType: "dxSelectBox",
                editorOptions: {
                    dataSource: pago,
                    valueExpr: 'ID',
                    displayExpr: 'Name',
                    searchEnabled: true,
                    value: 1,
                }
            },],

        });

        $('[name="cantidad_hora"]').val('0');
        $('[name="cantidad_pagar"]').val(0);
        $('[name="comentario"]').val('');
    }

    function insertar(){
        profesor = $('[name="profesor"]').val();
        tipo_clase = $('[name="tipo_clase"]').val();
        cantidad_hora = $('[name="cantidad_hora"]').val();
        cantidad_pagar = $('[name="cantidad_pagar"]').val();
        fecha_pagar = $('[name="fecha_pagar"]').val();
        comentario = $('[name="comentario"]').val();
        pagado = $('[name="pagado"]').val();
        
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Clases/insert_clases')?>",
            dataType : "JSON",
            data : {profesor:profesor,tipo_clase:tipo_clase,cantidad_hora:cantidad_hora,cantidad_pagar:cantidad_pagar,fecha_pagar:fecha_pagar,comentario:comentario,pagado:pagado},
            success: function(data){
                if(data.validacion == ''){
                    show_data();
                    document.getElementById('validacion').innerHTML = '';
                    $("#Modal_Insert").modal('toggle');
                    Swal.fire({
                      icon: 'success',
                      title: 'Ingreso',
                      text: 'La clase se ingresado con exito!!',
                    });

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

    function get_edit(id_clase){
        $.ajax({
            type  : "POST",
            url   : "<?php echo site_url('Clases/get_class')?>",
            dataType : "JSON",
            data : {id_clase:id_clase},
            success : function(data){
                const now = new Date();
                usuarios = <?php echo json_encode($usuario);?>;
                roles = [
                {
                    ID: 1,
                    Name: 'Presencial',
                },{
                    ID: 2,
                    Name: 'Online',
                },
                ];

                pago = [
                {
                    ID: 1,
                    Name: 'Si',
                },{
                    ID: 2,
                    Name: 'No',
                },
                ];
                $("#formContainer2").dxForm({
                    labelLocation: 'top',
                    items: [{
                        dataField: "profesor_edit",
                        label: {
                            text: "Profesor"
                        },
                        editorType: "dxSelectBox",
                        editorOptions: {
                            dataSource: usuarios,
                            valueExpr: 'id_usuario',
                            displayExpr: 'nombre',
                            searchEnabled: true,
                            value: data[0].profesor,
                        }
                    },
                    {
                        dataField: "tipo_clase_edit",
                        label: {
                            text: "Tipos Clase"
                        },
                        editorType: "dxSelectBox",
                        editorOptions: {
                            dataSource: roles,
                            valueExpr: 'ID',
                            displayExpr: 'Name',
                            searchEnabled: true,
                            value: parseInt(data[0].tipo_clase),
                        }
                    },
                    {
                        dataField: "cantidad_hora_edit",
                        label: {
                            text: "Cantidad de hora"
                        },
                        editorType: "dxNumberBox",
                        editorOptions: {
                            min: 0,
                            showSpinButtons: true,
                            value: parseInt(data[0].cantidad),
                            onKeyDown(e) {
                              const { event } = e;
                              const str = event.key || String.fromCharCode(event.which);
                              if (/^[.,e]$/.test(str)) {
                                event.preventDefault();
                              }
                            },
                        },
                        
                    },
                    {
                        dataField: "cantidad_pagar_edit",
                        label: {
                            text: "Cantidad por hora ($)"
                        },
                        editorType: "dxNumberBox",
                        editorOptions: {
                            min: 0,
                             value: parseFloat(data[0].pagar_hora).toFixed(2),
                            showSpinButtons: true,
                        },
                        value: '',
                        
                    }, 
                    {
                        dataField: "fecha_pagar_edit",
                        label: {
                            text: "Fecha pagar"
                        },
                        editorType: "dxDateBox",
                        editorOptions: {
                            pickerType: 'rollers',
                            value: data[0].fecha_pagar,
                        }

                    }, 
                    {
                        dataField: "comentario_edit",
                        label: {
                            text: "Comentario"
                        },
                        editorOptions: {
                            value: data[0].comentario,
                        },
                        editorType: "dxTextArea",
                                
                    },
                    {
                        dataField: "pagado_edit",
                        label: {
                            text: "Pagado"
                        },
                        editorType: "dxSelectBox",
                        editorOptions: {
                            dataSource: pago,
                            valueExpr: 'ID',
                            displayExpr: 'Name',
                            searchEnabled: true,
                            value: parseInt(data[0].pagada),
                        }
                    },
                    {
                        dataField: "id_clase",
                        editorType: "dxTextBox",
                        //visible: false,
                        label: {
                            text: "Id clase",
                            visible: false
                        },
                        editorOptions: {
                            value: data[0].id_clase,
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
        id_clase = $('[name="id_clase"]').val();
        profesor = $('[name="profesor_edit"]').val();
        tipo_clase = $('[name="tipo_clase_edit"]').val();
        cantidad_hora = $('[name="cantidad_hora_edit"]').val();
        cantidad_pagar = $('[name="cantidad_pagar_edit"]').val();
        fecha_pagar = $('[name="fecha_pagar_edit"]').val();
        comentario = $('[name="comentario_edit"]').val();
        pagado = $('[name="pagado_edit"]').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Clases/editar_class')?>",
            dataType : "JSON",
            data : {id_clase:id_clase,profesor:profesor,tipo_clase:tipo_clase,cantidad_hora:cantidad_hora,cantidad_pagar:cantidad_pagar,fecha_pagar:fecha_pagar,comentario:comentario,pagado:pagado},
            success: function(data){
                console.log(data);
                if(data.validacion == ''){
                    show_data();
                    document.getElementById('validacion2').innerHTML = '';
                    $("#Modal_Edit").modal('toggle');
                    Swal.fire({
                      icon: 'success',
                      title: 'Modificado',
                      text: 'La clase fue actualizado con exito!!',
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

</script>