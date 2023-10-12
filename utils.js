let selectedElement;

let activeScheduleColumnsSearch = [];
let inactiveScheduleColumnsSearch = [];

let activeColumnsTemp = [];
let inactiveColumnsTemp = [];

const dt = new DataTransfer();

const PROGRESS_TIME = 60000;

let automatedTimeIsOn = true;

let idInterval;

function dateTimeMask(value) {
    let x = value.replace(/\D+/g, '').match(/(\d{0,2})(\d{0,2})(\d{0,4})(\d{0,2})(\d{0,2})(\d{0,2})/);
    return !x[2] ? x[1] : `${x[1]}/${x[2]}` + (!x[3] ? `` : `/${x[3]}` + ` `) + (!x[4] ? `` : x[4]) + (!x[5] ? `` : `:${x[5]}`) + (!x[6] ? `` : `:${x[6]}`);   
}

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

const errorReportValidate = (action) => {

    if(action != 'edit'){
        const attachment = document.getElementById('attachment').value;
        
        if(!attachment) {
            alert('Favor anexar uma evidência!');
            return false;
        }
    }    

    return validateEmail();
}

const validateEmail = () =>{

    const mail = document.getElementById('email').value;
    const feedback = document.getElementById('mail-feedback');
    const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    
    if(mail.match(mailformat)){
        feedback.style.display = 'none';
        return true;

    } else {
        feedback.style.display = 'block';
        return false;
    }
}

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

const editOperationType = (id, name, operationSource) => {

    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('operationSource').value = operationSource;
    document.getElementById('action').value = 'edit';
    document.getElementById('title').innerHTML = 'Tipo de Operação - Editar';
}

const editOperationSource = (id, name) => {

    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('action').value = 'edit';
    document.getElementById('title').innerHTML = 'Natureza da Operação - Editar';
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

    document.getElementById('btn-salvar').disabled = true;

    const operationExit = document.getElementById('operationExit').value;

    const arrival = document.getElementById('arrival').value;

    if(!arrival && !operationExit) {
        document.getElementById('scheduleStatus').value = 'Agendado';
        return true;
    }

    const operationStart = document.getElementById('operationStart').value;

    if(!operationStart && !operationExit) {
        document.getElementById('scheduleStatus').value = 'Aguardando';
        return true;
    }

    const operationDone = document.getElementById('operationDone').value;

    if(!operationDone && !operationExit) {
        document.getElementById('scheduleStatus').value = 'Em operação';
        return true;
    }

    if(!operationExit) {
        document.getElementById('scheduleStatus').value = 'Fim de operação';
        return true;
    }
    else{

        const result = validationFields();

        if(result){
            document.getElementById('scheduleStatus').value = 'Liberado';
            return result;
        }

        return result;
    }
}

const validationFields = () => {

    const fields = [
        {'name':'operationScheduleTime', 'label': 'Agendamento'},
        {'name':'arrival', 'label': 'Chegada'},
        {'name':'operationStart', 'label': 'Início'},
        {'name':'operationDone', 'label': 'Fim'},
        {'name':'operationExit', 'label': 'Saída'},
        {'name':'driverName', 'label': 'Nome Motorista'},
        {'name':'cpf', 'label': 'CPF'},
        {'name':'operationType', 'label': 'Operação'},
        {'name':'shippingCompany', 'label': 'Transportadora'},
        {'name':'city', 'label': 'Cidade'},
        {'name':'binSeparation', 'label': 'Separação BIN'},
        {'name':'shipmentId', 'label': 'Shipment ID'},
        {'name':'dock', 'label': 'Doca'},
        {'name':'truckType', 'label': 'Tipo Veículo'},
        {'name':'licenceTruck', 'label': 'Placa Cavalo'},
        {'name':'licenceTrailer', 'label': 'Placa carreta'},
        {'name':'licenceTrailer2', 'label': 'Placa Carreta 2'},
        {'name':'dos', 'label': 'DOs'},
        {'name':'invoice', 'label': 'NF'},
        {'name':'grossWeight', 'label': 'Peso Final'},
        {'name':'pallets', 'label': 'Paletes'},
        {'name':'material', 'label': 'Material'},
        {'name':'observation', 'label': 'Observação'}
    ];

    let isValid = true;

    for (const field of fields) {

        const element = document.getElementById(field.name).value.toString();

        if(element) continue;

        isValid = false;
        document.getElementById('btn-salvar').disabled = false;

        customAlert('alert-danger', `Favor preencher o campo ${field.label}`);
        break;
    }

    return isValid;
}

