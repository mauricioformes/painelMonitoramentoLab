<!-- MODAL REGISTRO -->
<div class="modal fade" tabindex="-1" id="modalRegistro">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Registro</h5>

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
            </div>

            <div class="modal-body">
                <div class="flex-row mb-0">
                    <div class="flex-column">
                        <form class="form" autocomplete="off">
                            <div class="form-group row mb-2">
                                <div class="flex-column">
                                    <!-- REGISTRO CID -->
                                    <label for="registroCid" class="required fw-bold fs-6 mb-2">CID</label>
                                    <select id="registroCid" class="form-select" data-control="select2"  data-dropdown-parent="#modalRegistro"  data-placeholder="Selecione um CID">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <div class="flex-column">
                                    <!-- REGISTRO PROTOCOLO -->
                                    <label for="registroCodigoProtocolo" class="required fw-bold fs-6 mb-2">Protocolo</label>
                                    <select id="registroCodigoProtocolo" class="form-select" data-control="select2"  data-dropdown-parent="#modalRegistro"  data-placeholder="Selecione um protocolo">
                                    <option value=""></option>
                                    <option value="1">Dor Torácica</option>
                                    <option value="2">AVC</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarRegistro">Salvar</button>
                <button type="button" class="btn btn-warning" id="btnAtualizarRegistro">Atualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- MAIN -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Cids por Protocolo<?=$data['SSC']['CODIGO']?></h3>

                            <div class="card-toolbar">
                                <button type="button" id="btnNovoRegistro" class="btn btn-sm btn-primary">
                                    Novo
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="flex-row mb-2">
                                <div class="flex-column">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 gs-7 gy-7 gx-7">
                                            <thead>
                                                <tr class="fw-bolder fs-6 text-gray-800">
                                                    <th>CID</th>
                                                    <th>Protocolo</th>
                                                    <th>Tipo Paciente</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <!-- TABLE -->
                                            <tbody id="tableCidPorProtocolo">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var Inside = function() {
        var buscarCidsPorProtocolo = () => {
            $.ajax({
                type:'GET',
                url: 'ajaxBuscarCidsAltaProtocolo',
                success: function(data){
                    let registros = JSON.parse(data);
                    
                    let output = '';
                    registros.forEach((registro, index)=>{
                        let tipoPaciente    = registro['TIPO_PACIENTE'] != null ? registro['TIPO_PACIENTE'] : '';
                        let codigoCid       = registro['COD_CID'] != null ? registro['COD_CID'] : '';
                        let codigoProtocolo = registro['TIPO_PROTOCOLO'] != null ? registro['TIPO_PROTOCOLO'] : '';
                        
                        output += '<tr>';
                            output += '<td>' + tipoPaciente + '</td>';
                            output += '<td>' + codigoCid + '</td>';
                            output += '<td>' + codigoProtocolo + '</td>';
                            output += '<td>';
                                output += '<a href="#"><i class="fa fa-edit visualizarRegistro" data-cid="' + codigoCid + '" data-protocolo="' + codigoProtocolo + '"></i></a>';
                            output += '</td>';
                        output += '</tr>';
                    });
                    
                    $('#tableCidPorProtocolo').html(output);
                }
            });
        };

        var handleNovoRegistro = () => {
            $(document).on('click', '#btnNovoRegistro', () => {
                $('#btnAtualizarRegistro').hide();
                $('#modalRegistro').modal('show');
            });
        };

        var handleBuscaCid = () => {
            $("#registroCid").select2({

                ajax: { 
                    url: "ajaxBuscarCids",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                    },
                    minimumInputLength: 2,
            });
        };

        var handleSalvarRegistro = () => {
            $(document).on('click', '#btnSalvarRegistro', () => {
                salvarRegistro();
            });
        };

        var salvarRegistro = () =>{
            let codigoCid = $('#registroCid').val();
            let codigoProtocolo = $('#registroCodigoProtocolo').val();

            if(codigoCid != null && codigoProtocolo != null){
                $.ajax({
                    type:'POST',
                    url: 'ajaxSalvarCidAltaProtocolo',
                    data: {
                        "codigoCid" : codigoCid,
                        "codigoProtocolo": codigoProtocolo
                    },
                    success: function(data){
                        if(data == true){

                        }
                        else{
                            Swal.fire({
                                html: 'Erro ao salvar o registro,<br>tente novamente mais tarde!',
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                }
                            });            
                        }
                    }
                });
            }
            else{
                Swal.fire({
                    html: 'Por favor, existem dados faltando,<br> informe-os e tente novamente!',
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
            }
            
        };

        var handleVisualizarRegistro = () => {
            $(document).on('click', '.visualizarRegistro', function() {
                let codigoCid = $(this).data('cid');
                let codigoProtocolo = $(this).data('protocolo');

                buscarDescricaoCid(codigoCid, codigoProtocolo);
            });
        };

        var buscarDescricaoCid = (codigoCid, codigoProtocolo) => {
            $.ajax({
                type:'POST',
                url: 'ajaxBuscarDescricaoCid',
                data: {
                    'codigoCid' : codigoCid
                },
                success: (data) => {
                    let descricaoCid = JSON.parse(data);

                    let cidOption = new Option(descricaoCid, codigoCid, true, true);

                    $('#registroCid').append(cidOption).trigger('change');
                    $('#registroCodigoProtocolo').val(codigoProtocolo).trigger('change');
                    
                    $('#btnSalvarRegistro').hide();
                    $('#modalRegistro').modal('show');
                }
            })
        };

        return {
            init: function() {
                buscarCidsPorProtocolo();
                handleNovoRegistro();
                handleBuscaCid();
                handleSalvarRegistro();
                handleVisualizarRegistro();
            }
        };
    }();
</script>