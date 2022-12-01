<?php

preg_match_all('/([0-9]+)\-([a-z0-9]+)/', (string)env('SERVERS'), $matches);

$servers = [];

foreach ($matches[1] as $index => $port) {
    $servers[$port] = $matches[2][$index];
}

return $servers;
