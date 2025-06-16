
import './library/formModal.js';

let current_id = null;
let current_mode = 'view';

const byId = id => document.getElementById(id);
const byQ = sel => document.querySelector(sel);
const byQA = sel => document.querySelectorAll(sel);

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

export function show(id = null) {
    if (id !== null) {
        current_id = id;
    }
    fetch(`/entry/${current_id}`)
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
            injectCycleButton();
            formModal.show();       
        })
        .catch(err => {
            console.error('entries:init error:', err.message);
        });

}

function removeCycleButton() {
    const existing = byId('control_cycle');
    if (existing) {
        existing.remove(); // drop it to avoid duplicate triggers
    }
}

function injectCycleButton() {
    const btnGroup = byId('btn-group-head');
    if (!btnGroup) return;

    removeCycleButton()

    const btn = document.createElement('button');
    btn.id = 'control_cycle'; 
    btn.className = 'btn btn-primary btn-control mr-2';
    btn.innerHTML = `<i class="fas fa-sync-alt mr-1"></i> Cycle`; // FA sync icon

    btn.addEventListener('click', () => {
        cycleEntry(); // <-- your cycle logic function
    });

    btnGroup.insertBefore(btn, btnGroup.firstChild);
}

var set_triggers = function () {
    console.log('triggers here');

    const income_button = byId('new_income');
    income_button.addEventListener('click', () => create( true));

    const expense_button = byId('new_expense');
    expense_button.addEventListener('click', () => create(false));

    const entry_buttons = byQA('.entry-row');
    entry_buttons.forEach(function(button) {
        button.addEventListener('click', function(e) { 
            current_id = e.currentTarget.getAttribute('data-entry-id');
            show();
        });
    });
}

function render(entries) {
    const content = byId('content');
    content.innerHTML = "";

    const gridWrapper = document.createElement('div');
    gridWrapper.classList.add('entry-list');

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
    fetch(`/entry/create?income=${is_income}`)
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
            removeCycleButton();
            formModal.show();
        })
        .catch(err => {
            console.error('entries:init error:', err.message);
        });
}

function setFormControls() {
    formModal.controls({
        onStore: () => store(),
        onUpdate: () => update(),
        onCancel: () => cancel(),
        onEdit: () => edit(),
        onDelete: () => destroy(),
        onClose: () => close()
    });
}

function edit(id = null) {
    if (id !== null) {
        current_id = id;
    }
    fetch(`/entry/${current_id}/edit`)
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
            formModal.configure(data.form);
            setFormControls();
            removeCycleButton();
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
    data._token = byQ('meta[name="csrf-token"]').getAttribute('content');
    data.description = editor.getContent().description;
    fetch('/entry/store', {
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
        formModal.close();     

    })
    .catch(err => {
        console.error('entries:store error:', err.message);
    });
}

function update() {
    const form = byId('entry_form');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    data._token = byQ('meta[name="csrf-token"]').getAttribute('content');
    data.description = editor.getContent().description;
    fetch(`/entry/${current_id}`, {
        method: 'PATCH',
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
        close();     
        show();
    })
    .catch(err => {
        console.error('entries:store error:', err.message);
    });
}

function destroy() {
    if(confirm('Deleting Entry:  Are You Sure?')) {
        fetch(`/entry/${current_id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': byQ('meta[name="csrf-token"]').getAttribute('content'),
            }
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
            close();     
            init();
            // refresh list
        })
        .catch(err => {
            console.error('entries:store error:', err.message);
        });

    }
}

function close() {
    removeCycleButton();
    formModal.close();
}

function cancel() {
    close();
    if(current_id == null) {
        init();
    } else {
        show();     
    }

}
