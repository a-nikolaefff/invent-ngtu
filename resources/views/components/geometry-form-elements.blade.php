@props(['geometry' => [
    'anchor_point' => [
        'x' => null,
        'y' => null,
        'z' => null,
     ],
     'base_points' => [],
     'height' => null,
  ]
])

<div class="pt-4">
    <h3 class="text-lg font-medium text-gray-900 pb-2">Геометрические данные</h3>

    <div class="mt-2 max-w-4xl">
        <div class="flex mb-2">
            <x-forms.input-label for="anchor_point"
                                 class="mr-3"
                                 value="Координаты стартовой точки в системе координат модели здания, в мм"/>
            <x-tooltip text="Стартовая точка определяет месторасположение в пространстве модели"/>
        </div>

        <div class="flex gap-4">
            <x-forms.text-input id="anchor_point"
                                name="geometry[anchor_point][x]"
                                type="number"
                                placeholder="x"
                                class="w-1/3 md:w-auto"
                                :value="old('geometry.anchor_point.x', $geometry['anchor_point']['x'])"
            />
            <x-forms.text-input id="anchor_point"
                                name="geometry[anchor_point][y]"
                                type="number"
                                placeholder="y"
                                class="w-1/3 md:w-auto"
                                :value="old('geometry.anchor_point.y', $geometry['anchor_point']['y'])"
            />
            <x-forms.text-input id="anchor_point"
                                name="geometry[anchor_point][z]"
                                type="number"
                                placeholder="z"
                                class="w-1/3 md:w-auto"
                                :value="old('geometry.anchor_point.z', $geometry['anchor_point']['z'])"
            />
        </div>
        <x-forms.input-error :messages="$errors->get('geometry.anchor_point')"/>
    </div>

    <div id="geometry-points-wrapper" class="pt-3">
        <div class="flex mb-2">
            <x-forms.input-label for="geometryPoints"
                                 class="mr-3"
                                 value="Координаты основания помещения относительно координаты стартовой точки, в мм"
            />
            <x-tooltip text="Координаты стартовой точки всегда 0,0. Минимальное число точек включая стартовую 3."/>
        </div>

        <div id="geometry-points" class="flex flex-col gap-3">
            <div class="flex gap-4">
                <input type="number" value="0" name="geometry[base_points][0][x]" readonly
                       class="w-5/12 sm:w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
                <input type="number" value="0" name="geometry[base_points][0][y]" readonly
                       class="w-5/12 sm:w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
                <div class="w-2/12 sm:w-auto"></div>
            </div>
            @foreach($geometry['base_points'] as $point)
                @if ($loop->first)
                    @continue
                @endif
                    <div class="flex gap-4 point-entry" data-index="{{ $loop->iteration }}">
                        <input type="number" value="{{ $point['x'] }}" name="{{ 'geometry[base_points][' . $loop->iteration . '][x]' }}"
                               class="w-5/12 sm:w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
                        <input type="number" value="{{ $point['y'] }}" name="{{ 'geometry[base_points][' . $loop->iteration . '][y]' }}"
                               class="w-5/12 sm:w-auto border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"/>
                        <button class="remove-point-btn w-2/12 sm:w-auto text-red-500 hover:text-red-700" type="button">
                            <svg class="h-6 w-6 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="7" x2="20" y2="7" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                        </button>
                    </div>
            @endforeach
        </div>
        <div class="pt-2">
            <button type="button"
                    id="add-point-btn"
                    class="mt-2 text-xs font-medium w-full sm:w-fit uppercase bg-emerald-600 text-white px-3 py-2 rounded
                     ease-in-out hover:bg-emerald-500 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                Добавить координату основания
            </button>
        </div>

        <x-forms.input-error :messages="$errors->get('geometry.base_points')"/>
    </div>

    <div class="pt-3 max-w-4xl">
        <x-forms.input-label for="height" value="Высота в мм" class="mb-2"/>
        <x-forms.text-input id="height" name="geometry[height]" type="number"
                            placeholder="Высота в мм"
                            class="w-full sm:w-auto"
                            :value="old('geometry.height', $geometry['height'])"/>
        <x-forms.input-error :messages="$errors->get('geometry.height')"/>
    </div>

</div>
