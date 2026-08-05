# development reference

*(PHP 8.2+ · Laravel 13 · MySQL 8 · modular domain-driven design — GPS Tracker)*

---

## 1 · Core principles

| Topic             | Requirement                                                                                              |
| ----------------- | -------------------------------------------------------------------------------------------------------- |
| **PHP Version**   | All code **must** run on **PHP 8.2+**.                                                                   |
| **Strict Typing** | Every PHP file **must** start with `declare(strict_types=1);`.                                           |
| **Code Standard** | Follow **PSR-12**; format with **pint** or **php-cs-fixer** (`composer fix`).                            |
| **Full Typing**   | Explicit scalar / object types on *all* properties, parameters and returns.                              |
| **Comments**      | Avoid using comments anywhere in the code; the code itself should be self-descriptive. Generate clear code so that comments are not necessary, either in classes, functions, or functionality. |
| **Imports**       | Always import classes with `use ... [as Alias]` in the file header; never reference classes via fully-qualified names inline. Cross-domain models are aliased as `{Domain}Model` (`use App\Domains\Vehicle\Model\Vehicle as VehicleModel;`), the own domain model as `Model`. |
| **New syntax**    | Instantiate-and-chain without wrapping parentheses: `new ControllerService($this->request, $this->auth, $this->row)->data()`. Never write `(new X())->y()`. |
| **Negation**      | The `!` operator is **never** used. Truthy/falsy checks use `empty($value)`; strict boolean checks use `=== false` (`if ($this->auth->managerMode() === false)`); avoid `!== true`. Cast with `boolval()`, `intval()`, `strval()` instead of `(bool)` prefix negation tricks. |

---

## 2 · Project layout & namespaces

```
@root
├── app
│   ├── Console
│   ├── Domains
│   │   ├── <DOMAIN>
│   │   │   ├── Action
│   │   │   │   └── Traits
│   │   │   ├── Command
│   │   │   ├── Controller
│   │   │   │   └── Service
│   │   │   ├── ControllerApi
│   │   │   │   └── Service
│   │   │   ├── Fractal
│   │   │   ├── Job
│   │   │   ├── Model
│   │   │   │   ├── Builder
│   │   │   │   └── Collection
│   │   │   ├── Schedule
│   │   │   ├── Service
│   │   │   └── Validate
│   │   ├── Core
│   │   │   ├── Action
│   │   │   ├── Command
│   │   │   │   └── Traits
│   │   │   ├── Controller
│   │   │   │   └── Service
│   │   │   ├── Database
│   │   │   │   └── Builder
│   │   │   ├── Event
│   │   │   ├── Fractal
│   │   │   ├── Job
│   │   │   │   └── Middleware
│   │   │   ├── Listener
│   │   │   ├── Mail
│   │   │   ├── Middleware
│   │   │   ├── Migration
│   │   │   │   └── Database
│   │   │   ├── Model
│   │   │   │   ├── Builder
│   │   │   │   ├── Collection
│   │   │   │   └── Traits
│   │   │   ├── Schedule
│   │   │   ├── Seeder
│   │   │   ├── Service
│   │   │   │   └── Factory
│   │   │   ├── Test
│   │   │   │   ├── Factory
│   │   │   │   ├── Feature
│   │   │   │   └── Unit
│   │   │   ├── Traits
│   │   │   └── Validate
│   │   │       └── Rule
│   │   ├── CoreApp
│   │   │   ├── Action
│   │   │   │   └── Traits
│   │   │   ├── Command
│   │   │   ├── Controller
│   │   │   │   └── Service
│   │   │   ├── ControllerApi
│   │   │   ├── Migration
│   │   │   ├── Model
│   │   │   │   ├── Builder
│   │   │   │   ├── Collection
│   │   │   │   └── Traits
│   │   │   ├── Test
│   │   │   │   ├── Factory
│   │   │   │   ├── Feature
│   │   │   │   └── Unit
│   │   │   └── Validate
│   │   └── User
│   │       ├── Action
│   │       ├── Command
│   │       ├── Controller
│   │       │   └── Service
│   │       ├── ControllerApi
│   │       ├── Exception
│   │       ├── Fractal
│   │       ├── Middleware
│   │       ├── Model
│   │       │   ├── Builder
│   │       │   ├── Collection
│   │       │   └── Traits
│   │       ├── Test
│   │       └── Validate
│   ├── Exceptions
│   ├── Http
│   │   └── Middleware
│   ├── Providers
│   ├── Services
│   │   ├── Buffer
│   │   ├── Captcha
│   │   ├── Chrono
│   │   ├── Command
│   │   ├── Compress
│   │   ├── Csv
│   │   ├── Curl
│   │   ├── Database
│   │   ├── Filesystem
│   │   ├── Gpx
│   │   ├── Helper
│   │   │   └── Traits
│   │   ├── Html
│   │   │   └── Traits
│   │   ├── Locate
│   │   ├── Logger
│   │   ├── Protocol
│   │   ├── Request
│   │   ├── Server
│   │   ├── Telegram
│   │   ├── Translator
│   │   ├── Validator
│   │   └── View
│   └── View
│       └── Components
├── bootstrap
│   └── cache
├── config
├── database
│   ├── migrations
│   ├── schema
│   └── Seeders
├── public
│   ├── build
│   └── storage
└── resources
    ├── lang
    │   ├── en_US
    │   ├── es_ES
    │   ├── fr_FR
    │   ├── pt_BR
    │   ├── he_IL
    │   └── ar_AE
    └── views
        ├── assets
        ├── components
        ├── domains
        │   └── <DOMAIN>
        │       └── molecules
        ├── layouts
        │   └── molecules
        ├── mail
        └── molecules
```

