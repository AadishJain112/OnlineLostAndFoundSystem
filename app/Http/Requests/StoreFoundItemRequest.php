<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ItemReportRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreFoundItemRequest extends FormRequest
{
    use ItemReportRules;

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            ...$this->sharedRules(),
            'date_found' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
