<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServerRequest;
use App\Repositories\ServerFileRepository;
use Illuminate\Http\JsonResponse;

class ServerController extends Controller
{
    public function __construct(protected ServerFileRepository $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ServerRequest $request): JsonResponse
    {
        $filters = $request->validated();

        return response()->json($this->repository->all($filters));
    }
}
