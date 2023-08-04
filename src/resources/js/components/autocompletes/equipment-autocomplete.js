import autoComplete from "@tarekraafat/autocomplete.js/dist/autoComplete";

const equipmentIdElement = document.getElementById('equipmentId');
const equipmentResetAutocompleteElement = document.getElementById('equipmentResetAutocomplete');

if (equipmentIdElement.value !== "") {
    equipmentResetAutocompleteElement.classList.add('resetAutocomplete__displayed')
}

const equipmentAutoComplete = new autoComplete({

    selector: "#equipmentAutocomplete",

    placeHolder: "Начните вводить инвентарный номер оборудования и выберите из списка",

    data: {
        src: async (query) => {
            try {
                const response = await axios.get('/equipment/autocomplete', {
                    params: {
                        search: query
                    }
                });
                const data = response.data;
                return data;
            } catch (error) {
                return [];
            }
        },

        // Object keys by which the search will be performed
        keys: ["number"],

        // Filter duplicates in case of multiple data keys usage
        filter: (list) => {
            return Array.from(
                new Set(list.map((value) => value.match))
            ).map((food) => {
                return list.find((value) => value.match === food);
            });
        },
    },

    resultItem: {
        element: (item, data) => {
            // Modify Results Item Style
            item.style = "display: flex; justify-content: space-between;";
            // Modify Results Item Content
            item.innerHTML = `
      <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
        ${data.match}
      </span>
      <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.9);">
         номер
      </span>`;
        },
        highlight: false
    },

    resultsList: {
        element: (list, data) => {
            const info = document.createElement("p");
            if (data.results.length > 0) {
                info.innerHTML = `Показаны <strong>${data.results.length}</strong> результатов из <strong>${data.matches.length}</strong>`;
            } else {
                info.innerHTML = `Найдено <strong>${data.matches.length}</strong> подходящих результатов для <strong>"${data.query}"</strong>`;
            }
            list.prepend(info);
        },
        noResults: true,
        maxResults: 20,
        tabSelect: true
    },
    events: {
        input: {
            selection: (event) => {
                const selection = event.detail.selection.value;
                equipmentAutoComplete.input.value = selection.number;
                equipmentIdElement.value = selection.id;

                equipmentResetAutocompleteElement.classList.add('resetAutocomplete__displayed')
            }
        }
    }
});

equipmentResetAutocompleteElement.addEventListener('click', () => {
    const selectionName = document.getElementById('equipmentAutocomplete');
    selectionName.value = null;
    const selectionId = document.getElementById('equipmentId');
    selectionId.value = null;

    equipmentResetAutocompleteElement.classList.remove('resetAutocomplete__displayed')
});






