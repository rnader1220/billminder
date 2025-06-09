import './bootstrap';

import { library, dom } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/pro-solid-svg-icons'
import {init as initEntries} from './entries'
import {init as initCategories} from './categories'
import {init as initAccounts} from './accounts'
import './library/editor.js';

// Add the icons you want
library.add(fas)

function setMainMenu() {
    const entries = document.getElementById('mainmenu_entries');
    const categories = document.getElementById('mainmenu_categories');
    const accounts = document.getElementById('mainmenu_accounts');

    if (entries) {
        entries.addEventListener('click', () => initEntries());
    }
    if (categories) {
        categories.addEventListener('click', () => initCategories());
    }
    if (accounts) {
        accounts.addEventListener('click', () => initAccounts());
    }

    initEntries(); // Initial load
}

document.addEventListener('DOMContentLoaded', setMainMenu);

dom.watch()
