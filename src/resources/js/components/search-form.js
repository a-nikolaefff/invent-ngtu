import {addUrlParams} from "../utils/util";

const searchForm = document.getElementById('searchForm');

const searchInput = searchForm.querySelector('input[name="search"]');
const resetButton = searchForm.querySelector('#resetButton');
const urlParams = new URLSearchParams(window.location.search);

/**
 * Show a reset button if there is a "search" parameter in the query string
 * */
function updateResetButtonVisibility() {
    resetButton.style.display = urlParams.get('search') ? 'inline-block' : 'none';
}

updateResetButtonVisibility();

/**
 * Send a search request if the input is not empty.
 * */
searchForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const keyWord = searchInput.value;
    if (keyWord.trim() !== "") {
        const newSearchParams = new URLSearchParams();
        urlParams.forEach((value, key) => {
            if (key !== 'search' && key !== 'page') {
                newSearchParams.append(key, value);
            }
        });
        newSearchParams.set('search', keyWord);
        const url = new URL(window.location.href);
        url.search = newSearchParams.toString();
        window.location.href = url.toString();
    }
});

/**
 * Reset search results
 * */
resetButton.addEventListener('click', function () {
    searchInput.value = '';
    if (urlParams.get('search')) {
        urlParams.delete('search');
        const url = window.location.href;
        window.location.href = addUrlParams(url, urlParams);
    }
});







