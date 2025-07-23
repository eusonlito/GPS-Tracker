<?php declare(strict_types=1);

namespace App\Services\Protocol\TK102;

use App\Services\Protocol\TK102\Parser\Command as CommandParser;
use App\Services\Protocol\TK102\Parser\Location as LocationParser;
use App\Services\Protocol\ProtocolAbstract;
use App\Services\Server\Socket\Server;

class Manager extends ProtocolAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'tk102';
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'TK102';
    }

    /**
     * @param int $port
     *
     * @return \App\Services\Server\Socket\Server
     */
    public function server(int $port): Server
    {
        return Server::new($port)
            ->socketType('stream')
            ->socketProtocol('ip');
    }

    /**
     * @return array
     */
    protected function parsers(): array
    {
        return [
            CommandParser::class,
            LocationParser::class,
        ];
    }

    /**
     * @param string $message
     *
     * @return array
     */
    public function messages(string $message): array
    {
        $messages = [];

        foreach (array_filter(array_map('trim', preg_split('/[\n\r]/', $message))) as $each) {
            $messages[] = $this->messageClean($each);
        }

        return $messages;
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function messageClean(string $message): string
    {
        if ((strlen($message) % 2 === 0) && ctype_xdigit($message)) {
            $message = hex2bin($message);
        }

        return preg_replace('/[[:^print:]]/', '', $message);
    }
}
