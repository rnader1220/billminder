
const formModal = (function() {
    let current_mode = 'view';
    let context = {};

    const byId = id => document.getElementById(id);
    const byQ = sel => document.querySelector(sel);

    function configure(html = '') {
        document.getElementById('modal_content').innerHTML = html;
        current_mode  = document.querySelector('form[data-mode]').dataset.mode;
        let is_income = document.getElementById('is_income')?.value ?? 0;
        document.getElementById('modal_title').innerHTML = `<h1 class="form-label">Create New ${ is_income ? 'Income' : 'Expense'}</h1>`;

        switch (current_mode) {
            case 'show':
                ctlEdit.classList.remove('hidden');
                ctlDelete.classList.remove('hidden');
                ctlSave.classList.add('hidden');
                ctlCancel.classList.add('hidden');
                ctlClose.classList.remove('hidden');
                setForm(false);
                break
            case 'create':
            case 'edit':       
                ctlEdit.classList.add('hidden');
                ctlDelete.classList.add('hidden');
                ctlSave.classList.remove('hidden');
                ctlCancel.classList.remove('hidden');
                ctlClose.classList.add('hidden');    
                setForm(true);
                break
        }

        editor.init();

    }

    function setForm(isEditable = true) {
        const form = byQ('#modal_content form');
        if (!form) return;

        const elements = form.querySelectorAll('input, select, textarea, button');

        elements.forEach(el => {
            const readOnly = el.dataset.readOnly === 'true';
            if (!readOnly) {
                el.disabled = !isEditable;
            }
        });
    }

    function controls(handlers = {}) {
        byId('control_save').addEventListener('click', current_mode == 'create' ? handlers.onStore : handlers.onUpdate);
        byId('control_cancel')?.addEventListener('click', handlers.onCancel || (() => {}));
        byId('control_close')?.addEventListener('click', handlers.onClose || (() => {}));
        byId('control_delete')?.addEventListener('click', handlers.onDelete || (() => {}));
        byId('control_edit')?.addEventListener('click', handlers.onEdit || (() => {}));
        byId('control_help')?.addEventListener('click', onHelp || (() => {}));
    }

    function initStatic() {
        byId('control_help')?.addEventListener('click', () => {
            byQ('form_help')?.classList.toggle('hidden');
        });
    }

    function show() {
        byId('modal').classList.remove('hidden');
    }

    function close() {
        byId('modal').classList.add('hidden');
        editor.kill();
        byId('modal_content').innerHTML = '';
        current_mode = null;
    }

    return { 
        configure, 
        controls, 
        show,
        close,
    };
})();