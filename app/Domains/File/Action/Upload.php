<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use Throwable;
use App\Domains\File\Model\File as Model;
use App\Domains\File\Model\Collection\File as Collection;

class Upload extends ActionAbstract
{
    /**
     * @var \App\Domains\File\Model\Collection\File
     */
    protected Collection $list;

    /**
     * @return \App\Domains\File\Model\Collection\File
     */
    public function handle(): Collection
    {
        $this->list();
        $this->iterate();

        return $this->list;
    }

    /**
     * @return void
     */
    protected function list(): void
    {
        $this->list = new Collection();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->data['files'] as $file) {
            try {
                $this->file($file);
            } catch (Throwable $e) {
                report($e);
            }
        }
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function file(array $file): void
    {
        if (empty($file['id'])) {
            $this->create($file);
        } elseif (empty($file['delete'])) {
            $this->update($file);
        } else {
            $this->delete($file);
        }
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function create(array $file): void
    {
        if (empty($file['file'])) {
            return;
        }

        $this->list->push($this->factory('File')->action($this->createData($file))->create());
    }

    /**
     * @param array $file
     *
     * @return array
     */
    protected function createData(array $file): array
    {
        return [
            'file' => $file['file'],
            'related_table' => $this->data['related_table'],
            'related_id' => $this->data['related_id'],
            'user_id' => $this->data['user_id'],
        ];
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function update(array $file): void
    {
        if (empty($file['file'])) {
            return;
        }

        $this->list->push($this->factory('File', $this->row($file))->action($this->updateData($file))->update());
    }

    /**
     * @param array $file
     *
     * @return array
     */
    protected function updateData(array $file): array
    {
        return [
            'file' => $file['file'],
        ];
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function delete(array $file): void
    {
        $this->factory('File', $this->row($file))->action()->delete();
    }

    /**
     * @param array $file
     *
     * @return \App\Domains\File\Model\File
     */
    protected function row(array $file): Model
    {
        return Model::query()
            ->byRelated($this->data['related_table'], $this->data['related_id'])
            ->byId(intval($file['id']))
            ->firstOrFail();
    }
}
