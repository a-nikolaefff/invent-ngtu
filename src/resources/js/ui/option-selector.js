import {addUrlParams} from '../utils/util';

const optionSelector = document.getElementById('optionSelector');

const urlParams = new URLSearchParams(window.location.search);
const options = optionSelector.querySelectorAll('a');
const parameterName = optionSelector.dataset.value;
const allOptionsSelection = 'allOptionsSelection';

/**
 * Add links to options
 * */
options.forEach(option => {
    option.addEventListener('click', event => {
        event.preventDefault();
        let optionData = option.dataset.value;
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
});

/**
 * Highlight active option
 * */
options.forEach(option => {
    const optionData = option.dataset.value;
    const optionButton = option.querySelector('button');
    if (urlParams.get(parameterName) === optionData ||
        urlParams.get(parameterName) === null && optionData === allOptionsSelection) {
        optionButton.classList.remove('text-pink-600');
        optionButton.classList.add('text-white', 'bg-pink-600');
    }
});





