<x-layouts.app :centered="false" :title="'Просмотр 3D модели здания ' . $building->name">
    <div class="page-header">
        <h1 class="h1">
            {{ 'Просмотр 3D модели здания ' . $building->name }}
        </h1>

        <div id="vue_container">
            <model-components
                model-path="{{ '/storage/models/buildings/' . $building->model }}"
                model-scale="{{ $building->model_scale }}"
            >
            </model-components>
        </div>
    </div>
</x-layouts.app>
