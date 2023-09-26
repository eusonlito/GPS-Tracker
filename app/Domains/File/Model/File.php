<?php declare(strict_types=1);

namespace App\Domains\File\Model;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use App\Domains\File\Model\Builder\File as Builder;
use App\Domains\File\Model\Collection\File as Collection;
use App\Domains\CoreApp\Model\ModelAbstract;

class File extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'file';

    /**
     * @const string
     */
    public const TABLE = 'file';

    /**
     * @const string
     */
    public const FOREIGN = 'file_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\File\Model\Collection\File
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\File\Model\Builder\File
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return bool
     */
    public function fileExists(): bool
    {
        return static::storage()->exists($this->path);
    }

    /**
     * @return string
     */
    public function filePath(): string
    {
        return static::storage()->path($this->path);
    }

    /**
     * @return string
     */
    public function fileContentsGet(): string
    {
        return static::storage()->get($this->path);
    }

    /**
     * @param string $path
     * @param string $contents
     *
     * @return void
     */
    public static function fileContentsSet(string $path, string $contents): void
    {
        static::storage()->put($path, $contents);
    }

    /**
     * @return void
     */
    public function fileDelete(): void
    {
        static::storage()->delete($this->path);
    }

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    protected static function storage(): FilesystemAdapter
    {
        return Storage::disk('private');
    }
}
