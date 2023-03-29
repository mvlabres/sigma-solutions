<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../controller/shippingCompanyController.php');

$shippingCompanyController = new ShippingCompanyController($MySQLi);

$shippingCompanys = $shippingCompanyController->findByClient($customerName);

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Novo Agendamento</h1>
    </div>                
</div>
<div class="row">
    <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form-new-user" method="post" action="#" name="valida">
                            <input type="hidden" name="id" value="">
                            <div class="form-group">
                                <label>Status</label>
                                <input type='text' class="invisible-disabeld-field warning-text-field form-control" value="AGUARDANDO" disabled/>
                            </div>
                            <div class="form-group">
                                <label>Horário Carregamento</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="operationScheduleTime" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chegada</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="arrival"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Início</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="operationStart" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fim</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="operationDone"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Saída</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="operationExit" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Operação</label>
                                <select name="operationType" class="form-control" aria-label="Default select example">
                                    <option value="">Selecione...</option>
                                    <!-- <?php
                                    foreach ($userTypeValues as $userTypeValue) {

                                        $selected = null;
                                        if($usuario->getTipo() == $userTypeValue['key']) $selected = 'selected';

                                        echo '<option value="'.$userTypeValue['key'].'" '.$selected.' >'.$userTypeValue['value'].'</option>';
                                    }
                                    ?> -->
                                  </select>
                            </div>
                            <div class="form-group">
                                <label>Transportadora</label>
                                <select name="shippingCompany" class="form-control" aria-label="Default select example">
                                    <option value="">Selecione...</option>
                                    <?php

                                    print_r($shippingCompanys);

                                    if(count($shippingCompanys) > 0){
                                        foreach ($shippingCompanys as $shippingCompany) {
    
                                            $selected = null;
                                            //if($usuario->getTipo() == $userTypeValue['key']) $selected = 'selected';
    
                                            echo '<option value="'.$shippingCompany->getNome().'" '.$selected.' >'.$shippingCompany->getNome().'</option>';
                                        }
                                    }
                                    ?>
                                  </select>
                            </div>
                            <div class="form-group">
                                <label>Cidade</label>
                                <input class="form-control" type="text" name="city">
                            </div>
                            <div class="form-group">
                                <label>Separação/Bin</label>
                                <input class="form-control" type="text" name="binSeparation">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Shipment ID </label>
                            <input class="form-control" type="text" name="shipmentId" >
                        </div>
                        <div class="form-group">
                            <label>Tipo de Veículo</label>
                            <select name="truckType" class="form-control placeholder" aria-label="Default select example">
                                <option value="">Selecione...</option>
                                <!-- <?php
                                foreach ($userTypeValues as $userTypeValue) {

                                    $selected = null;
                                    if($usuario->getTipo() == $userTypeValue['key']) $selected = 'selected';

                                    echo '<option value="'.$userTypeValue['key'].'" '.$selected.' >'.$userTypeValue['value'].'</option>';
                                }
                                ?> -->
                              </select>
                        </div>
                        <div class="form-group">
                            <label>Placa do cavalo</label>
                            <input class="form-control" type="text"  name="licenceTruck">
                        </div>
                        <div class="form-group">
                            <label>DO's</label>
                            <input class="form-control" type="text" name="dos" >
                        </div>
                        <div class="form-group">
                            <label>Nota Fiscal</label>
                            <input class="form-control" type="text" name="invoice">
                        </div>
                        <div class="form-group">
                            <label>Peso Bruto</label>
                            <input class="form-control" type="text" name="grossWeight">
                        </div>
                        <div class="form-group">
                            <label>Paletes</label>
                            <input class="form-control" type="number" name="pallets">
                        </div>
                        <div class="form-group">
                            <label>Material</label>
                            <textarea class="form-control" type="text" name="material"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Observação</label>
                            <textarea class="form-control" type="text" name="observation"></textarea>
                        </div>
                    </div>   
                </div>
                <button id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>
                <button type="reset" class="btn btn-danger">Cancelar</button> 
            </div>
        </div>
    </div>
</div>

<script>

    
</script>

