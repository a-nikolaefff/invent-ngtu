const buildingIdSelect = document.getElementById('building_id');
const floorSelect = document.getElementById('floor');
buildingIdSelect.addEventListener("change", async function () {
    event.preventDefault();
    const optionData = this.value;
    const response = await axios.get('/buildings/floor-amount', {
        params: {
            id: optionData
        }
    });
    const floorAmount = response.data;

    while (floorSelect.firstChild) {
        floorSelect.removeChild(floorSelect.firstChild);
    }

    for (let i = 0; i <= floorAmount; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.text = i === 0 ? 'цокольный' : i;
        floorSelect.appendChild(option);
    }
});
