<?php
if (!class_exists('PhpCsFixer\Config', true)) {
    fwrite(STDERR, "Your php-cs-version is outdated: please upgrade it.\n");
    die(16);
}
return PhpCsFixer\Config::create()
    ->setCacheFile(__DIR__ . '/.php_cs.cache')
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'cast_spaces' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'single_blank_line_before_namespace' => false,
        'no_blank_lines_before_namespace' => true,
        'blank_line_after_opening_tag' => false,
        'phpdoc_align' => false,
        'single_quote' => true,
        'ordered_imports' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
    )
;