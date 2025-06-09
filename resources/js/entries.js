
import './library/formModal.js';

let current_id = null;
let current_mode = 'view';

const byId = id => document.getElementById(id);
const byQ = sel => document.querySelector(sel);

export function init() {
    fetch('/entry/list')
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Unexpected server error');
                });
            }
               
            return response.json()
        })
        .then(data => {
            render(data.list)
        })
        .catch(err => {
            console.error('entries:init error:', err.message);
        });
}


var set_triggers = function () {
    console.log('triggers here');

    const income_button = document.getElementById('new_income');
    income_button.addEventListener('click', () => create( true));

    const expense_button = document.getElementById('new_expense');
    expense_button.addEventListener('click', () => create(false));


    /*     $("#content #return-button").off()
            .on('click', subjects.load)
            .attr("disabled", false); */

/*         $("#content #export-button").off()
            .on('click', segment_pdf_export)
            .attr("disabled", false);  */       

/*         $("#content .primary-object").off().on('click', function () {
            lesson_id = $(this).data('id');
            if(lesson_id == 0) {
                form_new();
            } else {
                form_show();
            }
        }); */
}


function render(entries) {
    const content = document.getElementById('content');
    content.innerHTML = "";

    const gridWrapper = document.createElement('div');
    gridWrapper.classList.add('grid', 'grid-cols-2', 'gap-4', 'w-full');

    entries.forEach(item => {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = item;

        // This allows multiple root elements in one entry string
        Array.from(wrapper.childNodes).forEach(child => {
        if (child.nodeType === Node.ELEMENT_NODE) {
            gridWrapper.appendChild(child);
        }
        });
    });

    content.appendChild(gridWrapper);
    set_triggers();
}

function create(is_income) {
    current_id = null;
    fetch('/entry/create?income=' + is_income)
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Unexpected server error');
                });
            }
               
            return response.json()
        })
        .then(data => {
            formModal.configure(data.form);
            setFormControls();
            formModal.show();
        })
        .catch(err => {
            console.error('entries:init error:', err.message);
        });
}


function setFormControls() {
    formModal.controls({
    onStore: store,
    onUpdate: update,
    onCancel: cancel,
    onEdit: edit,
    onDelete: destroy
    });
}

function edit(id) {
    current_id = id;
    fetch('/entry/'+id+'/edit')
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Unexpected server error');
                });
            }
               
            return response.json()
        })
        .then(data => {
            formModal.configure(data.form);
            setFormControls();

            ClassToday.TinyMCE.init();      
            formModal.show();                        
        })
        .catch(err => {
            console.error('entries:init error:', err.message);
        });
}

function store() {
    const form = byId('entry_form');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data._token = bQ('meta[name="csrf-token"]').getAttribute('content');
    Object.assign(data, editor.getContent());

    fetch('/entry', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }) 
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Unexpected server error');
                });
            }
            return response.json()
        })
        .then(data => {
            editor.kill()
            formModal.close();     

        })
        .catch(err => {
            console.error('entries:store error:', err.message);
        });
}

function update() {}

function destroy() {}
function cancel() {}
