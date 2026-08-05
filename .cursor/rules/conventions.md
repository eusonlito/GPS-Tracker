# Code conventions

Refactoring conventions for actions, validators and fractals. Each rule shows a
**Before** (what to avoid) and an **After** (the expected style). The goal is the
same everywhere: small single-purpose methods, no inline branching, no hidden
side effects and explicit data.

---

## 1. Factor array parameters into a method

Inline array literals passed as arguments hide intent and make the call hard to
read. Move them to a dedicated `*Data()` method.

**Before**

```php
protected function expense(): void
{
    $this->factory('Expense')
        ->action([
            'name' => $this->row->name,
            'description' => $this->row->description,
            'amount' => $this->row->amount,
            'date_at' => $this->row->date_at,
            'distance' => $this->row->distance,
            'user_id' => $this->row->user_id,
            'vehicle_id' => $this->row->vehicle_id,
            'maintenance_id' => $this->row->id,
        ])
        ->upsertFromMaintenance();
}
```

**After**

```php
protected function expense(): void
{
    $this->factory('Expense')
        ->action($this->expenseData())
        ->upsertFromMaintenance();
}

protected function expenseData(): array
{
    return [
        'name' => $this->row->name,
        'description' => $this->row->description,
        'amount' => $this->row->amount,
        'date_at' => $this->row->date_at,
        'distance' => $this->row->distance,
        'user_id' => $this->row->user_id,
        'vehicle_id' => $this->row->vehicle_id,
        'maintenance_id' => $this->row->id,
    ];
}
```

---

## 2. In actions `$this->data` already holds validated values

The validator guarantees the shape and presence of every field, so inside the
action you must not re-default values with `?? null`, `?? []` or `?? ''`. Trust
the rules and read the keys directly.

**Action factory**

```php
<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\Maintenance\Model\Maintenance as Model;

class ActionFactory extends ActionFactoryAbstract
{
    protected ?Model $row;

    public function create(): Model
    {
        return $this->actionHandleTransaction(Create::class, $this->validate()->create());
    }
}
```

**Validator**

```php
<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Validate;

use App\Domains\Core\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'workshop' => ['bail', 'required'],
            'date_at' => ['bail', 'required', 'date_format:Y-m-d'],
            'distance' => ['bail', 'required', 'numeric'],
            'distance_next' => ['bail', 'numeric'],
            'amount' => ['bail', 'numeric'],
            'description' => ['bail'],
            'user_id' => ['bail', 'integer'],
            'vehicle_id' => ['bail', 'required', 'integer'],
        ];
    }
}
```

**Before**

```php
protected function saveItems(): void
{
    foreach (($this->data['maintenance_item_id'] ?? []) as $index => $item_id) {
        $this->saveItem($item_id, $index);
    }
}

protected function saveItem(int $item_id, int $index): void
{
    MaintenanceMaintenanceItemModel::query()->create([
        'quantity' => $this->data['quantity'][$index] ?? 0,
        'amount_gross' => $this->data['amount_gross'][$index] ?? 0,
        'tax_percent' => $this->data['tax_percent'][$index] ?? 0,
        'maintenance_id' => $this->row->id,
        'maintenance_item_id' => $item_id,
        'user_id' => $this->data['user_id'] ?? null,
    ]);
}
```

**After**

```php
protected function saveItems(): void
{
    foreach ($this->data['maintenance_item_id'] as $index => $item_id) {
        $this->saveItem($item_id, $index);
    }
}

protected function saveItem(int $item_id, int $index): void
{
    MaintenanceMaintenanceItemModel::query()->create([
        'quantity' => $this->data['quantity'][$index],
        'amount_gross' => $this->data['amount_gross'][$index],
        'tax_percent' => $this->data['tax_percent'][$index],
        'maintenance_id' => $this->row->id,
        'maintenance_item_id' => $item_id,
        'user_id' => $this->data['user_id'],
    ]);
}
```

> Keep `??` only when the fallback is a real default derived at runtime (for
> example a loop index), not as a missing-key guard for validated fields.

---

## 3. Do not mix orchestration methods with raw processes

`handle()` (and any orchestration method) should only call other methods. Inline
work such as building the response array belongs in its own method.

**Before**

```php
public function handle(): Model
{
    $this->data();
    $this->check();
    $this->save();
    $this->job();
    $this->expense();

    return $this->row;
}
```

