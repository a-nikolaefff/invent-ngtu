@props(['geometry' => null])

<div class="content-block">
    <h2 class="h2">
        Геометрические данные
    </h2>

    @if($geometry !== null)
        <table class="standard-table standard-table_left-header">
            <tbody>
            <tr>
                <th scope="row" class="w-2/12">Координаты стартовой точки в системе координат модели здания, мм:</th>
                <td>
                    {{ 'X: ' . $geometry['anchor_point']['x'] . ', Y: ' . $geometry['anchor_point']['y'] . ', Z: ' . $geometry['anchor_point']['z'] }}
                </td>
            </tr>
            <tr>
                <th scope="row" class="w-2/12">Координаты основания помещения относительно координаты стартовой точки, мм:</th>
                <td>
                    @foreach($geometry['base_points'] as $index => $point)
                        <div>{{ 'Точка ' . ($index + 1) . ': X: ' . $point['x'] . ', Y: ' . $point['y'] }}</div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th scope="row" class="w-2/12">Высота, мм:</th>
                <td>{{ $geometry['height'] }}</td>
            </tr>
            </tbody>
        </table>
    @else
        <p>Геометрические данные не указаны.</p>
    @endif
</div>
