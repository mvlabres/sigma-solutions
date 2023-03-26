<?php

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
                                <label>Horário Agendamento</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Chegada</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Início</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fim</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Saída</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Operação</label>
                                <input class="form-control" maxlength="100" placeholder="E-mail" name="email" value="" required>
                            </div>
                            <div class="form-group">
                                <label>Transportadora</label>
                                <input class="form-control" type="password" minlength="6" maxlength="20" id="senha" placeholder="Senha" name="senha" value="" required>
                            </div>
                            <div class="form-group">
                                <label>Cidade</label>
                                <input class="form-control" type="password" minlength="6" maxlength="20" id="senha" placeholder="Senha" name="senha" value="" required>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Shipment ID </label>
                            <input class="form-control telefone" type="text" id="telefone" placeholder="Telefone" name="telefone" value="" >
                        </div>
                        <div class="form-group">
                            <label>Placa do cavalo</label>
                            <input class="form-control telefone" type="text" id="telefone" placeholder="Telefone" name="telefone" value="" >
                        </div>
                        <div class="form-group">
                            <label>Separação/Bin</label>
                            <input class="form-control telefone" type="text" id="telefone" placeholder="Telefone" name="telefone" value="" >
                        </div>
                        <div class="form-group">
                            <label>DO's</label>
                            <input class="form-control celular" type="text" id="celular" placeholder="Celular" name="celular" value="" >
                        </div>
                        <div class="form-group">
                            <label>Nota Fiscal</label>
                            <input class="form-control" type="password" minlength="6" maxlength="20" id="senha" placeholder="Senha" name="senha" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Peso Bruto</label>
                            <input class="form-control" type="password" minlength="6" maxlength="20" id="senha" placeholder="Senha" name="senha" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Paletes</label>
                            <input class="form-control" type="password" minlength="6" maxlength="20" id="senha" placeholder="Senha" name="senha" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Material</label>
                            <input class="form-control" type="password" minlength="6" maxlength="20" id="senha" placeholder="Senha" name="senha" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Observação</label>
                            <input class="form-control" type="password" minlength="6" maxlength="20" id="senha" placeholder="Senha" name="senha" value="" required>
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