### 2.1 Core domains

| Layer             | Purpose                                                                               |
| ----------------- | ------------------------------------------------------------------------------------- |
| **Core**          | Pure, framework-level abstractions (re-usable anywhere).                              |
| **CoreApp**       | Extends **Core** with project-specific traits, helpers and base classes.              |
| **Other domains** | **Must** extend CoreApp abstractions (e.g. `ModelAbstract`, `ControllerWebAbstract`). |

Main business domains in this project include `Vehicle`, `Device`, `Trip`, `Position`, `Refuel`, `Maintenance`, `MaintenanceItem`, `Expense`, `ExpenseCategory`, `Alarm`, `AlarmNotification`, `Server`, `File`, `User`, `City`, `State`, `Country`, `Timezone`, and related support domains.

### 2.2 New domain skeleton

Minimum files for a new domain `Foo` (copy these exact patterns):

| File | Content |
|------|---------|
| `Model/Foo.php` | Extends `CoreApp\Model\ModelAbstract`; `$table` + `TABLE` + `FOREIGN` constants, `$casts`, `newCollection()` / `newEloquentBuilder()` overrides, relationships (see §5). |
| `Model/Builder/Foo.php` | Extends `CoreApp\Model\Builder\BuilderAbstract`; `$searchLike`, `$simpleOrder`, `$simpleOrderDefault` + `by*/when*/where*/with*` methods (see §5b). |
| `Model/Collection/Foo.php` | Usually an **empty class** extending `CoreApp\Model\Collection\CollectionAbstract`. |
| `Action/ActionAbstract.php` | Extends `CoreApp\Action\ActionAbstract`; only declares `protected ?Model $row;`. |
| `Action/ActionFactory.php` | Extends `Core\Action\ActionFactoryAbstract`; declares `protected ?Model $row;` + one public method per capability. |
| `Validate/ValidateFactory.php` | **Empty class** extending `Core\Validate\ValidateFactoryAbstract` (methods resolve dynamically, see §3.2). |
| `Validate/{Operation}.php` | One class per action with a payload, extending `Core\Validate\ValidateAbstract` with a `rules()` method. |
| `Controller/ControllerAbstract.php` | Extends `CoreApp\Controller\ControllerWebAbstract`; declares `protected ?Model $row;` and the `row(int $id)` loader (below). |
| `Controller/router.php` | Web routes inside a `Route::group(['middleware' => ['user-auth']])` (add role middleware when needed). |
| `Fractal/FractalFactory.php` | Only when the domain is exposed via API or cross-domain fractals (see §5c). |
| `Controller/Service/*.php` | One service per controller that renders a view (see §4.2). |

The shared row loader (user/manager scoping + translated 404) lives in the domain `Controller/ControllerAbstract.php`:

```php
protected function row(int $id): Model
{
    return $this->row = Model::query()
        ->byId($id)
        ->byUserOrManager($this->auth)
        ->firstOr(fn () => $this->exceptionNotFound(__('foo.error.not-found')));
}
```

Method ordering: keep methods **alphabetical** in `ActionFactory` and `Model/Builder/*` classes. Controllers order methods by flow (`__invoke()` first, then `data()`, then the `actionPost()` handlers).

---

## 3 · Execution pipeline

