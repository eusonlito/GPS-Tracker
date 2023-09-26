<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Action\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait LogRow
{
    /**
     * @param \Illuminate\Database\Eloquent\Model|array|null $row
     *
     * @return void
     */
    protected function logRow(Model|array|null $row = null): void
    {
        $this->factory('Log')->action([
            'class' => $this::class,
            'payload' => $this->logRowPayload(),
            'related' => $this->logRowRelated($row ??= $this->row),
        ])->create();
    }

    /**
     * @return array
     */
    protected function logRowPayload(): array
    {
        return [
            'data' => $this->data,
            'request' => $this->logRowPayloadRequest(),
        ];
    }

    /**
     * @return array
     */
    protected function logRowPayloadRequest(): array
    {
        return [
            'url' => $this->request?->fullUrl(),
            'parameters' => $this->request?->route()?->parameters(),
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|array|null $row
     *
     * @return array
     */
    protected function logRowRelated(Model|array|null $row): array
    {
        if ($row === null) {
            return [];
        }

        if (is_array($row)) {
            return array_map($this->logRowRelatedRow(...), $row);
        }

        return [$this->logRowRelatedRow($row)];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $row
     *
     * @return array
     */
    protected function logRowRelatedRow(Model $row): array
    {
        return [
            'related_table' => $row->getTable(),
            'related_id' => $row->id,
            'payload' => ['row' => $row->withoutRelations()->toArray()],
        ];
    }

    /**
     * @param \Illuminate\Support\Collection $rows
     *
     * @return void
     */
    protected function logRows(Collection $rows): void
    {
        foreach ($rows as $row) {
            $this->logRow($row);
        }
    }
}
