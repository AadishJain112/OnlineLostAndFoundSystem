<?php

namespace App\Services;

use App\Enums\ItemStatus;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ItemSearchService
{
    public function searchLost(array $filters = []): LengthAwarePaginator
    {
        $query = LostItem::query()
            ->with(['category', 'user', 'images'])
            ->whereIn('status', [ItemStatus::Lost, ItemStatus::Matched]);

        $this->applyFilters($query, $filters, 'date_lost');

        return $query->latest()->paginate(12)->withQueryString();
    }

    public function searchFound(array $filters = []): LengthAwarePaginator
    {
        $query = FoundItem::query()
            ->with(['category', 'user', 'images'])
            ->whereIn('status', [ItemStatus::Found, ItemStatus::Matched]);

        $this->applyFilters($query, $filters, 'date_found');

        return $query->latest()->paginate(12)->withQueryString();
    }

    private function applyFilters(Builder $query, array $filters, string $dateColumn): void
    {
        if (! empty($filters['q'])) {
            $keyword = '%'.$filters['q'].'%';
            $query->where(function (Builder $builder) use ($keyword) {
                $builder->where('title', 'like', $keyword)
                    ->orWhere('description', 'like', $keyword)
                    ->orWhere('location', 'like', $keyword);
            });
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['location'])) {
            $query->where('location', 'like', '%'.$filters['location'].'%');
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate($dateColumn, '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate($dateColumn, '<=', $filters['date_to']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    }
}