This form is already correct when every step is a method call. Avoid inlining
payload construction or queries inside `handle()`:

**Before (bad)**

```php
public function handle(): array
{
    $this->data();
    $this->check();
    $this->save();

    return [
        'id' => $this->row->id,
        'vehicle_id' => $this->row->vehicle_id,
        'amount' => $this->row->amount,
        'files' => count($this->files),
    ];
}
```

**After**

```php
public function handle(): array
{
    $this->data();
    $this->check();
    $this->save();

    return $this->response();
}

protected function response(): array
{
    return [
        'id' => $this->row->id,
        'vehicle_id' => $this->row->vehicle_id,
        'amount' => $this->row->amount,
        'files' => count($this->files),
    ];
}
```

---

## 4. Do not validate multiple fields in the same method

Each check method must verify one thing. Split combined validations so the
orchestrator reads as a checklist.

**Before**

```php
protected function check(): void
{
    if ($this->checkVehicleExists() === false) {
        $this->exceptionValidator(__('maintenance-create.error.vehicle-not-found'));
    }

    if (Model::query()->byVehicleId($this->data['vehicle_id'])->byDateAt($this->data['date_at'])->exists()) {
        $this->exceptionValidator(__('maintenance-create.error.duplicate'));
    }
}
```

**After**

```php
protected function check(): void
{
    $this->checkVehicle();
    $this->checkDuplicate();
}

protected function checkVehicle(): void
{
    if ($this->checkVehicleExists() === false) {
        $this->exceptionValidator(__('maintenance-create.error.vehicle-not-found'));
    }
}

protected function checkDuplicate(): void
{
    if ($this->checkDuplicateExists()) {
        $this->exceptionValidator(__('maintenance-create.error.duplicate'));
    }
}

protected function checkDuplicateExists(): bool
{
    return Model::query()
        ->byVehicleId($this->data['vehicle_id'])
        ->byDateAt($this->data['date_at'])
        ->exists();
}
```

---

## 5. Do not put query logic in the same method as validation

Keep the query in its own boolean method and let the validation method only
decide and throw.

**Before**

```php
protected function checkVehicleId(): void
{
    if (VehicleModel::query()->byId($this->data['vehicle_id'])->byUserId($this->data['user_id'])->exists() === false) {
        $this->exceptionValidator(__('refuel-create.error.vehicle-exists'));
    }
}
```

**After**

```php
protected function checkVehicleId(): void
{
    if ($this->checkVehicleIdExists() === false) {
        $this->exceptionValidator(__('refuel-create.error.vehicle-exists'));
    }
}

protected function checkVehicleIdExists(): bool
{
    return VehicleModel::query()
        ->byId($this->data['vehicle_id'])
        ->byUserId($this->data['user_id'])
        ->exists();
}
```

> Use `exists()` instead of `count()` when you only need to know whether a row is
> present.

---

## 6. Avoid generic error messages

Throw a specific, translated message instead of a generic exception so the API
consumer understands what failed.

**Before**

```php
protected function checkVehicleId(): void
{
    if ($this->checkVehicleIdExists() === false) {
        $this->exceptionNotAllowed();
    }
}
```

**After**

```php
protected function checkVehicleId(): void
{
    if ($this->checkVehicleIdExists() === false) {
        $this->exceptionValidator(__('refuel-create.error.vehicle-exists'));
    }
}
```

> In actions the helper is `exceptionValidator()` (from `Core\Action\ActionAbstract`).
> `validatorException()` only exists in a few standalone service abstracts — do not
> mix them up.

---

## 7. Avoid doing different actions in the same method

A method that loads a list, iterates it and validates each item is doing three
things. Split each responsibility into its own method.

**Before**

```php
protected function lines(): void
{
    $this->data['lines'] = [];

    foreach ($this->data['maintenance_item_id'] as $index => $maintenance_item_id) {
        $data = [
            'maintenance_item_id' => $this->data['maintenance_item_id'][$index] ?? null,
            'quantity' => $this->data['quantity'][$index] ?? 0,
            'amount_gross' => $this->data['amount_gross'][$index] ?? 0,
            'tax_percent' => $this->data['tax_percent'][$index] ?? 0,
        ];

        if (empty($data['maintenance_item_id'])) {
            continue;
        }

        $data['amount_net'] = round($data['amount_gross'] * (1 + $data['tax_percent'] / 100), 2);
        $this->data['lines'][$maintenance_item_id] = $data;
    }
}
```

