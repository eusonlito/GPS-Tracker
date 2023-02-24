<?php declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP82Migration' => true,
        '@PSR2' => true,
        'braces' => false,
        'class_definition' => false,
        'no_unused_imports' => true,
        'phpdoc_separation' => true,
    ])
    ->setFinder(Finder::create()->in(['app', 'config', 'database', 'tests']));
