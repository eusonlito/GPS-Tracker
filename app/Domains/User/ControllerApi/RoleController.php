<?php

namespace App\Domains\User\ControllerApi;

use App\Domains\User\Model\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class RoleController extends ControllerApiAbstract
{
    public function index(Request $request)
    {
        $query = Role::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string',
            'enterprise_id' => 'required|string'
        ]);

        $role = Role::create([
            'id' => Str::uuid(),
            ...$validated
        ]);

        return response()->json($role, 201);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string'
        ]);

        $role->update($validated);
        return response()->json($role);
    }

    public function destroy($id)
    {
        Role::where('id', $id)->delete();
        return response()->json(null, 204);
    }
}
