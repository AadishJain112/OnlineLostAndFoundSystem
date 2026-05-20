<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ItemReportRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFoundItemRequest extends FormRequest
{
    use ItemReportRules;

    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('found_item'));
    }

    public function rules(): array
    {
        return [
            ...$this->sharedRules(),
            'date_found' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
