<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Http\Contracts\CompanyRepositoryInterface;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;

class CompanyController extends Controller
{
    /**
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(protected CompanyRepositoryInterface $companyRepository){}

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        $companies = $this->companyRepository->all();
        return response()->json($companies);
    }

    /**
     * @param CompanyCreateRequest $request
     * @return JsonResponse
     */
    public function create(CompanyCreateRequest $request) : JsonResponse {
        try {
            $request->validated();
            DB::beginTransaction();
            $this->companyRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
            ]);
            DB::commit();

            return response()->json([
                'status' => 'Company added successfully!',
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status' => 'Error!',
            ]);
        }
    }

    /**
     * @param CompanyUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CompanyUpdateRequest $request, int $id) : JsonResponse {
        $request->validated();
        $this->companyRepository->update(['name' => $request->name], $id);
        return response()->json([
            'status' => 'Company name updated successfully!',
        ]);
    }

    /**
     * @param int $id
     * @return Company|null
     */
    public function find(int $id) : Company | null {
        return $this->companyRepository->find($id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int {
        return $this->companyRepository->delete($id);
    }
}