const dateTimeHandleBlur = (element) => {

    const dateTimeValue = element.value;

    if(element.value == '') {
        setTimeout(() => {
            element.innerHTML = '';
            element.value = '';
        }, 10);
    }else{
        setTimeout(() => {
            element.innerHTML = dateTimeValue;
            element.value = dateTimeValue;
            dateTimeHandleKeyUp(element);
        }, 10);
    }
}

const dateTimeHandleKeyUp = (element) => {

    let dateTimeValue = element.value;

    dateTimeValue = dateTimeValue.replace(/[a-zA-Z]/g, '');

    dateTimeValue = dateTimeMask(dateTimeValue);

    element.innerHTML = dateTimeValue;
    element.value = dateTimeValue;
}

const handleShowMenu = () => {
    document.getElementById('menu-nav-bar').style.display = 'block';
}

const handleHideMenu = () => {
    document.getElementById('menu-nav-bar').style.display = 'none';
}

const readColumns = () => {

    document.querySelectorAll('div[name="active-column-name"]').forEach(element => {
        activeColumnsTemp.push(element);
    });

    document.querySelectorAll('div[name="inactive-column-name"]').forEach(element => {
        inactiveColumnsTemp.push(element);
    });


    activeScheduleColumnsSearch = [...document.getElementsByClassName('active-column')];
    inactiveScheduleColumnsSearch = [...document.getElementsByClassName('inactive-column')];

}

const inactiveColumn = () => {
    activeScheduleColumnsSearch.forEach((element, index) => {

        if(element.checked){
            element.checked = false;
            inactiveScheduleColumnsSearch.push(element);
            activeScheduleColumnsSearch.splice(index, 1);

            const divId = element.id.replace('order', 'div');

            const elementToMove = document.getElementById(divId);

            document.getElementById('active-columns').removeChild(elementToMove);
            document.getElementById('inactive-columns').appendChild(elementToMove);
        }
    });
}

const activeColumn = () => {
    inactiveScheduleColumnsSearch.forEach((element, index) => {
        if(element.checked){
            element.checked = false;
            activeScheduleColumnsSearch.push(element);
            inactiveScheduleColumnsSearch.splice(index, 1);

            const divId = element.id.replace('order', 'div');

            const elementToMove = document.getElementById(divId);

            document.getElementById('inactive-columns').removeChild(elementToMove);
            document.getElementById('active-columns').appendChild(elementToMove);
        }
    });
}

const handleSelect = (radioElement) => {
    if(!radioElement.checked) return;

    const allColumns = activeScheduleColumnsSearch.concat(inactiveScheduleColumnsSearch);

    allColumns.forEach(element => {
        if(element.id !== radioElement.id){
            element.checked = false;
        }
    });
}

const restoreColumns = () => {

    let box = document.querySelector('#active-columns');
    let child = box.lastElementChild

    while (child) {
        box.removeChild(child);
        child = box.lastElementChild;
    }

    box = document.querySelector('#inactive-columns');
    child = box.lastElementChild

    while (child) {
        box.removeChild(child);
        child = box.lastElementChild;
    }

    box = document.querySelector('#active-columns');

    activeColumnsTemp.forEach(element => {
        box.append(element);  
    });

    box = document.querySelector('#inactive-columns');

    inactiveColumnsTemp.forEach(element => {
        box.append(element);  
    });

}

const moveColumn = (direction) => {

    const columns = document.querySelector('#active-columns').children;

    for(let x = 0; x < columns.length; x++ ){

        const element = columns[x];

        const divElement = element.children[0];
        const columnElement = divElement.children[0];

        if(!columnElement.checked) continue;

        if(columnElement.checked){

            if(x === columns.length - 1 && direction === 'down') break;

            if(x === 0 && direction === 'up') break;

            const container = document.querySelector('div[name="active-columns"]');
            const neighborElement = (direction === 'up') ? columns[x - 1 ] : columns[x + 1 ];

            if(direction === 'up') container.insertBefore(element, neighborElement);
            else container.insertBefore(neighborElement, element);
            break;
        }
    }
}

const saveOrder = () => {

    activeScheduleColumnsSearch.forEach(element => {
        element.checked = true;
    });

    document.getElementById('order-form').submit();
}

