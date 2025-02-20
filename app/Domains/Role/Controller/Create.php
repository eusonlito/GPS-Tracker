<?php

namespace App\Domains\Role\Controller;

use Illuminate\Contracts\View\View;

class Create
{
    public function __invoke(): View
    {
        return view('role.create'); // Trả về view để hiển thị form tạo mới
    }
}
