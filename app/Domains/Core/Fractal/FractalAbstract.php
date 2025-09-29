<?php declare(strict_types=1);

namespace App\Domains\Core\Fractal;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Traits\Factory;

abstract class FractalAbstract
{
    use Factory;

    final public function transform(string $function, $value, ...$args): ?array
    {
        if ($value === null) {
            return null;
        }

        if (empty($value)) {
            return [];
        }

        if ($value instanceof Collection) {
            return $this->collection($function, $value, $args);
        }

        if ($value instanceof LengthAwarePaginator) {
            return $this->paginated($function, $value, $args);
        }

        if ($this->isArraySequential($value)) {
            return $this->sequential($function, $value, $args);
        }

        return $this->call($function, $value, $args);
    }

    final protected function isArraySequential($value): bool
    {
        return is_array($value)
            && ($keys = array_keys($value))
            && ($keys === array_keys($value));
    }

    final protected function collection(string $function, Collection $value, array $args): array
    {
        return $value
            ->toBase()
            ->map(fn ($each) => $this->call($function, $each, $args))
            ->values()
            ->toArray();
    }

    final protected function paginated(string $function, LengthAwarePaginator $value, array $args): array
    {
        return [
            'data' => $this->transform($function, $value->items(), ...$args),
            'pages' => $value->lastPage(),
            'page' => $value->currentPage(),
            'offset' => $value->perPage(),
            'total' => $value->total(),
        ];
    }

    final protected function sequential(string $function, array $value, array $args): array
    {
        return array_map(fn ($each) => $this->call($function, $each, $args), array_values($value));
    }

    final protected function call(string $function, $value, array $args): ?array
    {
        return $this->$function($value, ...$args);
    }

    final protected function from(string $domain, string $view, $data, ...$args): ?array
    {
        return $this->factory($domain)->fractal($view, $data, ...$args);
    }

    final protected function fromIfLoaded(string $domain, string $view, ModelAbstract $row, string $relation, ...$args): ?array
    {
        if ($row->relationLoaded($relation) === false) {
            return null;
        }

        return $this->from($domain, $view, $row->$relation, ...$args);
    }

    final protected function fromIfLoadedOrId(string $domain, string $view, ModelAbstract $row, string $relation, ...$args): ?array
    {
        $return = $this->fromIfLoaded($domain, $view, $row, $relation, ...$args);

        if ($return) {
            return $return;
        }

        $id = $row->{$relation.'_id'};

        if ($id) {
            return ['id' => $id];
        }

        return null;
    }
}
