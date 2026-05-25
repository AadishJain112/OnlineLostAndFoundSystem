<?php

namespace App\Http\Requests\Concerns;

trait ItemReportRules
{
    protected function sharedRules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'min:3', 'max:150'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'contact_preference' => ['required', 'in:email,phone,platform'],
            'contact_email' => ['required_if:contact_preference,email', 'nullable', 'email', 'max:255'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'title.required' => 'Please enter a title for the item.',
            'title.min' => 'Title must be at least 3 characters.',
            'description.required' => 'Please describe the item.',
            'description.min' => 'Description must be at least 10 characters.',
            'location.required' => 'Please specify where the item was lost or found.',
            'contact_email.required_if' => 'Please provide an email address when email contact is selected.',
            'contact_email.email' => 'Please provide a valid email address.',
            'images.*.image' => 'Each upload must be a valid image file.',
            'images.*.max' => 'Each image may not be larger than 4MB.',
        ];
    }
}
