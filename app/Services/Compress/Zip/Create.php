<?php declare(strict_types=1);

namespace App\Services\Compress\Zip;

use UnexpectedValueException;
use ZipArchive;

class Create
{
    /**
     * @var \ZipArchive
     */
    protected ZipArchive $zip;

    /**
     * @var ?string
     */
    protected ?string $password = null;

    /**
     * @return self
     */
    public function __construct(protected string $file)
    {
        $this->open();
    }

    /**
     * @return self
     */
    protected function open(): self
    {
        $this->zip = new ZipArchive();

        if ($this->zip->open($this->file, ZipArchive::CREATE) !== true) {
            throw new UnexpectedValueException('Invalid ZIP File');
        }

        return $this;
    }

    /**
     * @param ?string $password
     *
     * @return self
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $file
     * @param string $name = ''
     *
     * @return self
     */
    public function addFile(string $file, string $name = ''): self
    {
        $this->zip->addFile($file, trim($name ?: basename($file), '/'));

        if ($this->password) {
            $this->zip->setEncryptionName($file, ZipArchive::EM_AES_256, $this->password);
        }

        return $this;
    }

    /**
     * @return self
     */
    public function close(): self
    {
        $this->zip->close();

        return $this;
    }
}
