<?php declare(strict_types=1);

namespace App\Domains\Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class MailAbstract extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $subject = '';

    /**
     * @var string
     */
    public $view = '';

    /**
     * @return self
     */
    final public function build(): self
    {
        return $this->buildData()->view($this->view);
    }

    /**
     * @return self
     */
    public function buildData(): self
    {
        return $this;
    }

    /**
     * @param array|string|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return self
     */
    final public function file(array|string|UploadedFile $file): self
    {
        if (is_array($file)) {
            return $this->files($file);
        }

        if (is_string($file)) {
            return $this->attach($file);
        }

        return $this->fileUploaded($file);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return self
     */
    final protected function fileUploaded(UploadedFile $file): self
    {
        return $this->attach($file->getRealPath(), [
            'as' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
        ]);
    }

    /**
     * @param array $files
     *
     * @return self
     */
    final protected function files(array $files): self
    {
        foreach ($files as $each) {
            $this->file($each);
        }

        return $this;
    }

    /**
     * @param string|array $emails
     *
     * @return array
     */
    final protected function emails($emails): array
    {
        if (is_string($emails)) {
            $emails = preg_split('/[,;\s]+/', strtolower($emails));
        }

        return array_values(array_unique(array_filter(array_map('trim', $emails), function ($value) {
            return $value && filter_var($value, FILTER_VALIDATE_EMAIL);
        })));
    }
}
