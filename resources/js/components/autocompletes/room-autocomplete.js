import autoComplete from "@tarekraafat/autocomplete.js/dist/autoComplete";

const roomIdElement = document.getElementById('roomId');
const roomResetAutocompleteElement = document.getElementById('roomResetAutocomplete');

if (roomIdElement.value !== "") {
    roomResetAutocompleteElement.classList.add('resetAutocomplete__displayed')
}

const roomAutoComplete = new autoComplete({

    selector: "#roomAutocomplete",

    placeHolder: "Начните вводить номер помещения и выберите из списка",

    data: {
        src: async (query) => {
            try {
                const response = await axios.get('/rooms/autocomplete', {
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
                roomAutoComplete.input.value = selection.number;
                roomIdElement.value = selection.id;

                roomResetAutocompleteElement.classList.add('resetAutocomplete__displayed')
            }
        }
    }
});

roomResetAutocompleteElement.addEventListener('click', () => {
    const selectionName = document.getElementById('roomAutocomplete');
    selectionName.value = null;
    const selectionId = document.getElementById('roomId');
    selectionId.value = null;

    roomResetAutocompleteElement.classList.remove('resetAutocomplete__displayed')
});






