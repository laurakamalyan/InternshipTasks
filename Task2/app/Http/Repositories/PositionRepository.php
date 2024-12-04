<?php

namespace App\Http\Repositories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Contracts\PositionRepositoryInterface;

class PositionRepository implements PositionRepositoryInterface {
    /**
     * @param Position $position
     */
    public function __construct(protected Position $position) {}

    /**
     * @return Collection
     */
    public function all(): Collection {
        return $this->position->with('specifications')->get();
    }

    /**
     * @param array $data
     * @return Position
     */
    public function create(array $data): Position {
        return $this->position->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool {
        return $this->position->where('id', $id)->update($data);
    }

    /**
     * @param int $id
     * @return Position|null
     */
    public function find(int $id): Position|null {
        return $this->position->where('id', $id)->first();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->position->destroy($id);
    }
}
