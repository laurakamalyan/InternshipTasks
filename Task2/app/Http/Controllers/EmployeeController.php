<?php

namespace App\Http\Controllers;

use App\Models\Employee;
//use http\Env\Request;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Http\Contracts\EmployeeRepositoryInterface;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;

class EmployeeController extends Controller
{
    /**
     * @param EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(protected EmployeeRepositoryInterface $employeeRepository){}

    /**
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse {
        $employees = $this->employeeRepository->all($request);
        return response()->json($employees);
    }

    /**
     * @param EmployeeCreateRequest $request
     * @return JsonResponse
     */
    public function create(EmployeeCreateRequest $request) : JsonResponse {
        try {
            $request->validated();
            DB::beginTransaction();
            $employee = $this->employeeRepository->create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $employee->positions()->attach([
                'position_id' => $request->position_id,
            ]);

            $employee->companies()->attach([
                'company_id' => $request->company_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'Employee added successfully!',
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status' => 'Error!',
            ]);
        }
    }

    /**
     * @param EmployeeUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(EmployeeUpdateRequest $request, int $id) : JsonResponse {
        $request->validated();
        $this->employeeRepository->update([
            'name' => $request->name,
            'email' => $request->email,
        ], $id);
        return response()->json([
            'status' => 'Employee data updated successfully!',
        ]);
    }

    /**
     * @param int $id
     * @return Employee|null
     */
    public function find(int $id) : Employee | null {
        return $this->employeeRepository->find($id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int {
        return $this->employeeRepository->delete($id);
    }

    // Show employees whose position is 'qa'

    /**
     * @return void
     */
    public function show() : void {
        $employees = $this->employeeRepository->show();
        foreach ($employees as $employee) {
            echo "Employee name: " . $employee->name . "<br>";
            echo "Position: " . $employee->positions[0]->position_name . "<br>";
            $companies = $employee->companies;
            foreach ($companies as $company) {
                echo "Company name: " . $company->name;
            }
            echo "<hr>";
        }
    }
}
