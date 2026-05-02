<?php

namespace App\Http\Requests;

use App\Enums\TicketCategoryEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'store'    => ['required', 'string', 'max:100'],
            'category' => ['nullable', new Enum(TicketCategoryEnum::class)],
            'image'    => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:20480'],
        ];
    }
}
