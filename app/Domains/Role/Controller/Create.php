<?php

namespace App\Domains\Role\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Role\Model\Role as Model;
use App\Domains\Role\Service\Create as CreateService;
use Illuminate\Support\Facades\DB;

class Create extends ControllerAbstract
{
    /**
     * Show the form for creating a new role
     */
    public function __invoke(): Response|JsonResponse
    {
        if ($this->request->wantsJson()) {
            return $this->responseJson();
        }

        $this->meta('title', __('role-create.meta-title'));

        return $this->page('role.create', $this->data());
    }

    /**
     * Process the role creation
     */
    public function store(): JsonResponse
    {
        try {
            DB::beginTransaction();

            $role = CreateService::make($this->request->all())
                ->validate()
                ->create();

            DB::commit();

            return $this->json([
                'status' => true,
                'message' => __('role-create.success'),
                'role' => $this->factory()->fractal('simple', $role)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get data for the create form
     */
    protected function data(): array
    {
        return [
            'enterprises' => $this->getEnterprises(),
            'privileges' => $this->getPrivileges(),
            'errors' => session('errors') ?? new \Illuminate\Support\MessageBag(),
        ];
    }

    /**
     * Get list of enterprises for the form
     */
    protected function getEnterprises(): array
    {
        // Implement enterprise fetching logic here
        // This should return enterprises the user has access to
        return [];
    }

    /**
     * Get available privileges for role assignment
     */
    protected function getPrivileges(): array
    {
        return [
            0 => __('role-create.privilege-false'),
            1 => __('role-create.privilege-true'),
        ];
    }

    /**
     * Handle JSON response
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json([
            'data' => $this->data()
        ]);
    }
}
