<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Service;

use Exception;

class PlainImport extends ServiceAbstract
{
    /**
     * @var string
     */
    protected string $base = 'resources/lang';

    /**
     * @var string
     */
    protected string $file;

    /**
     * @var array
     */
    protected array $contents;

    /**
     * @param string $lang
     * @param string $file
     *
     * @return self
     */
    public function __construct(protected string $lang, string $file)
    {
        $this->base();
        $this->file($file);
        $this->contents();
    }

    /**
     * @return void
     */
    protected function base(): void
    {
        $this->base = base_path($this->base);
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function file(string $file): void
    {
        $this->file = base_path($file);

        if (!is_file($this->file)) {
            throw new Exception(sprintf('File %s not found', $file));
        }
    }

    /**
     * @return void
     */
    protected function contents(): void
    {
        $this->contents = $this->undot(json_decode(file_get_contents($this->file), true));
    }

    /**
     * @return void
     */
    public function write(): void
    {
        foreach ($this->contents as $file => $contents) {
            $this->writeFileTarget($file, $contents);
        }
    }

    /**
     * @param string $file
     * @param array $contents
     *
     * @return void
     */
    protected function writeFileTarget(string $file, array $contents): void
    {
        $contents = helper()->arrayFilterRecursive($contents);
        $target = $this->base.'/'.$this->lang.'/'.$file.'.php';

        $contents = array_replace_recursive($this->writeFileTargetContents($target), $contents);

        $this->writeFile($target, $contents);
    }

    /**
     * @param string $file
     *
     * @return array
     */
    protected function writeFileTargetContents(string $file): array
    {
        $target = $this->base.'/'.$this->lang.'/'.$file.'.php';

        if (is_file($target) === false) {
            return [];
        }

        return helper()->arrayFilterRecursive(require $target);
    }
}
