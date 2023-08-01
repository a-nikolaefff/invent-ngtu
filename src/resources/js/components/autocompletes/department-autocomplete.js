import autoComplete from "@tarekraafat/autocomplete.js/dist/autoComplete";

const departmentIdElement = document.getElementById('departmentId');
const departmentResetAutocompleteElement = document.getElementById('departmentResetAutocomplete');

if (departmentIdElement.value !== "") {
    departmentResetAutocompleteElement.classList.add('resetAutocomplete__displayed')
}

const departmentAutoComplete = new autoComplete({

    selector: "#departmentAutocomplete",

    placeHolder: "Начните вводить наименование подразделения и выберите из списка",

    data: {
        src: async (query) => {
            try {
                const response = await axios.get('/departments/autocomplete', {
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
        keys: ["name", "short_name"],

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
         ${data.key === 'name' ? 'наим.' : data.key === 'short_name' ? 'к. наим.' : ''}
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
                departmentAutoComplete.input.value = selection.name;
                departmentIdElement.value = selection.id;

                departmentResetAutocompleteElement.classList.add('resetAutocomplete__displayed')
            }
        }
    }
});

departmentResetAutocompleteElement.addEventListener('click', () => {
    const selectionName = document.getElementById('departmentAutocomplete');
    selectionName.value = null;
    const selectionId = document.getElementById('departmentId');
    selectionId.value = null;

    departmentResetAutocompleteElement.classList.remove('resetAutocomplete__displayed')
});






