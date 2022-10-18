<?php declare(strict_types=1);

namespace App\Domains\Trip\Action\Traits;

trait SaveRow
{
    /**
     * @return void
     */
    protected function saveRowStartEnd(): void
    {
        $this->saveRowStartAt();
        $this->saveRowEndAt();
    }

    /**
     * @return void
     */
    protected function saveRowStartAt(): void
    {
        $position = $this->row->positions()->orderByDateUtcAtAsc()->first();

        $this->row->start_at = $position->date_at;
        $this->row->start_utc_at = $position->date_utc_at;
    }

    /**
     * @return void
     */
    protected function saveRowEndAt(): void
    {
        $position = $this->row->positions()->orderByDateUtcAtDesc()->first();

        $this->row->end_at = $position->date_at;
        $this->row->end_utc_at = $position->date_utc_at;
    }

    /**
     * @return void
     */
    protected function saveRowName(): void
    {
        if ($this->row->nameIsDefault()) {
            $this->row->name = $this->row->start_at.' - '.$this->row->end_at;
        }
    }

    /**
     * @return void
     */
    protected function saveRowSave(): void
    {
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function saveRowDistanceTime(): void
    {
        $this->row->updateDistanceTime();
    }
}
