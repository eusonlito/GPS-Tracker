<?php declare(strict_types=1);

namespace App\Domains\File\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Upload extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'files' => ['bail', 'nullable', 'array'],
            'files.*.id' => ['bail', 'integer', 'nullable'],
            'files.*.file' => ['bail', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx'],
            'files.*.delete' => ['bail', 'boolean'],
            'related_table' => ['bail', 'required', 'string'],
            'related_id' => ['bail', 'required', 'integer'],
            'user_id' => ['bail', 'required', 'integer'],
        ];
    }
}
