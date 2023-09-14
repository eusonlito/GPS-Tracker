<?php declare(strict_types=1);

namespace App\Domains\File\Action\Traits;

use App\Domains\File\Model\File as Model;

trait RelatedCreateUpdate
{
    /**
     * @return void
     */
    protected function files(): void
    {
        foreach ($this->filesInput() as $file) {
            try {
                $this->file($file);
            } catch (Throwable $e) {
                report($e);
            }
        }
    }

    /**
     * @return array
     */
    protected function filesInput(): array
    {
        return array_slice($this->request->all('files')['files'] ?? [], 0, 6);
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function file(array $file): void
    {
        if (empty($file['id'])) {
            $this->fileCreate($file);
        } elseif (empty($file['delete'])) {
            $this->fileUpdate($file);
        } else {
            $this->fileDelete($file);
        }
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function fileCreate(array $file): void
    {
        if (empty($file['file'])) {
            return;
        }

        $this->factory('File')->action($this->fileCreateData($file))->create();
    }

    /**
     * @param array $file
     *
     * @return array
     */
    protected function fileCreateData(array $file): array
    {
        return [
            'file' => $file['file'],
            'related_table' => $this->row->getTable(),
            'related_id' => $this->row->id,
        ];
    }

    /**
     * @param array $file
     *
     * @return void
     */
    protected function fileUpdate(array $file): void
    {
        if (empty($file['file'])) {
            return;
        }

        $this->factory('File', $this->fileRow($file))->action($this->fileUpdateData($file))->update();
    }

    /**
     * @param array $file
     *
     * @return array
     */
    protected function fileUpdateData(array $file): array
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
    protected function fileDelete(array $file): void
    {
        $this->factory('File', $this->fileRow($file))->action()->delete();
    }

    /**
     * @param array $file
     *
     * @return \App\Domains\File\Model\File
     */
    protected function fileRow(array $file): Model
    {
        return Model::query()
            ->byRelated($this->row->getTable(), $this->row->id)
            ->byId((int)$file['id'])
            ->firstOrFail();
    }
}
