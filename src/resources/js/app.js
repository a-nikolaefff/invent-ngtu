import {handleOptionSelector} from "./ui/option-selector.js";

import './bootstrap';
import 'tw-elements/dist/js/tw-elements.umd.min';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './ui/sidebar';

if (document.getElementById('sortableTable')) {
    import ('./ui/sortable-table');
}

const optionSelector1 = document.getElementById('optionSelector1');
if (optionSelector1) {
    handleOptionSelector(optionSelector1);
}

if (document.getElementById('searchForm')) {
    import ('./ui/search-form');
}

if (document.getElementById('departmentAutocomplete')) {
    import ('./pages/department-autocomplete');
}
