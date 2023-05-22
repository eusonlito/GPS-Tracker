<?php declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP82Migration' => true,
        '@PSR2' => true,
        'class_definition' => false,
        'no_unused_imports' => true,
        'phpdoc_separation' => true,
        'curly_braces_position' => [
            'anonymous_classes_opening_brace' => 'same_line',
            'allow_single_line_empty_anonymous_classes' => true,
        ],
    ])
    ->setFinder(Finder::create()->in(['app', 'config', 'database', 'tests']));
