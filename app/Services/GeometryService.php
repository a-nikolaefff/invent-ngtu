<?php
declare(strict_types=1);

namespace App\Services;

use App\Validator\GeometryValidator;

class GeometryService
{
    public function __construct(
        private readonly GeometryValidator $validator)
    {
    }

    public function processGeometry(array $geometry): ?array
    {
        if ($this->validator->isAnchorPointSet($geometry['anchor_point'] ?? [])) {
            $geometry['base_points'] = array_values($geometry['base_points']);
            return $geometry;
        }
        return null;
    }
}