| Layer              | Key classes (per domain)                                                                                           | Responsibility                                                                                                                                      |
| ------------------ | ------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| Controller         | `App\Domains\<Domain>\Controller\*` extends `App\Domains\CoreApp\Controller\ControllerWebAbstract`                   | Accept the HTTP request, gate POST actions via `actionPost()`, set page metadata and delegate all business work to services and actions.            |
| Controller service | `App\Domains\<Domain>\Controller\Service\*` extends `App\Domains\CoreApp\Controller\Service\ControllerAbstract`      | Assemble the view data (select options, counters, filters), merge persisted values back into the request and keep controllers thin.                 |
| Action factory     | `App\Domains\<Domain>\Action\ActionFactory` extends `App\Domains\Core\Action\ActionFactoryAbstract`                  | Share request/auth/row context via the `Factory` trait, expose one public method per capability, wire validation results into the target action.   |
| Validate           | `App\Domains\<Domain>\Validate\ValidateFactory` + `Validate\*` extends `App\Domains\Core\Validate\ValidateAbstract`  | Transform route parameters + payload into sanitized arrays using Laravel rules; only validated data reaches the action layer.                       |
| Action             | `App\Domains\<Domain>\Action\*` extends `App\Domains\CoreApp\Action\ActionAbstract` (and domain-specific abstracts)  | Execute business logic (`data()`, `check()`, `save()`, dispatch jobs, log), optionally reuse other factories, and return models/DTOs upstream.     |

### 3.1 Controller and service handshake

`ControllerAbstract` inherits the `Factory` trait, so `$this->action()` automatically bootstraps the correct `ActionFactory` with the current request, authenticated user and `$this->row`. Public `__invoke()` methods typically:

1. Load the row (when applicable) through helpers such as `row($id)`.
2. Call `$this->actionPost([...])` (or sequential `$this->actionPost('update') ?: $this->actionPost('delete')`) to route form submissions to protected handlers.
3. Build the view payload via a controller service, keeping view-model assembly outside the controller.

Services receive the same request/auth context and can call `requestMergeWithRow()` (from `ControllerWebAbstract`) to pre-fill the request with persisted values. Subsequent submissions therefore carry the stored state automatically, which is critical in update forms such as vehicle or maintenance.

### 3.2 Action factory and validation

`ActionFactoryAbstract` merges route parameters with `Request::all()` before validation runs. Each public method follows the same pattern:

1. `$validated = $this->validate()->operation();` → dynamic proxy (`ValidateFactoryAbstract::__call`) to the matching class inside `Validate\*` (`operation()` → `Validate\Operation`), which applies Laravel rules and returns a sanitized array. The domain `ValidateFactory` is therefore an **empty class** extending `Core\Validate\ValidateFactoryAbstract` — never add methods to it.
2. `return $this->actionHandle(Operation::class, $validated);` → instantiates the action with the request, the authenticated user, the current row (when available) and the validated dataset. Use `actionHandleTransaction()` instead when the action performs multiple writes that must stay atomic. Actions with no payload skip validation: `return $this->actionHandle(Delete::class);`.

Because validators live beside each domain, new rules never leak into controllers or actions. If a capability has multiple variants, each variant gets its own validator and the factory selects it explicitly.

**`$this->data` keys from the operation’s validator.** The validator output passes through `App\Services\Validator\Data`, which defines **every** declared rule key (nullable rules still yield a defined key, often `null`) and casts values by rule type (`integer`, `boolean`, `string`, `array`, `numeric`). Do **not** use `$this->data['field'] ?? null` for those keys — use `$this->data['field']` directly. Reserve null-coalescing for inputs that did not pass through that validator (for example ad-hoc arrays built in a job or command). Keys starting with `_` (`_action`, `_token`) are stripped.

**Forwarded keys must be declared.** When a job, command or scheduler hands data back into an action, every forwarded key has to appear as a rule in the action's `Validate\*` class. The validator strips any key not in the rule set, so undeclared keys silently disappear before `$this->data` reaches the action.

### 3.3 Action orchestration

Actions extend `App\Domains\CoreApp\Action\ActionAbstract`, gaining consistent helpers for transactions, retries, logging and exception handling. Domain-specific base classes (e.g. `Maintenance\Action\CreateUpdateAbstract`, `Refuel\Action\CreateUpdateAbstract`, `User\Action\CreateUpdateAbstract`) implement shared steps such as `data()`, `check()` and `save()`, so concrete actions only describe the unique behavior.

#### CreateUpdateAbstract pattern

Shared create/update logic lives in a domain-specific `CreateUpdateAbstract`. Concrete `Create` and `Update` classes only implement `save()`.

```php
abstract protected function save(): void;

public function handle(): Model
{
    $this->data();
    $this->check();
    $this->save();
    $this->files();   // Optional: related uploads, jobs, sync
    $this->expense(); // Optional: cross-domain side effects

    return $this->row;
}
```

#### Naming conventions inside actions

