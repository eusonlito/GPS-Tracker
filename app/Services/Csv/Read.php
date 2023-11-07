<?php declare(strict_types=1);

namespace App\Services\Csv;

use UnexpectedValueException;

class Read
{
    /**
     * @var mixed
     */
    protected mixed $fp;

    /**
     * @var array
     */
    protected array $lines;

    /**
     * @var array
     */
    protected array $header;

    /**
     * @var int
     */
    protected int $columns;

    /**
     * @param string $csv
     * @param string $delimiter = ';'
     *
     * @return self
     */
    public static function fromString(string $csv, string $delimiter = ';'): self
    {
        return static::new(static::stringToFile($csv), $delimiter);
    }

    /**
     * @param string $csv
     *
     * @return string
     */
    public static function stringToFile(string $csv): string
    {
        $file = tempnam(sys_get_temp_dir(), 'csv-read');

        file_put_contents($file, $csv);

        return $file;
    }

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $file
     * @param string $delimiter = ';'
     *
     * @return self
     */
    public function __construct(protected string $file, protected string $delimiter = ';')
    {
    }

    /**
     * @param array $header
     *
     * @return self
     */
    public function map(array $header): self
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $this->fopen();
        $this->lines();
        $this->fclose();
        $this->header();
        $this->columns();

        return array_map($this->line(...), $this->lines);
    }

    /**
     * @return self
     */
    public function fopen(): self
    {
        if (is_readable($this->file) === false) {
            throw new UnexpectedValueException(sprintf('Invalid CSV File %s', $this->file));
        }

        $this->fp = fopen($this->file, 'r');

        if ($this->fp === false) {
            throw new UnexpectedValueException(sprintf('Invalid CSV File %s', $this->file));
        }

        // UTF-8 BOM Remove
        if (fgets($this->fp, 4) !== "\xef\xbb\xbf") {
            rewind($this->fp);
        }

        return $this;
    }

    /**
     * @return void
     */
    protected function lines(): void
    {
        $this->lines = [];

        while (($each = fgetcsv($this->fp, 0, $this->delimiter)) !== false) {
            $this->lines[] = $each;
        }
    }

    /**
     * @return self
     */
    public function fclose(): self
    {
        fclose($this->fp);

        return $this;
    }

    /**
     * @return void
     */
    protected function header(): void
    {
        $header = array_shift($this->lines);

        $this->header ??= $header ?? [];
    }

    /**
     * @return void
     */
    protected function columns(): void
    {
        $this->columns = count($this->header);
    }

    /**
     * @param array $line
     *
     * @return array
     */
    protected function line(array $line): array
    {
        if (count($line) !== $this->columns) {
            $this->lineError($line);
        }

        return array_combine($this->header, array_map($this->value(...), $line));
    }

    /**
     * @param string|null $value
     *
     * @return string
     */
    protected function value(?string $value): string
    {
        return trim($this->utf8(strval($value)));
    }

    /**
     * @param array $line
     *
     * @return void
     */
    protected function lineError(array $line): void
    {
        throw new UnexpectedValueException(sprintf(
            'File <strong>%s</strong> has different columns than header <string>%s</string>',
            implode(',', $line),
            implode(',', $this->header)
        ));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function utf8(string $string): string
    {
        if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $string)) {
            return $string;
        }

        if (preg_match('#[\x7F-\x9F\xBC]#', $string)) {
            return iconv('WINDOWS-1250', 'UTF-8', $string);
        }

        return iconv('ISO-8859-15', 'UTF-8', $string);
    }
}