**After**

```php
protected function lines(): void
{
    $this->data['lines'] = [];

    foreach ($this->data['maintenance_item_id'] as $index => $maintenance_item_id) {
        if ($line = $this->linesIndex($index)) {
            $this->data['lines'][$maintenance_item_id] = $line;
        }
    }
}

protected function linesIndex(int $index): ?array
{
    return $this->linesIndexIsValid($data = $this->linesIndexData($index)) ? $data : null;
}

protected function linesIndexData(int $index): array
{
    $data = [
        'maintenance_item_id' => $this->data['maintenance_item_id'][$index],
        'quantity' => $this->data['quantity'][$index],
        'amount_gross' => $this->data['amount_gross'][$index],
        'tax_percent' => $this->data['tax_percent'][$index],
    ];

    $data['amount_net'] = round($data['amount_gross'] * (1 + $data['tax_percent'] / 100), 2);
    $data['subtotal'] = round($data['quantity'] * $data['amount_gross'], 2);
    $data['tax_amount'] = round($data['subtotal'] * $data['tax_percent'] / 100, 2);
    $data['total'] = round($data['subtotal'] + $data['tax_amount'], 2);

    return $data;
}

protected function linesIndexIsValid(array $data): bool
{
    return empty($data['maintenance_item_id']) === false;
}
```

The same rule applies to a method that creates a row, attaches relations and
creates child rows in one go.

**Before**

```php
protected function save(): void
{
    $this->row = Model::query()->create([
        'date_at' => $this->data['date_at'],
        'name' => $this->data['name'],
        'amount' => $this->data['amount'],
        'user_id' => $this->data['user_id'],
        'vehicle_id' => $this->data['vehicle_id'],
    ]);

    $this->factory('File')->action([
        'files' => $this->request->all('files')['files'],
        'related_table' => $this->row->getTable(),
        'related_id' => $this->row->id,
        'user_id' => $this->data['user_id'],
    ])->upload();

    $this->factory('Expense')->action([
        'name' => $this->row->name,
        'amount' => $this->row->amount,
        'date_at' => $this->row->date_at,
        'user_id' => $this->row->user_id,
        'vehicle_id' => $this->row->vehicle_id,
        'maintenance_id' => $this->row->id,
    ])->upsertFromMaintenance();
}
```

**After**

```php
protected function save(): void
{
    $this->saveRow();
    $this->files();
    $this->expense();
}

protected function saveRow(): void
{
    $this->row = Model::query()->create([
        'date_at' => $this->data['date_at'],
        'name' => $this->data['name'],
        'amount' => $this->data['amount'],
        'user_id' => $this->data['user_id'],
        'vehicle_id' => $this->data['vehicle_id'],
    ]);
}

protected function files(): void
{
    $this->factory('File')->action($this->filesData())->upload();
}

protected function filesData(): array
{
    return [
        'files' => $this->request->all('files')['files'],
        'related_table' => $this->row->getTable(),
        'related_id' => $this->row->id,
        'user_id' => $this->data['user_id'],
    ];
}

protected function expense(): void
{
    $this->factory('Expense')->action($this->expenseData())->upsertFromMaintenance();
}

protected function expenseData(): array
{
    return [
        'name' => $this->row->name,
        'amount' => $this->row->amount,
        'date_at' => $this->row->date_at,
        'user_id' => $this->row->user_id,
        'vehicle_id' => $this->row->vehicle_id,
        'maintenance_id' => $this->row->id,
    ];
}
```

---

## 8. Avoid selecting full rows just to read one column

Select only the column you need with `value()`. Even better, query the source
table directly instead of loading a relation.

**Before**

```php
$this->data['position_id'] = PositionModel::query()
    ->byUserId($this->data['user_id'])
    ->orderByDateAtNearest($this->data['date_at'])
    ->first()
    ?->id;
```

**After**

```php
$this->data['position_id'] = PositionModel::query()
    ->byUserId($this->data['user_id'])
    ->orderByDateAtNearest($this->data['date_at'])
    ->value('id');
```

**After (better, when a relation would be loaded)**

```php
$device_id = DeviceModel::query()
    ->byVehicleId($this->row->id)
    ->whereEnabled()
    ->orderBy('id')
    ->value('id');
```

