<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Routing\Controller; 
use Illuminate\Http\Request;
use App\Domains\User\Model\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'description' => $request->description ?? null, 
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }


    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name,'description' => $request->description ?? null, ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        try {
            // Kiểm tra nếu có ràng buộc khóa ngoại (nếu có liên kết với role)
            if ($permission->roles()->count() > 0) {
                return redirect()->route('permissions.index')->with('error', 'Cannot delete permission assigned to roles.');
            }

            $permission->delete();
            return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')->with('error', 'Error deleting permission: ' . $e->getMessage());
        }
    }

}
