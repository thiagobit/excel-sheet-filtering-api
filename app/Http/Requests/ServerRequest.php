<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'storage' => 'in:0,250GB,500GB,1TB,2TB,3TB,4TB,8TB,12TB,24TB,48TB,72TB',
            'ram' => 'array|in:2,4,8,12,16,24,32,48,64,96',
            'harddisk_type' => 'in:SAS,SATA,SSD',
            'location' => 'string|max:256',
        ];
    }
}
