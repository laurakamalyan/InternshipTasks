<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Contracts\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface {
    /**
     * @param Employee $employee
     */
    public function __construct(protected Employee $employee) {}

    /**
     * @return Collection
     */
    public function all(Request $request): Collection {
        if ($request->get('position') == 'qa') {
            return $this->employee->
            with('companies')->
            withWhereHas('positions', function ($query) {
                $query->where('position_name', 'qa');
            })->get();
        } else {
            return $this->employee->
            with('positions')->
            with('companies')->
            get();
        }
    }

    /**
     * @param array $data
     * @return Employee
     */
    public function create(array $data): Employee {
        return $this->employee->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool {
        return $this->employee->where('id', $id)->update($data);
    }

    /**
     * @param int $id
     * @return Employee|null
     */
    public function find(int $id): Employee|null {
        return $this->employee->where('id', $id)->first();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->employee->destroy($id);
    }

    /**
     * @return Collection
     */
    public function show() : Collection {
        return $this->employee->
        with('companies')->
        withWhereHas('positions', function ($query) {
            $query->where('position_name', 'qa');
        })->get();
    }
}
