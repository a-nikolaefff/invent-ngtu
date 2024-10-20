import './bootstrap';
import 'tw-elements/dist/js/tw-elements.umd.min';
import Alpine from 'alpinejs';
import {handleOptionSelector} from "./components/option-selector.js";
import {handleDatePicker} from "./components/date-picker.js";

window.Alpine = Alpine;
Alpine.start();

// Import component modules if they exist

import './components/sidebar';

if (document.getElementById('departmentAutocomplete')) {
    import ('./components/autocompletes/department-autocomplete.js');
}

if (document.getElementById('roomAutocomplete')) {
    import ('./components/autocompletes/room-autocomplete.js');
}

if (document.getElementById('equipmentAutocomplete')) {
    import ('./components/autocompletes/equipment-autocomplete');
}

if (document.getElementById('sortableTable')) {
    import ('./components/sortable-table');
}

if (document.getElementById('searchForm')) {
    import ('./components/search-form');
}

if (document.getElementById('building_id')) {
    import ('./pages/rooms');
}

if (document.getElementById('decommissioned')) {
    import ('./pages/equipment');
}

// Handle reusable components

function handleElementsById(ids, handler) {
    ids.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            handler(element);
        }
    });
}

const optionSelectorIds = ['optionSelector1', 'optionSelector2', 'optionSelector3'];
handleElementsById(optionSelectorIds, handleOptionSelector);

const datePickersIds = ['datePicker1', 'datePicker2'];
handleElementsById(datePickersIds, handleDatePicker);

import ('./3d/model.js');


