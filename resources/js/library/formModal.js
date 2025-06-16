window.formModal = (function() {
    let current_mode = 'view';
    let context = {};

    const byId = id => document.getElementById(id);
    const byQ = sel => document.querySelector(sel);
    const byQA = sel => document.querySelectorAll(sel);

    function configure(html = '') {
        document.getElementById('modal_content').innerHTML = html;
        current_mode  = document.querySelector('form[data-mode]').dataset.mode;
        let is_income = document.getElementById('is_income')?.value ?? 0;
        document.getElementById('modal_title').innerHTML = `<h1 class="form-label">Create New ${ is_income ? 'Income' : 'Expense'}</h1>`;

       byId('control_help')?.addEventListener('click', () => {toggleHelp()});


        switch (current_mode) {
            case 'show':
                byId('control_edit')?.classList.remove('hidden');
                byId('control_delete')?.classList.remove('hidden');
                byId('control_save')?.classList.add('hidden');
                byId('control_cancel')?.classList.add('hidden');
                byId('control_close')?.classList.remove('hidden');
                setForm(false);
                break
            case 'create':
            case 'edit':       
                byId('control_edit')?.classList.add('hidden');
                byId('control_delete')?.classList.add('hidden');
                byId('control_save')?.classList.remove('hidden');
                byId('control_cancel')?.classList.remove('hidden');
                byId('control_close')?.classList.add('hidden');    
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

        reset_triggers('control_save');
        reset_triggers('control_cancel');
        reset_triggers('control_delete');
        reset_triggers('control_edit');
        reset_triggers('control_close');

        byId('control_save')?.addEventListener('click', current_mode == 'create' ? handlers.onStore : handlers.onUpdate);
        byId('control_cancel')?.addEventListener('click', handlers.onCancel || (() => {}));
        byId('control_delete')?.addEventListener('click', handlers.onDelete || (() => {}));
        byId('control_edit')?.addEventListener('click', handlers.onEdit || (() => {}));
        byId('control_close')?.addEventListener('click', handlers.onClose || (() => {close()}));
    }

    function reset_triggers(button_id) {
        var el = byId(button_id);
        var elClone = el.cloneNode(true);
        el.parentNode.replaceChild(elClone, el);
    }

    function toggleHelp() {
        const elements = byQA('.form-help');
        elements.forEach(el => {
            if(el.classList.contains('hidden')) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
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
