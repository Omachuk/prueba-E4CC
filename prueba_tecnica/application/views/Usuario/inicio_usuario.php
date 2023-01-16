<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container'>
            <div class='card'>
                <div class='card-header'>
                        <h1>¡Bienvenido!</h1>
                </div>
                <div class='card-body'>
                    <p>Nombre: <?php echo ($_SESSION['login']['nombre']); ?></p>
                    <p>Perfil: <?php echo ($_SESSION['login']['rol']); ?></p>
                    <p>Correo: <?php echo ($_SESSION['login']['usuario']); ?></p>
                    <nav class="float-right">
                        <div class="col-sm-12">
                            <div class="alert alert-success" id="registroCorrecto">
                                <h2>Clases registradas</h2>
                            </div>
                        </div>
                    </nav>
                    <div id="gridContainer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    show_data();
    function show_data(){
        $.ajax({
            type  : 'POST',
            url: '<?php echo site_url('Clases/clases_usuario')?>',
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
                    
                    ], 
                });
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });     
    };
</script>