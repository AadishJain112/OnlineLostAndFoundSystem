<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Http\Requests\StoreLostItemRequest;
use App\Http\Requests\UpdateLostItemRequest;
use App\Models\Category;
use App\Models\LostItem;
use App\Services\ImageUploadService;
use App\Services\ItemReportService;
use App\Services\ItemSearchService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LostItemController extends Controller
{
    public function __construct(
        protected ItemSearchService $searchService,
        protected ItemReportService $reportService,
        protected ImageUploadService $imageUploadService,
    ) {}

    public function index(Request $request): View
    {
        return view('items.lost.index', [
            'items' => $this->searchService->searchLost($request->all()),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
            'filters' => $request->all(),
        ]);
    }

    public function search(Request $request)
    {
        $items = $this->searchService->searchLost($request->all());

        if ($request->wantsJson() || $request->ajax()) {
            return view('items.partials.grid', ['items' => $items, 'type' => 'lost'])->render();
        }

        return $this->index($request);
    }

    public function show(LostItem $lostItem): View
    {
        $lostItem->load(['category', 'user', 'images', 'comments.user']);

        return view('items.lost.show', [
            'item' => $lostItem,
            'qr' => $this->generateQrCode(route('lost-items.show', $lostItem)),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', LostItem::class);

        return view('items.lost.create', [
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreLostItemRequest $request): RedirectResponse
    {
        $item = $this->reportService->createLost(
            $request->user(),
            $request->validated(),
            $request->file('images', [])
        );

        return redirect()->route('lost-items.show', $item)
            ->with('success', 'Lost item report created successfully.');
    }

    public function edit(LostItem $lostItem): View
    {
        $this->authorize('update', $lostItem);

        return view('items.lost.edit', [
            'item' => $lostItem->load('images'),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateLostItemRequest $request, LostItem $lostItem): RedirectResponse
    {
        $item = $this->reportService->updateLost(
            $lostItem,
            $request->validated(),
            $request->file('images', [])
        );

        return redirect()->route('lost-items.show', $item)
            ->with('success', 'Lost item report updated.');
    }

    public function destroy(LostItem $lostItem): RedirectResponse
    {
        $this->authorize('delete', $lostItem);
        $this->imageUploadService->deleteAll($lostItem);
        $lostItem->delete();

        return redirect()->route('my-reports.index')->with('success', 'Report deleted.');
    }

    public function markRecovered(LostItem $lostItem): RedirectResponse
    {
        $this->authorize('update', $lostItem);
        $lostItem->update([
            'status' => ItemStatus::Closed,
            'recovered_at' => now(),
        ]);

        return back()->with('success', 'Item marked as recovered.');
    }

    public function exportPdf(LostItem $lostItem)
    {
        $lostItem->load(['category', 'user', 'images']);

        return Pdf::loadView('items.pdf', ['item' => $lostItem, 'type' => 'Lost'])
            ->download('lost-item-'.$lostItem->slug.'.pdf');
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
