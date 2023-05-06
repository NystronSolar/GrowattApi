<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@Symfony' => true,
        'phpdoc_to_comment' => ['ignored_tags' => ['var']]
    ])
    ->setFinder($finder)
;