<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Factory;

class DeviceRequest extends FormRequest
{
    /**
     * @param Factory $factory
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param $content
     */
    public function __construct(Factory $factory, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $factory->extend('filePdf', function ($attribute, $value, $parameters) {
            return $value->getClientMimeType() === 'application/pdf';
        }, 'The file must ba a PDF.');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return match ($this->getMethod()) {
            'POST' => [
                'name' => ['required', 'max:30', Rule::unique('devices', 'name')],
                'pdf' => ['nullable', 'filePdf'],
                'description' => ['required'],
                'order' => ['required', 'numeric'],
                'category_id' => ['required', Rule::exists('categories', 'id')]
            ],
            'PUT', 'PATCH' => [
                'id' => ['required'],
                'name' => ['required', 'max:30', Rule::unique('devices', 'name')->ignore($request->id)],
                'pdf' => ['nullable', 'filePdf'],
                'description' => ['required'],
                'order' => ['required', 'numeric'],
                'category_id' => ['required', Rule::exists('categories', 'id')]
            ],
            default => []
        };

    }
}
