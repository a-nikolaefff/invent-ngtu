import './bootstrap';
import 'tw-elements/dist/js/tw-elements.umd.min';
import Alpine from 'alpinejs';
import {handleOptionSelector} from "./components/option-selector.js";
import {handleDatePicker} from "./components/date-picker.js";

window.Alpine = Alpine;
Alpine.start();

// Import component modules if they exist

import './components/sidebar';

const modules = [
    { id: 'departmentAutocomplete', module: './components/autocompletes/department-autocomplete.js' },
    { id: 'roomAutocomplete', module: './components/autocompletes/room-autocomplete.js' },
    { id: 'equipmentAutocomplete', module: './components/autocompletes/equipment-autocomplete' },
    { id: 'sortableTable', module: './components/sortable-table' },
    { id: 'searchForm', module: './components/search-form' },
    { id: 'building_id', module: './pages/rooms' },
    { id: 'decommissioned', module: './pages/equipment' }
];
modules.forEach(({ id, module }) => {
    if (document.getElementById(id)) {
        import(module);
    }
});

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


