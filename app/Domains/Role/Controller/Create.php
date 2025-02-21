<?php

namespace App\Domains\Role\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domains\Role\Model\Role as Model;
use App\Domains\Role\Service\Create as CreateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class Create extends ControllerAbstract
{
    /**
     * Hiển thị form tạo role mới
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
     * Xử lý lưu role mới vào database
     */
    public function store(): Response|JsonResponse|RedirectResponse // Thêm RedirectResponse
    {
        try {
            DB::beginTransaction();

            $role = CreateService::make($this->request->all())
                ->validate()
                ->create();

            DB::commit();

            $response = [
                'status' => true,
                'message' => __('role-create.success'),
                'role' => $this->formatRole($role)
            ];

            if ($this->request->wantsJson()) {
                return $this->json($response);
            }

            return redirect()->route('role.index')->with('success', __('role-create.success'));
        } catch (\Exception $e) {
            DB::rollBack();

            $errorResponse = [
                'status' => false,
                'message' => $e->getMessage()
            ];

            if ($this->request->wantsJson()) {
                return $this->json($errorResponse, 422);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    /**
     * Lấy dữ liệu cho form tạo role
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
     * Lấy danh sách enterprises (bây giờ là input thủ công)
     * Vì không có model Enterprise, ta sẽ tạo một danh sách giả lập để người dùng chọn
     */
    protected function getEnterprises(): array
    {
        // Danh sách giả lập enterprise_id (bạn có thể thay đổi theo dữ liệu thực tế)
        return [
            ['id' => 1, 'name' => 'Enterprise 1'],
            ['id' => 2, 'name' => 'Enterprise 2'],
            ['id' => 3, 'name' => 'Enterprise 3'],
        ];
    }

    /**
     * Lấy các mức privilege
     */
    protected function getPrivileges(): array
    {
        return [
            0 => __('role-create.privilege-false'),
            1 => __('role-create.privilege-true'),
        ];
    }

    /**
     * Xử lý response JSON
     */
    protected function responseJson(): JsonResponse
    {
        return $this->json([
            'data' => $this->data()
        ]);
    }

    public function edit($id): Response|JsonResponse
    {
        $role = Model::findOrFail($id);

        if ($this->request->wantsJson()) {
            return $this->json([
                'data' => array_merge($this->data(), ['role' => $this->formatRole($role)])
            ]);
        }

        $this->meta('title', __('role-edit.meta-title'));

        return $this->page('role.edit', array_merge($this->data(), ['role' => $role]));
    }
    public function update($id): Response|JsonResponse|RedirectResponse // Thêm RedirectResponse
    {
        try {
            DB::beginTransaction();

            $role = Model::findOrFail($id);

            $validator = Validator::make($this->request->all(), [
                'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
                'enterprise_id' => 'required|integer|min:1',
                'description' => 'nullable|string|max:255',
                'highest_privilege_role' => 'required|integer|min:0|max:3'
            ]);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            $role->update([
                'name' => $this->request->get('name'),
                'enterprise_id' => $this->request->get('enterprise_id'),
                'description' => $this->request->get('description'),
                'highest_privilege_role' => $this->request->get('highest_privilege_role'),
            ]);

            DB::commit();

            $response = [
                'status' => true,
                'message' => __('role-update.success'),
                'role' => $this->formatRole($role)
            ];

            if ($this->request->wantsJson()) {
                return $this->json($response);
            }

            return redirect()->route('role.index')->with('success', __('role-update.success'));
        } catch (\Exception $e) {
            DB::rollBack();

            $errorResponse = [
                'status' => false,
                'message' => $e->getMessage()
            ];

            if ($this->request->wantsJson()) {
                return $this->json($errorResponse, 422);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy($id): Response|JsonResponse|RedirectResponse // Thêm RedirectResponse
    {
        try {
            DB::beginTransaction();

            $role = Model::findOrFail($id);
            $role->delete();

            DB::commit();

            $response = [
                'status' => true,
                'message' => __('role-delete.success'),
            ];

            if ($this->request->wantsJson()) {
                return $this->json($response);
            }

            return redirect()->route('role.index')->with('success', __('role-delete.success'));
        } catch (\Exception $e) {
            DB::rollBack();

            $errorResponse = [
                'status' => false,
                'message' => $e->getMessage()
            ];

            if ($this->request->wantsJson()) {
                return $this->json($errorResponse, 422);
            }

            return redirect()->route('role.index')->withErrors($e->getMessage());
        }
    }
    protected function formatRole(Model $role): array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'enterprise_id' => $role->enterprise_id,
            'description' => $role->description,
            'highest_privilege_role' => $role->highest_privilege_role,
            'created_at' => $role->created_at ? \Carbon\Carbon::parse($role->created_at)->toDateTimeString() : null,
        ];
    }
}
