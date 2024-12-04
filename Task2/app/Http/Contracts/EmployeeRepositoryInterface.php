<?php

namespace App\Http\Contracts;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface
{
    public function all(Request $request): Collection;

    public function create(array $data): Employee;

    public function update(array $data, int $id): bool;

    public function find(int $id): Employee|null;

    public function delete(int $id): bool;
}
