jQuery(function($){
    var bindDatePicker = function() {
         $(".date").datetimepicker({
         format:'DD/MM/YYYY hh:mm:ss',
             icons: {
                 time: "fa fa-clock-o",
                 date: "fa fa-calendar",
                 up: "fa fa-arrow-up",
                 down: "fa fa-arrow-down"
             }
         }).find('input:first').on("blur",function () {
             var date = parseDate($(this).val());
 
             if (! isValidDate(date)) {
                 date = moment().format('YYYY-MM-DD');
             }
 
             $(this).val(date);
         });
     }
    
    var isValidDate = function(value, format) {
         format = format || false;
         if (format) {
             value = parseDate(value);
         }
 
         var timestamp = Date.parse(value);
 
         return isNaN(timestamp) == false;
    }
    
    var parseDate = function(value) {
         var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
         if (m)
             value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);
 
         return value;
    }
    
    bindDatePicker();

    
});

const editTruckType = (id, description) => {

    document.getElementById('id').value = id;
    document.getElementById('description').value = description;
    document.getElementById('action').value = 'edit';
    document.getElementById('title').innerHTML = 'Tipo de Veículo - Editar';
}

const resetNewTruck = () =>{
    document.getElementById('title').innerHTML = 'Tipo de Veículo - Novo';
    document.getElementById('id').value = null;
    document.getElementById('action').value = 'save';
}

const editOperationType = (id, name) => {

    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('action').value = 'edit';
    document.getElementById('title').innerHTML = 'Tipo de Operação - Editar';
}

const resetOperationType = () =>{
    document.getElementById('title').innerHTML = 'Tipo de Operação - Novo';
    document.getElementById('id').value = null;
    document.getElementById('action').value = 'save';
}

const editShippingCompany = (id, name) => {

    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('action').value = 'edit';
    document.getElementById('title').innerHTML = 'Transportadora - Editar';
}

const resetShippingCompany = () =>{
    document.getElementById('title').innerHTML = 'Transportadora - Novo';
    document.getElementById('id').value = null;
    document.getElementById('action').value = 'save';
}

const validateStatus = () => {

    const operationScheduleTime = document.getElementById('operationScheduleTime').value;
    const arrival = document.getElementById('arrival').value;

    if(!arrival) {
        document.getElementById('scheduleStatus').value = 'Agendado';
        return true;
    }

    const operationStart = document.getElementById('operationStart').value;

    if(!operationStart) {
        document.getElementById('scheduleStatus').value = 'Aguardando';
        return true;
    }

    const operationDone = document.getElementById('operationDone').value;

    if(!operationDone) {
        document.getElementById('scheduleStatus').value = 'Em operação';
        return true;
    }

    const operationExit = document.getElementById('operationExit').value;

    if(!operationExit) {
        document.getElementById('scheduleStatus').value = 'Fim de operação';
        return true;
    }

    document.getElementById('scheduleStatus').value = 'Liberado';
    return true;
}

const dateTimeHandleBlur = (element) => {
    if(element.value == '') {
        setTimeout(() => {
            element.innerHTML = '';
            element.value = '';
        }, 10);
    }
}