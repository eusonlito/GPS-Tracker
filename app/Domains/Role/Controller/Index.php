<?php

namespace App\Domains\Role\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Role\Model\Role as Model;

class Index extends ControllerAbstract
{
    public function __invoke(): Response|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('role-index.meta-title'));

        return $this->page('role.index', $this->data());
    }

    protected function data(): array
    {
        $query = Model::query()
            ->select([
                'id',
                'name',
                'enterprise_id',
                'description',
                'created_at',
                'highest_privilege_role'
            ]);

        if ($this->request->filled('search')) {
            $search = $this->request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($this->request->filled('enterprise_id')) {
            $query->byEnterpriseId($this->request->get('enterprise_id'));
        }

        $query->orderBy('id', 'DESC');

        return [
            'roles' => $query->paginate($this->request->get('per_page', 10)),
            'search' => $this->request->get('search')
        ];
    }

    protected function responseJson(): JsonResponse
    {
        return $this->json([
            'data' => $this->responseJsonList()->map(fn($role) => $this->formatRole($role))->all()
        ]);
    }

    protected function responseJsonList()
    {
        return Model::query()
            ->enabled()
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * Format role data manually
     */
    protected function formatRole(Model $role): array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'enterprise_id' => $role->enterprise_id,
            'description' => $role->description,
            'highest_privilege_role' => $role->highest_privilege_role,
            'created_at' => $role->created_at->toDateTimeString(),
        ];
    }
}
