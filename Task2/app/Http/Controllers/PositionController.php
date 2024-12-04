<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Http\Contracts\PositionRepositoryInterface;
use App\Http\Requests\PositionCreateRequest;
use App\Http\Requests\PositionUpdateRequest;

class PositionController extends Controller
{
    /**
     * @param PositionRepositoryInterface $positionRepository
     */
    public function __construct(protected PositionRepositoryInterface $positionRepository){}

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse {
        $positions = $this->positionRepository->all();
        return response()->json($positions);
    }

    /**
     * @param PositionCreateRequest $request
     * @return JsonResponse
     */
    public function create(PositionCreateRequest $request) : JsonResponse {
        try {
            $request->validated();
            DB::beginTransaction();
            $position = $this->positionRepository->create([
                'position_name' => $request->position_name,
            ]);
            DB::commit();

            return response()->json([
                'status' => 'Position added successfully!',
            ]);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json([
                'status' => 'Error!',
            ]);
        }
    }

    /**
     * @param PositionUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PositionUpdateRequest $request, int $id) : JsonResponse {
        $request->validated();
        $this->positionRepository->update(['position_name' => $request->position_name], $id);
        return response()->json([
            'status' => 'Position updated successfully!',
        ]);
    }

    /**
     * @param int $id
     * @return Position|null
     */
    public function find(int $id) : Position | null {
        return $this->positionRepository->find($id);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int {
        return $this->positionRepository->delete($id);
    }
}
