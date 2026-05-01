<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Table\StoreTableRequest;
use App\Http\Requests\Table\UpdateTableRequest;
use App\Http\Requests\Table\UpdateTableStatusRequest;
use App\Http\Resources\TableResource;
use App\Models\Table;
use App\Services\TableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct(private TableService $tableService) {}

    // GET /api/tables
    public function index(Request $request): JsonResponse
    {
        $tables = $this->tableService->getAll($request->query());
        return TableResource::collection($tables)->response();
    }

    // GET /api/tables/{id}
    public function show(Table $table): JsonResponse
    {
        return (new TableResource($table))->response();
    }

    // POST /api/tables
    public function store(StoreTableRequest $request): JsonResponse
    {
        $table = $this->tableService->create($request->validated());
        return (new TableResource($table))->response()->setStatusCode(201);
    }

    // PUT /api/tables/{id}
    public function update(UpdateTableRequest $request, Table $table): JsonResponse
    {
        $table = $this->tableService->update($table, $request->validated());
        return (new TableResource($table))->response();
    }

    // PATCH /api/tables/{id}/status
    public function updateStatus(UpdateTableStatusRequest $request, Table $table): JsonResponse
    {
        try {
            $table = $this->tableService->updateStatus($table, $request->status);
            return (new TableResource($table))->response();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    // DELETE /api/tables/{id}
    public function destroy(Table $table): JsonResponse
    {
        try {
            $this->tableService->delete($table);
            return response()->json(['message' => 'Mesa eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