| Pattern | Purpose | Example |
|---------|---------|---------|
| `data{Property}()` | Transform a single field or logical group | `dataUserId()`, `dataPoint()`, `dataPositionId()` |
| `check{Property}()` | Business rule check, throw `exceptionValidator()` on failure | `checkVehicle()`, `checkVehicleId()` |
| `save{Concern}()` | Persist main model or related entities | `saveRow()`, `saveItems()` |

- Mutate `$this->data` directly in `data*()` methods.
- Run `data()` before `check()` — checks operate on already-transformed data.
- `saveRow()` persists the main model; additional `save{Concern}()` methods handle relations.
- Cross-domain saves use Factory: `$this->factory('File')->action($data)->upload()`.
- Reuse the shared `data*()` helpers from `CoreApp\Action\ActionAbstract` instead of re-implementing them: `dataUserId()` (resolves `user_id` from row, manager mode, or auth).

### 3.4 Request walkthrough (generic)

1. Router resolves to `App\Domains\<Domain>\Controller\Create`.
2. `ControllerAbstract::__construct()` stores the request and authenticated user, then runs `init()` to share default view data.
3. `Create::__invoke()` renders `Controller\Service\Create::data()` on GET; on POST it triggers `$this->actionPost('create')`.
4. The protected `create()` handler calls `$this->action()->create()`.
5. `ActionFactory::create()` validates the dataset and instantiates `Action\Create` with the sanitized payload.
6. `Action\Create::handle()` runs domain logic, persists changes (including related entities, files, jobs) and returns the resulting model.
7. The controller flashes a status message and redirects (or returns JSON) based on the action’s response.

This pipeline powers every domain, ensuring consistent auditing, validation and logging regardless of complexity.

### 3.5 Factory cross-domain communication

The `Factory` trait provides `$this->factory()` for cross-domain operations. Available in Actions, Controllers, Services and Fractals.

```php
// Same domain (inherits current request, auth, row)
$this->factory()->action($data)->create();

// Different domain (row auto-set to null)
$this->factory('File')->action($data)->upload();

// Different domain with explicit row
$this->factory('Vehicle', $vehicleModel)->action($data)->update();
```

Available methods:

```php
$this->factory('Domain')->action($data)          // ActionFactory
$this->factory('Domain')->validate($data)        // ValidateFactory
$this->factory('Domain')->fractal($view, $data)  // Transformed array
$this->factory('Domain')->mail()                 // MailFactory
```

Context propagation: `request` and `auth` are always forwarded. `row` is forwarded only within the same domain; `null` for other domains. Domain is inferred from the calling class namespace when not specified.

---

## 4 · Controllers

| Type               | Responsibilities                                                                                         |
| ------------------ | -------------------------------------------------------------------------------------------------------- |
| **Web Controller** | Route handling, auth, and delegating to an **Action**.  View preparation goes to `Controller\Service\*`. |
| **API Controller** | Same, but returns JSON via **Fractal** transformers. Keep thin.                                          |

### 4.1 Web controller dispatch

Web controllers are invokable (one action per class). `__invoke()` handles both GET (render) and POST (action dispatch).

```php
public function __invoke(int $id): Response|RedirectResponse
{
    $this->row($id);

    if ($response = $this->actionPost('update') ?: $this->actionPost('delete')) {
        return $response;
    }

    $this->meta('title', __('vehicle-update.meta-title', ['title' => $this->row->name]));

    return $this->page('vehicle.update', $this->data());
}
```

- `actionPost()` checks if request is POST and matches `_action` input field; dispatches to the matching protected method.
- Protected methods call `$this->action()` and always redirect after POST (PRG pattern).
- Flash messages via `$this->sessionMessage('success'|'error', $message)`.
- `page()` resolves to `resources/views/domains/{view}.blade.php` (dots become path segments).
- `meta()` sets page metadata via LaravelMeta facade.
- `data()` delegates to `Controller\Service` class.

### 4.2 Controller service layer

Controller services prepare view data. Live in `Controller/Service/{Action}.php`.

```php
class Update extends ServiceAbstract
{
    public function __construct(
        protected Request $request,
        protected Authenticatable $auth,
        protected Model $row
    ) {
        $this->requestMergeWithRow();
    }

    public function data(): array
    {
        return [
            'row' => $this->row,
            'vehicles' => $this->vehicles(),
            'devices' => $this->devices(),
        ];
    }
}
```

- `requestMergeWithRow()` pre-fills form fields from the model (request input wins, then explicit data, then row attributes as fallback). Call in constructor for update/edit services.
- Request helpers: `requestInteger()`, `requestString()`, `requestBool()`, `requestArray()`.
- Built-in CoreApp helpers: `vehicles()`, `devices()`, `users()`, `user()`, `vehicle()`, `device()` (with preference/filter caching for manager mode).
- API services (`ControllerApi/Service/`) return raw query results (no options, no merge).

