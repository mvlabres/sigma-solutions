let selectedElement;

let activeScheduleColumnsSearch = [];
let inactiveScheduleColumnsSearch = [];

let activeColumnsTemp = [];
let inactiveColumnsTemp = [];

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

// const handleChangeFiles = () => {

//     const filesNameContainer = document.querySelector('#files-name'); 
//     const files = Array.from( document.querySelector('#files').files );

//     files.forEach(file => {
//         const element = file.name;

//         const div = document.createElement("div");
        
//         const spanTrash = document.createElement("span");
//         spanTrash.classList.add("fa");
//         spanTrash.classList.add("fa-trash-o");
//         spanTrash.classList.add("text-danger");
//         spanTrash.setAttribute("onclick","removeFile(this)");

//         const linkTrash = document.createElement("span");
//         linkTrash.appendChild(spanTrash);
        
//         const linkdownload = document.createElement("a");
        
//         const input = document.createElement("input");

//         input.name = `file[]`;
//         input.type = 'file';
//         input.files[0] = file;
//         input.classList.add('file-und');

//         linkdownload.innerHTML = element;

//         linkdownload.appendChild(input);

//         div.appendChild(linkTrash);
//         div.appendChild(linkdownload);

//         filesNameContainer.appendChild(div);
//     });  
    
//     document.querySelector('#files').files = null;
// }




const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file

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
        fileDelete.setAttribute("onclick","removeFile(this)");

        parentSpan.appendChild(fileDelete);
        parentSpan.appendChild(childSpan);
        document.querySelector('#files-names').appendChild(parentSpan);
    });


    for (let file of attachment.files) {
		dt.items.add(file);
	}

    attachment.files = dt.files;
}

const removeFile = (element) => {
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