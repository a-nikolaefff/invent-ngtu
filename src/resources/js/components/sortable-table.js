const tableHeaders = document.querySelectorAll('#sortableTable th a');
const urlParams = new URLSearchParams(window.location.search);
const sortKey = urlParams.get('sort');
const currentDirection = urlParams.get('direction');

tableHeaders.forEach(header => {
    const columnName = header.getAttribute('href').split('sort=')[1].split('&')[0];
    /**
     * Add an arrow to the header that is sorted by
     ** */
    if (columnName === sortKey) {
        const arrow = document.createElement('i');
        arrow.classList.add('bx');
        const arrowType = currentDirection === 'asc' ? 'bxs-up-arrow' : 'bxs-down-arrow';
        arrow.classList.add(arrowType);
        header.appendChild(arrow);
    }
    /**
     * Add links for sorting to headers
     ** */
    header.addEventListener('click', event => {
        event.preventDefault();
        const url = window.location.href;

        let direction = 'asc';
        if (urlParams.get('sort') === columnName && currentDirection === 'asc') {
            direction = 'desc';
        }
        if (urlParams.get('page') !== null) {
            urlParams.set('page', '1');
        }
        urlParams.set('direction', direction);
        urlParams.set('sort', columnName);
        window.location.href = `${url.split('?')[0]}?${urlParams.toString()}`;
    });
});




