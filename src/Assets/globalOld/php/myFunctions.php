<?php
//funcoes php

function areas($titulo, $id, $name, $oConBD, $visao, $pathlib, $idTpUsr, $obrigatorio, $aplicacao, $tipo_credenciado = "", $fisio = "N")
{
    $cSQL_cred =  "SELECT TO_CHAR(COD_AREA) CODIGO, DESCRICAO_AREA
      FROM areas
     WHERE cod_area IN (SELECT cod_area FROM locais WHERE tipo_leito <> 4)
     ORDER BY 2";

    $oRS_cred = OCIParse($oConBD, $cSQL_cred);
    OCIExecute($oRS_cred);

?>

    <div class="form-group">
        <label class="col-md-3 col-md-offset-1 control-label"><?php echo $titulo; ?>
            <?php echo $obrigatorio == 'S' ? '<span class="asterisk"><small>*</small></span>' : ''; ?></label>
        <div class="col-md-3">
            <select name='<?php echo $name; ?>[]' id='<?php echo $id; ?>' class="form-control chosen-select" data-placeholder="Selecione" required multiple>
                <option value="">Selecione</option>
                <?php
                $i = 0;
                while (OCIFetch($oRS_cred)) {
                    echo '<option value="' . OCIResult($oRS_cred, 'CODIGO') . '">' . OCIResult($oRS_cred, 'DESCRICAO_AREA') . '</option>';
                }

                $i++;

                ?>
            </select>
        </div>




    </div>
    <!-- 

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3" id="dados_medico">

        </div>
    </div> -->

<?php
}



?>