### 4.3 API controller patterns

API controllers live in `ControllerApi/`. Always return `JsonResponse`.

```php
class Index extends ControllerApiAbstract
{
    public function __invoke(): JsonResponse
    {
        return $this->json(
            $this->factory()->fractal('json', $this->data())
        );
    }
}
```

- **Pagination**: accept `limit` query param when the service supports it; keep caps explicit.
- **Response patterns**: single item → `fractal('json', $model)`, collection → `fractal('json', $paginator)`, mutation → `fractal('json', $this->action()->create())`.

### 4.4 Route conventions

Each domain owns its routes in `Controller/router.php` (web) and `ControllerApi/router.php` (API).

| Scope | Naming | Example |
|-------|--------|---------|
| Web | `{domain}.{action}` | `vehicle.index`, `vehicle.update` |
| API | `api.{domain}.{action}` | `api.vehicle.index` |

- Web forms use `Route::any()` (GET renders, POST dispatches via `actionPost()`).
- Web routes are wrapped in `Route::group(['middleware' => ['user-auth']])`; add role middleware (`user.admin`, `user.manager-mode`, …) when needed. API auth uses `user.auth.api`.
- Web `{id}` is always `int`. Constrain extra numeric params with `->where('param', '[0-9]+')`.
- Permission failures return **404** (not 403) to avoid revealing resource existence.

## 5 · Models & persistence

| Topic                  | Guideline                                                                |
| ---------------------- | ------------------------------------------------------------------------ |
| **Base Class**         | Extend `App\Domains\CoreApp\Model\ModelAbstract`.                        |
| **Constants**          | Define `public const TABLE` and `public const FOREIGN`.                  |
| **Builder/Collection** | Create companion classes in `Model\Builder` and `Model\Collection`.      |
| **JSON Columns**       | Use `JsonColumn` trait and `jsonColumn()` helper for typed, safe access. |
| **Keep Thin**          | Relationships and trivial attribute logic only—no business rules.        |

### 5.1 Mandatory overrides

Every model **must** override `newCollection()` and `newEloquentBuilder()` to use its own Builder and Collection classes:

```php
protected $table = 'vehicle';
public const TABLE = 'vehicle';
public const FOREIGN = 'vehicle_id';

public function newCollection(array $models = []): Collection
{
    return new Collection($models);
}

public function newEloquentBuilder($query): Builder
{
    return new Builder($query);
}
```

### 5.2 Inherited defaults (do not override)

| Setting | Value | Why |
|---------|-------|-----|
| `$timestamps` | `false` | Timestamps set explicitly in actions for predictability |
| `$guarded` | `[]` | Validation happens in Validate layer, not model |
| `$snakeAttributes` | `false` | Properties stay camelCase as-is |
| `MutatorDisabledTrait` | used | No magic get/set, explicit transformations only |
| `DateDisabledTrait` | used | No auto date casting |
| `CacheBuilderTrait` | used | Query caching at CoreApp level |

- Relationships use `static::FOREIGN` for foreign key references.
- Use `$casts` for type coercion (boolean, array, etc.).
- Use `$hidden` for sensitive fields (password, tokens).

---

## 5b · Builder conventions

Extend `CoreApp\Model\Builder\BuilderAbstract`. Always prefix columns with `$this->addTable()` to avoid ambiguity in joins.

### Properties

```php
protected array $searchLike = ['name', 'plate'];       // Columns for bySearch() LIKE
protected array $simpleOrder = ['id', 'name'];         // Allowed order columns
protected array $simpleOrderDefault = ['id', 'DESC'];  // Default order
protected array $simpleSelect = ['id', 'name'];        // Default select columns
protected array $relationOrder = ['name', 'ASC'];      // Order when used as relation
protected array $relationSelect = ['id', 'name'];      // Select when used as relation
```

### Method prefixes

| Prefix | Purpose | Example |
|--------|---------|---------|
| `by{Property}()` | Filter by a specific value | `byUserId(int $user_id)`, `byVehicleId(int $vehicle_id)` |
| `where{Property}()` | Filter by boolean/status | `whereEnabled(bool $enabled = true)` |
| `when{Property}()` | Conditional filter (apply only if value is truthy) | `whenSearch(?string $search)`, `whenUserId(?int $user_id)` |
| `with{Relation}()` | Eager-load a relation | `withTimezone()`, `withDevices()` |
| `select{View}()` | Column selection preset | `selectRelated()`, `selectSimple()` |
| `orderBy{Property}()` | Ordering | `orderByName()`, `orderByDateAtDesc()` |
| `list{View}()` | Combined select + order shortcut | `listSimple()` |

