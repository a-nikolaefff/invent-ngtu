import {addUrlParams} from '../utils/util';

export function handleOptionSelector(optionSelector) {
    const select = optionSelector.querySelector('select');
    const options = select.querySelectorAll('option');
    const parameterName = optionSelector.dataset.value;
    const urlParams = new URLSearchParams(window.location.search);
    const allOptionsSelection = 'allOptionsSelection';

    /**
     * Add event listener to each select element
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
        if (parameterName === 'building_id') {
            urlParams.delete('floor')
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
}









