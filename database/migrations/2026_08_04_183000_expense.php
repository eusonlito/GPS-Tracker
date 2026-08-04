<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class() extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated() === false) {
            $this->tables();
            $this->keys();
        }

        $this->seedCategories();
        $this->backfill();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasTable('expense');
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        Schema::create('expense_category', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->string('code')->nullable()->unique();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::create('expense', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();
            $table->text('description')->nullable();

            $table->decimal('amount', 10, 2)->default(0);
            $table->date('date_at')->index();
            $table->decimal('distance', 10, 2)->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('expense_category_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('maintenance_id')->nullable()->unique();
            $table->unsignedBigInteger('refuel_id')->nullable()->unique();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('expense_category', function (Blueprint $table) {
            $this->tableAddUnique($table, ['name', 'user_id']);
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('expense', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'expense_category');
            $this->foreignOnDeleteCascade($table, 'user');
            $this->foreignOnDeleteCascade($table, 'vehicle');
            $this->foreignOnDeleteCascade($table, 'maintenance');
            $this->foreignOnDeleteCascade($table, 'refuel');
        });
    }

    /**
     * @return void
     */
    protected function seedCategories(): void
    {
        if ($this->seedCategoriesMigrated()) {
            return;
        }

        foreach ($this->seedCategoriesData() as $row) {
            $this->seedCategoryInsert($row);
        }
    }

    /**
     * @return bool
     */
    protected function seedCategoriesMigrated(): bool
    {
        return DB::table('expense_category')
            ->whereNotNull('code')
            ->exists();
    }

    /**
     * @return array<int, array{name: string, code: string}>
     */
    protected function seedCategoriesData(): array
    {
        return [
            [
                'name' => __('expense-category.seed.maintenance'),
                'code' => 'maintenance',
            ],
            [
                'name' => __('expense-category.seed.refuel'),
                'code' => 'refuel',
            ],
        ];
    }

    /**
     * @param array{name: string, code: string} $row
     *
     * @return void
     */
    protected function seedCategoryInsert(array $row): void
    {
        DB::table('expense_category')->insert([
            'name' => $row['name'],
            'code' => $row['code'],
            'user_id' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return void
     */
    protected function backfill(): void
    {
        $this->expenseInsert($this->backfillData(date('Y-m-d H:i:s')));
    }

    /**
     * @param string $now
     *
     * @return array<int, array>
     */
    protected function backfillData(string $now): array
    {
        return array_merge(
            $this->backfillMaintenanceData($now),
            $this->backfillRefuelData($now),
        );
    }

    /**
     * @param string $now
     *
     * @return array<int, array>
     */
    protected function backfillMaintenanceData(string $now): array
    {
        $category_id = $this->maintenanceCategoryId();
        $insert = [];

        foreach ($this->backfillMaintenanceRows() as $row) {
            $insert[] = $this->backfillMaintenanceRow($row, $category_id, $now);
        }

        return $insert;
    }

    /**
     * @return \Illuminate\Support\Collection<int, object>
     */
    protected function backfillMaintenanceRows()
    {
        return DB::table('maintenance')
            ->whereNotIn('id', DB::table('expense')->whereNotNull('maintenance_id')->select('maintenance_id'))
            ->orderBy('id')
            ->get();
    }

    /**
     * @param object $row
     * @param int $category_id
     * @param string $now
     *
     * @return array
     */
    protected function backfillMaintenanceRow(object $row, int $category_id, string $now): array
    {
        return [
            'name' => $row->name,
            'description' => $row->description,
            'amount' => $row->amount,
            'date_at' => substr((string)$row->date_at, 0, 10),
            'distance' => $row->distance,
            'created_at' => $now,
            'updated_at' => $now,
            'expense_category_id' => $category_id,
            'user_id' => $row->user_id,
            'vehicle_id' => $row->vehicle_id,
            'maintenance_id' => $row->id,
            'refuel_id' => null,
        ];
    }

    /**
     * @param string $now
     *
     * @return array<int, array>
     */
    protected function backfillRefuelData(string $now): array
    {
        $category_id = $this->refuelCategoryId();
        $insert = [];

        foreach ($this->backfillRefuelRows() as $row) {
            $insert[] = $this->backfillRefuelRow($row, $category_id, $now);
        }

        return $insert;
    }

    /**
     * @return \Illuminate\Support\Collection<int, object>
     */
    protected function backfillRefuelRows()
    {
        return DB::table('refuel')
            ->whereNotIn('id', DB::table('expense')->whereNotNull('refuel_id')->select('refuel_id'))
            ->orderBy('id')
            ->get();
    }

    /**
     * @param object $row
     * @param int $category_id
     * @param string $now
     *
     * @return array
     */
    protected function backfillRefuelRow(object $row, int $category_id, string $now): array
    {
        return [
            'name' => __('expense-category.seed.refuel'),
            'description' => null,
            'amount' => $row->total,
            'date_at' => substr((string)$row->date_at, 0, 10),
            'distance' => $row->distance_total,
            'created_at' => $now,
            'updated_at' => $now,
            'expense_category_id' => $category_id,
            'user_id' => $row->user_id,
            'vehicle_id' => $row->vehicle_id,
            'maintenance_id' => null,
            'refuel_id' => $row->id,
        ];
    }

    /**
     * @return int
     */
    protected function maintenanceCategoryId(): int
    {
        return $this->expenseCategoryIdByCode('maintenance');
    }

    /**
     * @return int
     */
    protected function refuelCategoryId(): int
    {
        return $this->expenseCategoryIdByCode('refuel');
    }

    /**
     * @param string $code
     *
     * @return int
     */
    protected function expenseCategoryIdByCode(string $code): int
    {
        $id = DB::table('expense_category')
            ->where('code', $code)
            ->value('id');

        if ($id === null) {
            throw new \Exception(sprintf('Expense category with code [%s] not found', $code));
        }

        return (int)$id;
    }

    /**
     * @param array<int, array> $insert
     *
     * @return void
     */
    protected function expenseInsert(array $insert): void
    {
        foreach (array_chunk($insert, 5000) as $chunk) {
            DB::table('expense')->insert($chunk);
        }
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('expense');
        Schema::dropIfExists('expense_category');
    }
};
