import {addUrlParams} from '../utils/util';

const optionSelector = document.getElementById('optionSelector');
const select = optionSelector.querySelector('select');
const options = select.querySelectorAll('option');
const parameterName = optionSelector.dataset.value;
const urlParams = new URLSearchParams(window.location.search);
const allOptionsSelection = 'allOptionsSelection';

/**
 * Add links to options
 * */
select.addEventListener("change", function () {
    event.preventDefault();
    let optionData = this.value;
    urlParams.delete(parameterName);
    if (optionData !== allOptionsSelection) {
        urlParams.append(parameterName, optionData);
    }
    if (urlParams.get('page') !== null) {
        urlParams.delete('page')
    }
    const url = window.location.href;
    window.location.href = addUrlParams(url, urlParams);
});


/**
 * Highlight active option
 * */
options.forEach(option => {
    const optionData = option.value;
    if (urlParams.get(parameterName) === optionData ||
        urlParams.get(parameterName) === null && optionData === allOptionsSelection) {
        option.setAttribute("selected", "");
    }
});