### User / manager filtering

Use `byUserOrManager(UserModel $user)` (and related `byUserId()` / manager-mode helpers) to scope queries. Prefer existing CoreApp builder methods over ad-hoc role checks in controllers.

### Request-based filtering

Use `byRequest(Request $request)` to apply multiple filters from query params. Use `byRequestValue()` for type-safe extraction.

---

## 5c · Fractal transformers

Extend `Core\Fractal\FractalAbstract`. One `FractalFactory` class per domain.

### View methods

Each protected method defines a transformation "view":

| Method | Purpose |
|--------|---------|
| `json(Model $row)` | Full API response |
| `related(Model $row)` | FK reference (id + label) |
| `map(Model $row)` | Map / live tracking payload |
| `simple(Model $row)` | Minimal fields (when needed) |

Called via: `$this->factory('Vehicle')->fractal('json', $data)`.

### Cross-domain references

```php
'timezone' => $this->from('Timezone', 'related', $row->timezone),
'device' => $this->fromIfLoaded('Device', 'related', $row, 'device'),
'vehicle' => $this->fromIfLoadedOrId('Vehicle', 'related', $row, 'vehicle'),
```

- `from()` — always resolved.
- `fromIfLoaded()` — only if the relation was eager-loaded.
- `fromIfLoadedOrId()` — eager-loaded or fallback to `{id: N}`.

### Pagination envelope

Paginated results auto-wrap: `{ data: [...], pages, page, offset, total }`. `transform()` handles null, Collection, LengthAwarePaginator and arrays automatically. View methods receive single model instances, never collections.

---

## 5d · Migrations

- **Never use `->after()` or `->before()`** when adding columns. Reordering forces a full table rewrite and causes a major lock on large tables. Add new columns without positional hints.
- Migrations are anonymous classes extending `CoreApp\Migration\MigrationAbstract` and are **idempotent**: `up()` returns early via an `upMigrated()` guard (`Schema::hasColumn(...)` / `Schema::hasTable(...)`) before calling table helpers; `down()` reverts.

```php
return new class() extends MigrationAbstract {
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->keys();
    }

    protected function upMigrated(): bool
    {
        return Schema::hasTable('expense');
    }

    protected function tables(): void
    {
        Schema::create('expense', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->decimal('amount', 10, 2)->default(0);
            $table->date('date_at')->index();
            $this->timestamps($table);
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense');
    }
};
```

- Column naming: keep related columns under a shared prefix so they group together; model/builder method names derive from the column. Field labels live in `resources/lang/*/{domain}.php` under the `db` group keyed by the exact column name.

---

## 6 · Validation guidelines

* Validation rules live in `Validate/` and are invoked via the domain’s `ValidateFactory`.
* Controllers **never** hold validation logic. Laravel FormRequest is **not** used in this project.
* Each `Validate\*` class extends `Core\Validate\ValidateAbstract` and implements `rules()`.
  Extend `CoreApp\Validate\ValidateAbstract` only when you need `ruleCsrf()` or the
  `rulesUpdateOnly()` helpers.
* Rule arrays always start with `'bail'`, then the type, then presence:
  `'name' => ['bail', 'string', 'required']`, `'vehicle_id' => ['bail', 'integer', 'required']`.
  Nested arrays use dotted keys (`'files.*' => ['bail', 'file']`).
* Custom rule objects live in `Core\Validate\Rule` / `CoreApp\Validate\Rule` and are used
  inside `rules()`.
* Every rule gets a translated message in `messages()` using a **literal** lang key
  (`__('maintenance-create.error.vehicle-not-found')`), never a generated one (see conventions §10).

---

## 6b · Translations

* `resources/lang/` holds **6 locales**: `en_US`, `es_ES`, `fr_FR`, `pt_BR`, `he_IL`, `ar_AE`
  (see `config('app.locales')`).
* Any new lang key is added to **all locales**, keeping the keys in **alphabetical order**
  inside their group.
* Use `composer translation` (`core:translation:fix` + `fill` + `clean` + `unused`) to
  keep locale files aligned; do not invent dynamic `__()` keys.
* Validator / action error messages follow per-domain patterns such as
  `maintenance-create.error.vehicle-not-found` or `refuel-create.error.vehicle-exists`
  and reuse existing keys when the field/rule already has one.

---

## 7 · Services (cross-domain utilities)

