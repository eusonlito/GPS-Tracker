<?php declare(strict_types=1);

namespace App\Domains\Configuration\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Configuration\Model\Configuration as Model;

class Update extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Configuration\Model\Configuration $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
        $this->request();
    }

    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow(data: ['value_default' => $this->requestDefault()]);
    }

    /**
     * @return ?string
     */
    protected function requestDefault(): ?string
    {
        foreach ($this->requestDefaultContents() as $row) {
            if ($row->key === $this->row->key) {
                return strval($row->value);
            }
        }

        return null;
    }

    /**
     * @return array
     */
    protected function requestDefaultContents(): array
    {
        return json_decode(file_get_contents($this->requestDefaultContentsFile()));
    }

    /**
     * @return string
     */
    protected function requestDefaultContentsFile(): string
    {
        return dirname(__DIR__, 2).'/Seeder/data/configuration.json';
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'row' => $this->row,
        ];
    }
}
