<?php

declare(strict_types=1);

namespace App\Validator;

use Illuminate\Validation\Validator;

class GeometryValidator
{
    public function applyRules(Validator $validator, array $anchorPoint): void
    {
        $validator->setCustomMessages($this->messages());

        $validator->sometimes('geometry.anchor_point', ['array', 'size:3'], fn() => true);
        $validator->sometimes('geometry.anchor_point.*', ['nullable', 'numeric'], fn() => true);

        $isAnchorPointSet = $this->isAnchorPointSet($anchorPoint);

        $validator->sometimes('geometry.base_points', ['required', 'array', 'min:3'], fn($input) => $isAnchorPointSet);
        $validator->sometimes('geometry.base_points.*.x', ['numeric'], fn($input) => $isAnchorPointSet);
        $validator->sometimes('geometry.base_points.*.y', ['numeric'], fn($input) => $isAnchorPointSet);
        $validator->sometimes('geometry.base_points', [$this->uniqueBasePointsRule()], fn($input) => $isAnchorPointSet);

        $validator->sometimes('geometry.height', ['required', 'numeric', 'min:1'], fn($input) => $isAnchorPointSet);
    }


    private function uniqueBasePointsRule(): \Closure
    {
        return function ($attribute, $value, $fail) {
            $points = $value;
            $uniquePoints = [];

            foreach ($points as $point) {
                $coordinate = $point['x'] . ',' . $point['y'];
                if (in_array($coordinate, $uniquePoints)) {
                    return $fail('Координаты точек основания должны быть уникальными.');
                }

                $uniquePoints[] = $coordinate;
            }
        };
    }


    public function isAnchorPointSet(array $anchorPoint): bool
    {
        return is_array($anchorPoint) && array_filter($anchorPoint, fn($val) => !is_null($val));
    }

    /**
     * Сообщения об ошибках валидации.
     */
    private function messages(): array
    {
        return [
            'geometry.anchor_point.required' => 'Точка привязки обязательна.',
            'geometry.anchor_point.size' => 'Точка привязки должна содержать три значения (x, y, z).',
            'geometry.anchor_point.*.numeric' => 'Каждая координата точки привязки должна быть числом.',

            'geometry.base_points.required' => 'Необходимо указать точки основания.',
            'geometry.base_points.min' => 'Основание помещения должно содержать как минимум три точки.',
            'geometry.base_points.*.x.numeric' => 'Координата x должна быть числом.',
            'geometry.base_points.*.y.numeric' => 'Координата y должна быть числом.',

            'geometry.height.required' => 'Необходимо указать высоту.',
            'geometry.height.numeric' => 'Высота должна быть числом.',
            'geometry.height.min' => 'Высота должна быть положительным числом.',
        ];
    }
}
