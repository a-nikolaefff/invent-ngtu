const pointsContainer = document.getElementById('geometry-points');
const addPointBtn = document.getElementById('add-point-btn');
const removePointsButtons =document.querySelectorAll('.remove-point-btn')

removePointsButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
        const pointDiv = btn.closest('.point-entry');
        removePoint(pointDiv);
    });
});

if (addPointBtn) {
    addPointBtn.addEventListener('click', function (event) {
        event.preventDefault();
        addPoint();
    });
}

let pointCount = removePointsButtons.length + 1

function addPoint() {
    const pointIndex = pointCount + 1;
    pointCount++;

    const pointDiv = document.createElement('div');
    pointDiv.classList.add('point-entry');
    const displayedIndex = pointIndex + 1;
    pointDiv.innerHTML = `
                              <div class="flex gap-4">
                    <input type="number" placeholder="x" name="geometry[base_points][${pointIndex}][x]"
                    class="w-5/12 sm:w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
                    <input type="number" placeholder="y" name="geometry[base_points][${pointIndex}][y]"
                    class="w-5/12 sm:w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
             <button class="remove-point-btn w-2/12 sm:w-auto text-red-500 hover:text-red-700" type="button">
                 <svg class="h-6 w-6 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="7" x2="20" y2="7" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
               </button>

                </div>
            `;

    pointsContainer.appendChild(pointDiv);

    const removeBtn = pointDiv.querySelector('.remove-point-btn');
    removeBtn.addEventListener('click', function () {
        removePoint(pointDiv);
    });
}

function removePoint(pointDiv) {
    pointDiv.remove();
}
