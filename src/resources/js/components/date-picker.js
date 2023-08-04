import {Datepicker} from 'vanillajs-datepicker';
import ru from 'vanillajs-datepicker/locales/ru';

export function handleDatePicker(datePickerElement) {
    Object.assign(Datepicker.locales, ru);

    const datePicker = new Datepicker(datePickerElement, {
        buttonClass: 'btn',
        autohide: true,
        language: 'ru'
    });
}
