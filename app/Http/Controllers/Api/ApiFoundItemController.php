<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoundItemResource;
use App\Models\FoundItem;
use App\Services\ItemSearchService;
use Illuminate\Http\Request;

class ApiFoundItemController extends Controller
{
    public function __construct(protected ItemSearchService $searchService) {}

    public function index(Request $request)
    {
        $items = $this->searchService->searchFound($request->all());

        return FoundItemResource::collection($items);
    }

    public function show(FoundItem $foundItem)
    {
        $foundItem->load(['category', 'images']);

        return new FoundItemResource($foundItem);
    }
}
