<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Models\Specification;
use App\Http\Contracts\SpecificationRepositoryInterface;
use App\Http\Requests\SpecificationCreateRequest;
use App\Http\Requests\SpecificationUpdateRequest;

class SpecificationController extends Controller
{
    /**
     * @param SpecificationRepositoryInterface $specificationRepository
     */
    public function __construct(protected SpecificationRepositoryInterface $specificationRepository){}

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        $specifications = $this->specificationRepository->all();
        return response()->json($specifications);
    }

    /**
     * @param SpecificationCreateRequest $request
     * @return JsonResponse
     */
    public function create(SpecificationCreateRequest $request) : JsonResponse {
        try {
            $request->validated();
            DB::beginTransaction();
            $this->specificationRepository->create([
                'specification_name' => $request->specification_name,
                'position_id' => $request->position_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'Specification added successfully!',
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status' => 'Error!',
            ]);
        }
    }

    /**
     * @param SpecificationUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(SpecificationUpdateRequest $request, int $id) : JsonResponse {
        $request->validated();
        $this->specificationRepository->update(['specification_name' => $request->specification_name], $id);
        return response()->json([
            'status' => 'Specification updated successfully!',
        ]);
    }

    /**
     * @param int $id
     * @return Specification|null
     */
    public function find(int $id) : Specification | null {
        return $this->specificationRepository->find($id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int {
        return $this->specificationRepository->delete($id);
    }
}
