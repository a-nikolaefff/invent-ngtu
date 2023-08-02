import {handleOptionSelector} from "./components/option-selector.js";

import './bootstrap';
import 'tw-elements/dist/js/tw-elements.umd.min';



import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './components/sidebar';

if (document.getElementById('sortableTable')) {
    import ('./components/sortable-table');
}

if (document.getElementById('searchForm')) {
    import ('./components/search-form');
}

const optionSelector1 = document.getElementById('optionSelector1');
if (optionSelector1) {
    handleOptionSelector(optionSelector1);
}

const optionSelector2 = document.getElementById('optionSelector2');
if (optionSelector2) {
    handleOptionSelector(optionSelector2);
}

const optionSelector3 = document.getElementById('optionSelector3');
if (optionSelector3) {
    handleOptionSelector(optionSelector3);
}

if (document.getElementById('departmentAutocomplete')) {
    import ('./components/autocompletes/department-autocomplete.js');
}

if (document.getElementById('roomAutocomplete')) {
    import ('./components/autocompletes/room-autocomplete.js');
}

if (document.getElementById('acquisitionDatePicker')) {
    import ('./components/date-pickers/acquisition-date-picker.js');
}
if (document.getElementById('decommissioningDatePicker')) {
    import ('./components/date-pickers/decommissioning-date-picker.js');
}

if (document.getElementById('building_id')) {
    import ('./pages/rooms');
}

if (document.getElementById('decommissioned')) {
    import ('./pages/equipment');
}
