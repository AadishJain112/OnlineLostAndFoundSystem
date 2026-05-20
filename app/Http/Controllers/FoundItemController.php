<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Http\Requests\StoreFoundItemRequest;
use App\Http\Requests\UpdateFoundItemRequest;
use App\Models\Category;
use App\Models\FoundItem;
use App\Services\ImageUploadService;
use App\Services\ItemReportService;
use App\Services\ItemSearchService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FoundItemController extends Controller
{
    public function __construct(
        protected ItemSearchService $searchService,
        protected ItemReportService $reportService,
        protected ImageUploadService $imageUploadService,
    ) {}

    public function index(Request $request): View
    {
        return view('items.found.index', [
            'items' => $this->searchService->searchFound($request->all()),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
            'filters' => $request->all(),
        ]);
    }

    public function search(Request $request)
    {
        $items = $this->searchService->searchFound($request->all());

        if ($request->wantsJson() || $request->ajax()) {
            return view('items.partials.grid', ['items' => $items, 'type' => 'found'])->render();
        }

        return $this->index($request);
    }

    public function show(FoundItem $foundItem): View
    {
        $foundItem->load(['category', 'user', 'images', 'comments.user']);

        return view('items.found.show', [
            'item' => $foundItem,
            'qr' => $this->generateQrCode(route('found-items.show', $foundItem)),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', FoundItem::class);

        return view('items.found.create', [
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreFoundItemRequest $request): RedirectResponse
    {
        $item = $this->reportService->createFound(
            $request->user(),
            $request->validated(),
            $request->file('images', [])
        );

        return redirect()->route('found-items.show', $item)
            ->with('success', 'Found item report created successfully.');
    }

    public function edit(FoundItem $foundItem): View
    {
        $this->authorize('update', $foundItem);

        return view('items.found.edit', [
            'item' => $foundItem->load('images'),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateFoundItemRequest $request, FoundItem $foundItem): RedirectResponse
    {
        $item = $this->reportService->updateFound(
            $foundItem,
            $request->validated(),
            $request->file('images', [])
        );

        return redirect()->route('found-items.show', $item)
            ->with('success', 'Found item report updated.');
    }

    public function destroy(FoundItem $foundItem): RedirectResponse
    {
        $this->authorize('delete', $foundItem);
        $this->imageUploadService->deleteAll($foundItem);
        $foundItem->delete();

        return redirect()->route('my-reports.index')->with('success', 'Report deleted.');
    }

    public function markReturned(FoundItem $foundItem): RedirectResponse
    {
        $this->authorize('update', $foundItem);
        $foundItem->update([
            'status' => ItemStatus::Returned,
            'returned_at' => now(),
        ]);

        return back()->with('success', 'Item marked as returned.');
    }

    public function exportPdf(FoundItem $foundItem)
    {
        $foundItem->load(['category', 'user', 'images']);

        return Pdf::loadView('items.pdf', ['item' => $foundItem, 'type' => 'Found'])
            ->download('found-item-'.$foundItem->slug.'.pdf');
    }

    private function generateQrCode(string $url): ?string
    {
        try {
            return base64_encode(QrCode::format('png')->size(150)->generate($url));
        } catch (\Throwable) {
            return null;
        }
    }
}
