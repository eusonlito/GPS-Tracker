<?php declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP82Migration' => true,
        '@PSR2' => true,
        'blank_line_after_opening_tag' => false,
        'cast_spaces' => false,
        'class_definition' => false,
        'linebreak_after_opening_tag' => false,
        'no_superfluous_phpdoc_tags' => false,
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => false,
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_imports' => false,
        'phpdoc_order' => true,
        'phpdoc_separation' => true,
        'single_line_comment_style' => false,

        'braces_position' => [
            'allow_single_line_empty_anonymous_classes' => true,
            'anonymous_classes_opening_brace' => 'same_line',
            'anonymous_functions_opening_brace' => 'same_line',
        ],
    ])
    ->setFinder(Finder::create()->in(['app', 'config', 'database']));
