<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Gera orçamento Excel</h3>
                    <div class="card-toolbar">
                    </div>
                </div>
                <div class="card-body">
                    <form class="form" method="GET" action="buscaOrcamento">
                        <div class="form-group row mb-5">
                            <div class="col">
                                <label for="data" class="required form-label">Data</label>
                                <input class="form-control" id="data" name="data" inputmode="text">
                            </div>

                            <div class="col">
                                <label for="pacReg" class="form-label">Registro do Paciente</label>
                                <input class="form-control" type="number" id="pacReg" name="pagReg">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style="text-align: center;">
                                <button type="button" class="btn btn-success btn-lg" id="btnGerarExcel">
                                    Gerar Excel
                                </button>
                            </div>
                        </div>
                    </form>

                    <div id="tableOrcamento" style="display:none;">

                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<script>
    var Inside = function() {
        var gerarTabelaOrcamento = function(orcamento) {
            retorno = "";

            // TABLE MATERIAIS
            retorno += "<table id='tableMateriais' class='table2excel'>";
            retorno += "<thead>";
            retorno += "<tr>";
            retorno += "<td>MATERIAL</td>";
            retorno += "<td>FORNECEDOR</td>";
            retorno += "<td>REFERENCIA</td>";
            retorno += "<td>TUSS</td>";
            retorno += "<td>ANVISA</td>";
            retorno += "<td>QTDE</td>";
            retorno += "<td>VALOR_UNITARIO</td>";
            retorno += "</tr>";
            retorno += "</thead>";
            retorno += "<tbody>";

            orcamento.forEach((item) => {
                retorno += "<tr>";
                retorno += "<td>" + ((item.DESCRICAO_MATERIAL !== null) ? item.DESCRICAO_MATERIAL : '') + "</td>";
                retorno += "<td>" + ((item.FORNECEDOR !== null) ? item.FORNECEDOR : '') + "</td>";
                retorno += "<td>" + ((item.REFERENCIA !== null) ? item.REFERENCIA : '') + "</td>";
                retorno += "<td>" + ((item.SMK_COD_TUSS !== null) ? item.SMK_COD_TUSS : '') + "</td>";
                retorno += "<td>" + ((item.ANVISA !== null) ? item.ANVISA : '') + "</td>";
                retorno += "<td>" + ((item.QTDE !== null) ? item.QTDE : '') + "</td>";
                retorno += "<td>" + ((item.VALOR_UNIT !== null) ? item.VALOR_UNIT : '') + "</td>";
                retorno += "</tr>";
            });

            retorno += "</tbody>";
            retorno += "</table>";

            // if linha ==1

            //TABLE AGENDA
            retorno += "<table id='tableAgenda' class='table2excel'>";
            retorno += "<thead>";
            retorno += "<tr>";
            retorno += "<td>DATA</td>";
            retorno += "<td>NOME</td>";
            retorno += "<td>CODIGO_PACIENTE</td>";
            retorno += "<td>PROTOCOLO_CONVENIO</td>";
            retorno += "<td>GUIA</td>";
            retorno += "<td>DATA_INTERNACAO</td>";
            retorno += "<td>CARTERINHA</td>";
            retorno += "<td>PRESTADOR</td>";
            retorno += "<td>CONVENIO</td>";
            retorno += "<td>MEDICO</td>";
            retorno += "</tr>";
            retorno += "</thead>";
            retorno += "<tbody>";

            orcamento.forEach((item) => {
                if (item.LINHA_BUSCA == '1') {
                    retorno += "<tr>";
                    retorno += "<td>" + ((item.DATA_AGENDA !== null) ? item.DATA_AGENDA : '') + "</td>";
                    retorno += "<td>" + ((item.NOME_CLIENTE !== null) ? item.NOME_CLIENTE : '') + "</td>";
                    retorno += "<td>" + ((item.CAP_PAC_REG !== null) ? item.CAP_PAC_REG : '') + "</td>";
                    retorno += "<td>" + ((item.PROTOCOLO_CONVENIO !== null) ? item.PROTOCOLO_CONVENIO : '') + "</td>";
                    retorno += "<td>" + ((item.GUIA !== null) ? item.GUIA : '') + "</td>";
                    retorno += "<td>" + ((item.DATA_INTERNACAO !== null) ? item.DATA_INTERNACAO : '') + "</td>";
                    retorno += "<td>" + ((item.CARTERINHA !== null) ? item.CARTERINHA : '') + "</td>";
                    retorno += "<td>" + ((item.PRESTADOR !== null) ? item.PRESTADOR : '') + "</td>";
                    retorno += "<td>" + ((item.CONVENIO !== null) ? item.CONVENIO : '') + "</td>";
                    retorno += "<td>" + ((item.MEDICO !== null) ? item.MEDICO : '') + "</td>";
                    retorno += "</tr>";
                }
            });

            retorno += "</tbody>";
            retorno += "</table>";

            $('#tableOrcamento').html(retorno);

        }

        var generateTable = function(id, wb, sheetName) {
            const tdeTable = document.getElementById(id);
            const oo = generateArray(tdeTable);
            const ranges = oo[1];
            const data = oo[0];
            ws = sheet_from_array_of_arrays(data);
            ws['!merges'] = ranges;
            wb.SheetNames.push(sheetName);
            wb.Sheets[sheetName] = ws;
            return wb;
        }

        var gerarExcel = function() {
            let wb = new Workbook();
            wb = generateTable("tableMateriais", wb, "MATERIAIS");
            const wbout = XLSX.write(wb, {
                bookType: 'xlsx',
                bookSST: false,
                type: 'binary',
                cellStyles: true
            });
            saveAs(new Blob([s2ab(wbout)], {
                type: "application/octet-stream"
            }), "relatorioOrcamento" + ".xlsx");
        }

        var handleGerarExcel = function() {

            $(document).on('click', '#btnGerarExcel', function() {
                let data = $('#data').val();
                let pacReg = $('#pacReg').val();

                if (data != '') {
                    $.ajax({
                        type: 'GET',
                        url: 'buscaOrcamento',
                        data: {
                            'data': data,
                            'pacReg': pacReg
                        },
                        success: function(data) {
                            orcamento = JSON.parse(data);
                            gerarTabelaOrcamento(orcamento);
                            gerarExcel();
                        }
                    });
                } else {
                    Swal.fire({
                        text: "Informe a data!",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-warning"
                        }
                    });
                }

            });
        }

        var handleLayout = function() {
            Inputmask({
                "mask": "99/99/9999"
            }).mask("#data");
        }

        return {
            //main function to initiate the module
            init: function() {
                handleGerarExcel();
                handleLayout();
            }
        };

    }();
</script>