---

## 9. Avoid inline conditionals; factor them into methods

In fractals, never put `relationLoaded(...) ? ... : null` ternaries inside the
returned array. Extract a helper per derived value, and use `fromIfLoaded()` for
nested transforms.

**Before**

```php
protected function map(Model $row): array
{
    return [
        'id' => $row->id,
        'code' => $row->code,
        'name' => $row->name,
        'distance' => helper()->unit('distance', $row->distance),
        'distance_human' => helper()->unitHuman('distance', $row->distance),
        'time' => $row->time,
        'time_human' => helper()->timeHuman($row->time),

        'device' => $row->relationLoaded('device')
            ? $this->from('Device', 'related', $row->device)
            : null,

        'vehicle' => $row->relationLoaded('vehicle')
            ? $this->from('Vehicle', 'related', $row->vehicle)
            : null,

        'user' => $row->relationLoaded('user')
            ? $this->from('User', 'related', $row->user)
            : null,

        'positions' => $this->from('Position', 'related', $row->positions),
    ];
}
```

**After**

```php
protected function map(Model $row): array
{
    return [
        'id' => $row->id,
        'code' => $row->code,
        'name' => $row->name,
        'distance' => helper()->unit('distance', $row->distance),
        'distance_human' => helper()->unitHuman('distance', $row->distance),
        'time' => $row->time,
        'time_human' => helper()->timeHuman($row->time),
        'device' => $this->fromIfLoaded('Device', 'related', $row, 'device'),
        'vehicle' => $this->fromIfLoaded('Vehicle', 'related', $row, 'vehicle'),
        'user' => $this->fromIfLoaded('User', 'related', $row, 'user'),
        'positions' => $this->from('Position', 'related', $row->positions),
    ];
}
```

> `fromIfLoaded($domain, $view, $row, $relation)` already returns `null` when the
> relation is not loaded, so it replaces both the ternary and the manual
> `transform()` call.

The same rule applies when deriving a nested payload that is not a fractal view:

**Before**

```php
protected function map(Model $row): array
{
    return [
        'id' => $row->id,
        'name' => $row->name,
        'plate' => $row->plate,
        'position' => $row->positionLast
            ? [
                'id' => $row->positionLast->id,
                'latitude' => $row->positionLast->latitude,
                'longitude' => $row->positionLast->longitude,
                'speed' => helper()->unit('speed', $row->positionLast->speed),
            ]
            : null,
    ];
}
```

**After**

```php
protected function map(Model $row): array
{
    return [
        'id' => $row->id,
        'name' => $row->name,
        'plate' => $row->plate,
        'position' => $this->mapPosition($row->positionLast),
    ];
}

protected function mapPosition(?PositionModel $position): ?array
{
    if ($position === null) {
        return null;
    }

    return [
        'id' => $position->id,
        'latitude' => $position->latitude,
        'longitude' => $position->longitude,
        'speed' => helper()->unit('speed', $position->speed),
        'speed_human' => helper()->unitHuman('speed', $position->speed),
    ];
}
```

---

## 10. Never build translation keys dynamically

The automatic translation system scans the code for literal `__('file.key')`
calls. If the key is built at runtime by concatenating a variable or by
interpolating values, the scanner cannot find it and the string will never be
translated. Every `__()` argument must be a complete, static string literal.

This applies to partial keys (a variable prefix or suffix joined with `.`) and to
interpolated keys.

**Before**

```blade
@include ('domains.vehicle.molecules.status', [
    'status_lang' => 'vehicle-update',
])
```

```blade
<span>{{ __($status_lang.'.success') }}</span>
<th>{{ __($status_lang.'.meta-title') }}</th>
```

**After**

```blade
@include ('domains.vehicle.molecules.status', [
    'success' => __('vehicle-update.success'),
    'meta_title' => __('vehicle-update.meta-title'),
])
```

```blade
<span>{{ $success }}</span>
<th>{{ $meta_title }}</th>
```

When a reusable partial needs different translations per caller, resolve the
strings in each parent view with static `__()` calls and pass the resulting
strings into the partial. Never push the key prefix into the partial.

> The same rule applies in PHP: `__("vehicle.$type.label")` or
> `__('vehicle.'.$type.'.label')` are both invisible to the scanner. Use a
> `match`/`array` map of literal keys instead.
