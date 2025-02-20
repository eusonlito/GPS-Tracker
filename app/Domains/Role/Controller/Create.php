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
    public function store(): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Sử dụng service để tạo role
            $role = CreateService::make($this->request->all())
                ->validate()
                ->create();

            DB::commit();

            $response = [
                'status' => true,
                'message' => __('role-create.success'),
                'role' => $this->factory()->fractal('simple', $role)
            ];

            // Nếu là request JSON, trả về JSON response trực tiếp
            if ($this->request->wantsJson()) {
                return $this->json($response);
            }

            // Nếu là web form, trả về JSON với thông tin redirect
            return $this->json(array_merge($response, [
                'redirect' => route('role.index')
            ]));
        } catch (\Exception $e) {
            DB::rollBack();

            $errorResponse = [
                'status' => false,
                'message' => $e->getMessage()
            ];

            // Nếu là request JSON, trả về JSON response với status 422
            if ($this->request->wantsJson()) {
                return $this->json($errorResponse, 422);
            }

            // Nếu là web form, trả về JSON với thông tin lỗi và giữ form data
            return $this->json(array_merge($errorResponse, [
                'errors' => $e->getMessage(),
                'old_input' => $this->request->all()
            ]), 422);
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
}