| Area                   | Notes                                                                                                                                                                                                                                            |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **Location**           | `app/Services` with optional sub-namespaces (e.g. `Protocol`, `Gpx`, `Locate`).                                                                                                                                                                  |
| **Global helpers**     | `helper()` → `App\Services\Helper\Helper` for pure utilities (`helper()->unit()`, `helper()->unitHuman()`, `helper()->timeHuman()`, date helpers); `service()` → `App\Services\Helper\Service` (`service()->message()->error(...)`).          |
| **Container bindings** | `app('user')`, `app('language')` expose the current context outside HTTP requests; jobs and commands bind them before calling actions when needed.                                                                                               |
| **HTTP Requests**      | Always go through `App\Services\Curl\Curl` for unified logging, caching, error handling.                                                                                                                                                         |
| **GPS / protocol**     | Device protocol parsing and server I/O live under `App\Services\Protocol` and `App\Services\Server`. GPX import/export under `App\Services\Gpx`. Geocoding / reverse lookup under `App\Services\Locate`.                                       |
| **Messaging**          | Telegram notifications via `App\Services\Telegram`.                                                                                                                                                                                              |

---

## 8 · Asynchronous processing

| Tool                 | Usage                                                                       |
| -------------------- | --------------------------------------------------------------------------- |
| **Jobs (Queue)**     | Place under `Job/`; name verb-first (`UpdateCity`, `GenerateReport`).       |
| **Dispatch**         | From an **Action**, preferably after persistence succeeds.                  |
| **Retry & Failures** | Configure backoff and failed-job handling per Laravel-queue best practices. |

Example (from `Refuel\Action\CreateUpdateAbstract`):

```php
protected function job(): void
{
    UpdateCityJob::dispatch($this->row->id);
}
```

---

## 9 · Domain-specific components

| Folder        | Purpose                                                         |
| ------------- | --------------------------------------------------------------- |
| `Mail/`       | Mailable classes scoped to the domain.                          |
| `Middleware/` | HTTP / API middleware that affects only this domain.            |
| `Exception/`  | Domain-specific exceptions to avoid leaking internal semantics. |

### 9.1 Domain middleware pattern

Cross-cutting route gates (feature flags, availability checks) belong in **middleware**, not in controller `check()` methods or duplicated action checks:

1. Create `Middleware/MiddlewareAbstract.php` in the domain (extends `Core\Middleware\MiddlewareAbstract`, declares `protected ?Model $row;` when needed).
2. Create the concrete middleware with a `handle(Request $request, Closure $next): mixed` that redirects or fails with `abort(404)`.
3. Register the alias in `app/Http/Kernel.php` → `$middlewareAliases`, named `{domain-kebab}.{feature-kebab}` (e.g. `vehicle.available`, `user.admin`), keeping the list alphabetical.
4. Apply it in the router group: `Route::group(['middleware' => ['user-auth', 'vehicle.available']], ...)`.

`Core\Middleware\MiddlewareAbstract::__construct` only stores the request — `$this->auth` is **not** populated automatically. Assign it in `handle()` before use when needed (`$this->auth = $request->user();`), as `User\Middleware\*` does.

---

## 10 · Build & quality commands

| Composer Script        | What it does                                                    |
| ---------------------- | --------------------------------------------------------------- |
| `composer fix`         | Formats code with php-cs-fixer + pint.                          |
| `composer quality`     | Runs PHP Insights, PHPStan and Psalm.                           |
| `composer translation` | Fixes, fills, cleans and reports unused translation strings.    |

---

## 11 · Quality checklist (pre-merge)

* [ ] PSR-12 formatting & static analysers pass (`composer quality`).
* [ ] Strict types everywhere; no mixed or missing returns.
* [ ] Controllers < 100 LOC and contain **no** business rules.
* [ ] Logic extracted to **Action** (or **Service** if cross-domain).
* [ ] Builders / Collections created for each new model.
* [ ] New `Schedule\Manager` classes registered in `App\Console\Kernel::schedule()` (commands themselves are auto-discovered, see §16b).
* [ ] External packages approved by the team.
* [ ] Duplicate code eliminated or centralized.
* [ ] Env variables documented in `.env.example`.

---

## 12 · Refactoring heuristics

| Symptom                             | Move To                                                |
| ----------------------------------- | ------------------------------------------------------ |
| Large controller                    | **Action**                                             |
| Action orchestrates several domains | **Service**                                            |
| Domain logic duplicates             | Shared **Service** or **Trait**                        |
| Model performs business checks      | **Action**                                             |
| Giant `handle()`                    | Split into multiple smaller actions or private helpers |

---

## 13 · Example: real create action (`Maintenance\Action\Create`)

