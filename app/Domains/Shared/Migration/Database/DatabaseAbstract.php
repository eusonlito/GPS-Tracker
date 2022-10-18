<?php declare(strict_types=1);

namespace App\Domains\Shared\Migration\Database;

use Illuminate\Database\ConnectionInterface;

class DatabaseAbstract
{
    /**
     * @param \Illuminate\Database\ConnectionInterface $db
     *
     * @return self
     */
    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }
}
