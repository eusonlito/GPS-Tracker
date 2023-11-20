<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\File\Model\File as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function saveRow(): void;

    /**
     * @return \App\Domains\File\Model\File
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataRelatedTable();
        $this->dataRelatedId();
        $this->dataName();
        $this->dataPath();
        $this->dataSize();
    }

    /**
     * @return void
     */
    protected function dataRelatedTable(): void
    {
        $this->data['related_table'] ??= $this->row->related_table;
    }

    /**
     * @return void
     */
    protected function dataRelatedId(): void
    {
        $this->data['related_id'] ??= $this->row->related_id;
    }

    /**
     * @return void
     */
    protected function dataName(): void
    {
        $this->data['name'] = $this->data['file']->getClientOriginalName();
    }

    /**
     * @return void
     */
    protected function dataPath(): void
    {
        $this->data['path'] = $this->data['related_table']
            .'/'.$this->data['related_id']
            .'/'.$this->dataPathName();
    }

    /**
     * @return string
     */
    protected function dataPathName(): string
    {
        preg_match('/^(.*)\.([^\.]+)$/i', $this->data['name'], $matches);

        return sprintf('%.4f', microtime(true))
            .'-'.substr(str_slug($matches[1]), 0, 80)
            .'.'.strtolower($matches[2]);
    }

    /**
     * @return void
     */
    protected function dataSize(): void
    {
        $this->data['size'] = $this->data['file']->getSize();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveFile();
        $this->saveRow();
    }

    /**
     * @return void
     */
    protected function saveFile(): void
    {
        Model::fileContentsSet($this->data['path'], $this->data['file']->getContent());
    }
}
