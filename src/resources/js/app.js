import './bootstrap';
import 'tw-elements/dist/js/tw-elements.umd.min';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import './ui/sidebar';

if (document.getElementById('sortableTable')) {
    import ('./ui/sortable-table');
}

if (document.getElementById('optionSelector')) {
    import ('./ui/option-selector');
}

if (document.getElementById('searchForm')) {
    import ('./ui/search-form');
}
