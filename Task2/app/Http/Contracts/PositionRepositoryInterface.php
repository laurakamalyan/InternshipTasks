<?php

namespace App\Http\Contracts;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

interface PositionRepositoryInterface {
    public function all(): Collection;

    public function create(array $data): Position;

    public function update(array $data, int $id): bool;

    public function find(int $id): Position|null;

    public function delete(int $id): bool;
}
