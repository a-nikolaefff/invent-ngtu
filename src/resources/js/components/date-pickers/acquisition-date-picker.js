import {Datepicker} from 'vanillajs-datepicker';
import ru from 'vanillajs-datepicker/locales/ru';

Object.assign(Datepicker.locales, ru);

const acquisitionDatePickerElement = document.getElementById('acquisitionDatePicker');

const acquisitionDatePicker = new Datepicker(acquisitionDatePickerElement, {
    buttonClass: 'btn',
    autohide: true,
    language: 'ru'
});



