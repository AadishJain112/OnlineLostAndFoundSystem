<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LostItemResource;
use App\Models\LostItem;
use App\Services\ItemSearchService;
use Illuminate\Http\Request;

class ApiLostItemController extends Controller
{
    public function __construct(protected ItemSearchService $searchService) {}

    public function index(Request $request)
    {
        $items = $this->searchService->searchLost($request->all());

        return LostItemResource::collection($items);
    }

    public function show(LostItem $lostItem)
    {
        $lostItem->load(['category', 'images']);

        return new LostItemResource($lostItem);
    }
}