const handleChangeFiles = () => {

    const attachment = document.querySelector('#attachment');

    Array.from(attachment.files).forEach(file => {
        const parentSpan = document.createElement("span");
        parentSpan.classList.add("file-block");

        const childSpan = document.createElement("span");
        childSpan.classList.add("name");
        childSpan.innerHTML = file.name;

        const fileDelete = document.createElement("span");
        fileDelete.classList.add("file-delete");
        fileDelete.innerHTML = '+';
        fileDelete.setAttribute("onclick","removeFile(this, false)");

        parentSpan.appendChild(fileDelete);
        parentSpan.appendChild(childSpan);
        document.querySelector('#files-names').appendChild(parentSpan);
    });


    for (let file of attachment.files) {
		dt.items.add(file);
	}

    attachment.files = dt.files;
}

const handleReportChangeFiles = () => {

    const attachment = document.querySelector('#attachment');

    Array.from(attachment.files).forEach(file => {

        const size = file.size / 1000000;

        if(size > 5){
            alert('São permitidos apenas anexos com até 5MB!');
        }else{
            const parentSpan = document.createElement("span");
            parentSpan.classList.add("file-block");
    
            const childSpan = document.createElement("span");
            childSpan.classList.add("name");
            childSpan.innerHTML = file.name;
    
            const fileDelete = document.createElement("span");
            fileDelete.classList.add("file-delete");
            fileDelete.innerHTML = '+';
            fileDelete.setAttribute("onclick","removeFile(this, false)");
    
            parentSpan.appendChild(fileDelete);
            parentSpan.appendChild(childSpan);
    
            const filesNames = document.querySelector('#files-names');
    
            while (filesNames.firstChild) {
                filesNames.removeChild(filesNames.firstChild);
            }
    
            filesNames.appendChild(parentSpan);
        }
    });
}

const removeFile = (element, removeToEdit) => {

    console.log(element);
    if(removeToEdit) addToRemove(element.id);
    const sibling = element.nextSibling;
    const parent = element.parentElement;

    let name = sibling.innerHTML;


    while (parent.firstChild) {
        parent.firstChild.remove()
    }

    for(let i = 0; i < dt.items.length; i++){

        if(name === dt.items[i].getAsFile().name){
            dt.items.remove(i);
            continue;
        }
    }

    document.getElementById('attachment').files = dt.files;

}

const addToRemove = (attachmentId) => {

    const elements = document.getElementById('filesToRemove');

    let ids = elements.value;

    if(elements.value) ids += `,${attachmentId}`;
    else ids = attachmentId;

    elements.value = ids;
}

const customAlert = (type, message) => {

    let alert = document.getElementById('fixed-alert');

    if(alert) document.body.removeChild(alert);

    const div = document.createElement("div");
    div.classList.add('alert');
    div.classList.add(type);
    div.classList.add('alert-dismissible');
    div.classList.add('show');
    div.setAttribute('role', 'alert');
    div.setAttribute('id', 'fixed-alert');

    div.innerHTML = message;

    const btn = document.createElement("button");
    btn.classList.add('close');
    btn.setAttribute('data-dismiss', 'alert');
    btn.setAttribute('aria-label', 'Close');
    btn.setAttribute('type', 'button');

    const span = document.createElement("span");
    span.setAttribute('aria-hidden', true);
    span.innerHTML = '&times;';

    btn.appendChild(span);
    div.appendChild(btn);

    document.body.appendChild(div);

    setTimeout(() => {

        alert = document.getElementById('fixed-alert');
        if(alert) document.body.removeChild(alert);

    }, 5000);
}

const HandleChangeAutomatedTimeSwitch = () => {
    const automatedTimeSwitch = document.getElementById('automatedTimeSwitch');

    if(!automatedTimeSwitch.checked) automatedTimeIsOn = false;
    else {
        automatedTimeIsOn = true;
        progressTimer();
    }
}

const progressTimer = () => {

    let time = PROGRESS_TIME;
    idInterval = setInterval(() => {

        if(!automatedTimeIsOn) clearInterval(idInterval);

        time = time - 10;
        document.getElementById('panel-progress').value = time;

        if(time === 0) document.getElementById('panel-form').submit();
    }, 10);
}

const navigateToSearch = (scheduleStatus) => {

    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    window.location =  `index.php?conteudo=searchSchedule.php&status=${scheduleStatus}&startDate=${startDate}&endDate=${endDate}`;
}

const backHistory = () => {
    history.back()
}