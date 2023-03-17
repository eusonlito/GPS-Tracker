<?php declare(strict_types=1);

namespace App\Services\Csv;

use UnexpectedValueException;

class Read
{
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
     * @param string $file
     * @param string $delimiter = ';'
     *
     * @return self
     */
    public static function fromFile(string $file, string $delimiter = ';'): self
    {
        return static::new(file_get_contents($file), $delimiter);
    }

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $csv
     * @param string $delimiter = ';'
     *
     * @return self
     */
    public function __construct(protected string $csv, protected string $delimiter = ';')
    {
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $this->lines();
        $this->header();
        $this->columns();

        return array_map($this->line(...), $this->lines);
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
     * @return void
     */
    protected function lines(): void
    {
        $this->lines = [];

        foreach (array_filter(preg_split('/\r\n|\r|\n/', $this->csv)) as $each) {
            $this->lines[] = str_getcsv($this->utf8($each), $this->delimiter);
        }

        if (count($this->lines) < 2) {
            $this->lines = [];
        }
    }

    /**
     * @return void
     */
    protected function header(): void
    {
        $header = array_shift($this->lines);

        if (isset($this->header) === false) {
            $this->header = $header;
        }
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

        return array_combine($this->header, array_map(static fn ($value) => trim(strval($value)), $line));
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
        // Remove UTF-8 BOM fix in Excel
        if (substr($string, 0, 3) === chr(0xEF).chr(0xBB).chr(0xBF)) {
            $string = substr($string, 3);
        }

        if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $string)) {
            return $string;
        }

        if (preg_match('#[\x7F-\x9F\xBC]#', $string)) {
            return iconv('WINDOWS-1250', 'UTF-8', $string);
        }

        return iconv('ISO-8859-15', 'UTF-8', $string);
    }
}
