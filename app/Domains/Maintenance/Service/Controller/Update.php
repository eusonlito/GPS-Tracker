<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\File\Model\File as FileModel;
use App\Domains\File\Model\Collection\File as FileCollection;
use App\Domains\Maintenance\Model\Maintenance as Model;

class Update extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Maintenance\Model\Maintenance $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
        $this->request();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCreateUpdate() + [
            'row' => $this->row,
            'files' => $this->files(),
        ];
    }

    /**
     * @return \App\Domains\File\Model\Collection\File
     */
    protected function files(): FileCollection
    {
        return FileModel::query()
            ->byRelated('maintenance', $this->row->id)
            ->list()
            ->get();
    }
}
