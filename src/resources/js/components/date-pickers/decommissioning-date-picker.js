import {Datepicker} from 'vanillajs-datepicker';
import ru from 'vanillajs-datepicker/locales/ru';

Object.assign(Datepicker.locales, ru);

const decommissioningDatePickerElement = document.getElementById('decommissioningDatePicker');

const decommissioningDatePicker = new Datepicker(decommissioningDatePickerElement, {
    buttonClass: 'btn',
    autohide: true,
    language: 'ru'
});



