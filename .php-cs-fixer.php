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
            'anonymous_classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
            'allow_single_line_empty_anonymous_classes' => false,
        ],
    ])
    ->setFinder(Finder::create()->in(['app', 'config', 'database', 'tests']));
