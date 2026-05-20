<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'exists:users,id', 'not_in:'.$this->user()->id],
            'lost_item_id' => ['nullable', 'exists:lost_items,id'],
            'found_item_id' => ['nullable', 'exists:found_items,id'],
            'subject' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.not_in' => 'You cannot send a message to yourself.',
            'subject.required' => 'Please provide a subject.',
            'body.min' => 'Message must be at least 10 characters.',
        ];
    }
}
