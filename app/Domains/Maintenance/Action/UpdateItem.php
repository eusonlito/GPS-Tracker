<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Maintenance\Model\MaintenanceMaintenanceItem as MaintenanceMaintenanceItemModel;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as MaintenanceItemModel;

class UpdateItem extends ActionAbstract
{
    /**
     * @var array
     */
    protected array $maintenanceItemIds = [];

    /**
     * @return \App\Domains\Maintenance\Model\Maintenance
     */
    public function handle(): Model
    {
        $this->data();
        $this->maintenanceItemIds();
        $this->lines();
        $this->delete();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataUserId();
    }

    /**
     * @return void
     */
    protected function maintenanceItemIds(): void
    {
        if (empty($this->data['maintenance_item_id'])) {
            return;
        }

        $this->maintenanceItemIds = MaintenanceItemModel::query()
            ->byIds($this->data['maintenance_item_id'])
            ->byUserId($this->data['user_id'])
            ->pluck('id')
            ->all();
    }

    /**
     * @return void
     */
    protected function lines(): void
    {
        $this->data['lines'] = [];

        foreach ($this->data['maintenance_item_id'] as $index => $maintenance_item_id) {
            if ($line = $this->linesIndex($index)) {
                $this->data['lines'][$maintenance_item_id] = $line;
            }
        }
    }

    /**
     * @param int $index
     *
     * @return ?array
     */
    protected function linesIndex(int $index): ?array
    {
        return $this->linesIndexIsValid($data = $this->linesIndexData($index)) ? $data : null;
    }

    /**
     * @param int $index
     *
     * @return array
     */
    protected function linesIndexData(int $index): array
    {
        $data = [
            'maintenance_item_id' => $this->data['maintenance_item_id'][$index] ?? null,
            'quantity' => $this->data['quantity'][$index] ?? 0,
            'amount_gross' => $this->data['amount_gross'][$index] ?? 0,
            'tax_percent' => $this->data['tax_percent'][$index] ?? 0,
        ];

        $data['amount_net'] = $data['amount_gross'] * (1 + $data['tax_percent'] / 100);
        $data['subtotal'] = $data['quantity'] * $data['amount_gross'];
        $data['tax_amount'] = $data['subtotal'] * $data['tax_percent'] / 100;
        $data['total'] = $data['subtotal'] + $data['tax_amount'];

        $data['amount_net'] = round($data['amount_net'], 2);
        $data['subtotal'] = round($data['subtotal'], 2);
        $data['tax_amount'] = round($data['tax_amount'], 2);
        $data['total'] = round($data['total'], 2);

        return $data;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    protected function linesIndexIsValid(array $data): bool
    {
        return in_array($data['maintenance_item_id'], $this->maintenanceItemIds)
            && $data['quantity']
            && $data['amount_gross'];
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        if (empty($this->data['lines'])) {
            return;
        }

        MaintenanceMaintenanceItemModel::query()
            ->byMaintenanceId($this->row->id)
            ->byMaintenanceItemIdsNot(array_keys($this->data['lines']))
            ->delete();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        foreach ($this->data['lines'] as $line) {
            $this->saveLine($line);
        }
    }

    /**
     * @param array $line
     *
     * @return void
     */
    protected function saveLine(array $line): void
    {
        MaintenanceMaintenanceItemModel::query()->updateOrInsert([
            'maintenance_id' => $this->row->id,
            'maintenance_item_id' => $line['maintenance_item_id'],
        ], [
            'quantity' => $line['quantity'],
            'amount_gross' => $line['amount_gross'],
            'amount_net' => $line['amount_net'],
            'tax_percent' => $line['tax_percent'],
            'tax_amount' => $line['tax_amount'],
            'subtotal' => $line['subtotal'],
            'total' => $line['total'],
        ]);
    }
}
