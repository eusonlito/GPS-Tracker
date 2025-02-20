<?php

namespace App\Domains\Role\Service;

use App\Domains\Role\Model\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Create
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data): self
    {
        return new static($data);
    }

    public function validate(): self
    {
        $validator = Validator::make($this->data, [
            'name' => 'required|string|max:100|unique:roles,name',
            'enterprise_id' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'highest_privilege_role' => 'required|integer|min:0|max:3'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this;
    }

    public function create(): Role
    {
        return Role::create([
            'name' => $this->data['name'],
            'enterprise_id' => $this->data['enterprise_id'],
            'description' => $this->data['description'] ?? null,
            'highest_privilege_role' => $this->data['highest_privilege_role'],
        ]);
    }
}
