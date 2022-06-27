<?php

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->notName('*.phpt');

if (!\file_exists(__DIR__ . '/var')) {
    \mkdir(__DIR__ . '/var');
}

/**
 * This configuration was taken from https://github.com/sebastianbergmann/phpunit/blob/master/.php_cs.dist
 * and slightly adjusted.
 */
$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__.'/var/.php_cs.cache')
    ->setRules([
        '@PHP74Migration' => true,
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        '@PSR1' => true,
        '@PSR12' => true,
        '@PSR2' => true,
        '@PHP74Migration:risky' => true,
        '@PSR12:risky' => true,
        '@PhpCsFixer:risky' => true,
        '@Symfony:risky' => true,
    ])
    ->setFinder($finder);