```php
<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;

class Create extends CreateUpdateAbstract
{
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'date_at' => $this->data['date_at'],
            'name' => $this->data['name'],
            'workshop' => $this->data['workshop'],
            'amount' => $this->data['amount'],
            'distance' => $this->data['distance'],
            'distance_next' => $this->data['distance_next'],
            'description' => $this->data['description'],
            'user_id' => $this->data['user_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ]);
    }
}
```

Shared parent (`CreateUpdateAbstract`) already runs `data()` → `check()` → `save()` → related side effects (`files()`, `expense()`). Patterns to copy: related rows are checked through builder methods (`VehicleModel::query()->byId()->byUserId()->exists()`); failures throw translated exceptions (`exceptionValidator(__('maintenance-create.error.vehicle-not-found'))`); cross-domain work uses `$this->factory('Expense')->action(...)->upsertFromMaintenance()`.

---

## 14 · Dependency & package policy

1. **Prefer native PHP** or in-house helpers over Laravel facades.
2. **No new Composer dependencies** without team approval.
3. Always search existing services / traits before adding code.

---

## 15 · Job infrastructure

Jobs extend `Core\Job\JobAbstract` (or a domain-specific `JobAbstract` that inherits from it).

**Jobs carry no business logic.** `handle()` only loads context (`row()`) and delegates to a single action method via `$this->factory()->action(...)->methodName()`. The same rule applies to commands. Anything more complex belongs in an action.

### 15.1 Standard job template

```php
class UpdateCity extends JobAbstract
{
    public function handle(): void
    {
        $this->factory(row: $this->row())->action()->updateCity();
    }
}
```

Domain `JobAbstract` typically stores `$id`, loads the row with `rowOrDeleteAndException(Model::class)`, and registers `$this->middlewareWithoutOverlapping()`.

### 15.2 Cross-domain job dispatch

Actions in one domain can dispatch jobs from another domain. The job must live in the **target** domain (e.g. `Refuel\Job\UpdateCity` dispatched from `Refuel\Action\*`).

### 15.3 Deduplication

For jobs that must not queue twice for the same entity, implement `ShouldBeUnique` with `public int $uniqueFor` and `uniqueId(): string` (usually `strval($this->id)`), and use `$this->middlewareWithoutOverlappingExpireAfter()`.

---

## 16 · Commands & scheduling

Commands are **auto-discovered**: `App\Console\Kernel::commands()` loads every `Domains/*/Command` folder — no manual registration.

- Each domain has a `Command/CommandAbstract.php` that declares `protected Model $row;` and a `row()` method (`findOrFail($this->checkOption('id'))` + any needed context bindings).
- Signature convention: `{domain}:{action} {--id=}` (e.g. `refuel:update:city {--id=}`).
- Like jobs, commands carry **no business logic**: log `[START]`, bind context, map CLI options into the request with `requestWithOptions()`, delegate to `$this->factory()->action()->methodName()`, log `[END]`.

```php
class UpdateCity extends CommandAbstract
{
    protected $signature = 'refuel:update:city {--id=}';

    protected $description = 'Update Refuel with Empty City';

    public function handle(): void
    {
        $this->info('[START]');

        $this->checkOptions(['id']);
        $this->requestWithOptions();
        $this->row();
        $this->factory()->action()->updateCity();

        $this->info('[END]');
    }
}
```

Scheduled work lives in `Schedule/Manager.php` per domain (extends `Core\Schedule\ScheduleAbstract`); each entry wraps a command with `$this->command(FooCommand::class)->everyTenMinutes()`. New `Schedule\Manager` classes **must be registered manually** in `App\Console\Kernel::schedule()` (see existing `Server`, `Position`, `Refuel`, `CoreMaintenance` managers).

---

## 17 · Action Formatting & Clean Code

Actions must be highly factored, efficient, clear, and simple. Avoid mixing multiple processes in the same method. Follow these strict rules:

1. **One query, one method**: Every database query (fetching IDs, hydrating models, etc.) must be encapsulated in its own dedicated method. Do not mix query logic with business logic.
2. **Extract `foreach` bodies**: The code inside a `foreach` loop must be extracted into its own method. Loops should only iterate and delegate.
3. **Top-down readability**: `handle()` should read like a table of contents, delegating to small, single-responsibility methods.
4. **Abstract classes only hold shared logic**: a method used by a single concrete subclass must live in that subclass, never in the abstract parent. Move it down as soon as it stops being reused.

### Example of a well-factored Action

```php
public function handle(): void
{
    $this->dispatch();
}

protected function dispatch(): void
{
    foreach ($this->models() as $model) {
        $this->processModel($model);
    }
}

protected function processModel(Model $model): void
{
    // Logic for a single model
}

protected function models(): Collection
{
    return Model::query()->byStatus('pending')->get();
}
```

---
