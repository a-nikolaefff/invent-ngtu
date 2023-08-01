const decommissionedCheckbox = document.getElementById("decommissioned");
const decommissioningDatePickerWrapper = document.getElementById("decommissioningDatePickerWrapper");
const decommissioningReasonWrapper = document.getElementById("decommissioningReasonWrapper");
const decommissioningDatePicker = document.getElementById('decommissioningDatePicker');
const decommissioningReason = document.getElementById('decommissioning_reason');
decommissionedCheckbox.addEventListener("change", function() {
    if (this.checked) {
        decommissioningDatePickerWrapper.classList.remove('hidden');
        decommissioningReasonWrapper.classList.remove('hidden');
    } else {
        decommissioningDatePickerWrapper.classList.add('hidden');
        decommissioningReasonWrapper.classList.add('hidden');
        decommissioningDatePicker.value = '';
        decommissioningReason.value = '';
    }
});

