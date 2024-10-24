import "@melloware/coloris/dist/coloris.css";
import Coloris from "@melloware/coloris";

const colorPicker = document.getElementById('color-picker')
if (colorPicker) {
    Coloris.init();
    Coloris({
        el: "#color-picker",
        alpha: false,
        swatches: [
            '#264653',
            '#2a9d8f',
            '#e9c46a',
            'rgb(244,162,97)',
            '#e76f51',
            '#d62828',
            'navy',
            '#07b',
            '#0096c7',
            '#00b4d880',
            'rgba(0,119,182,0.8)'
        ],

    });
    console.log('fdf')
}
