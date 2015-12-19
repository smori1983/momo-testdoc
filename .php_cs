<?php
$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
;

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        '-concat_without_spaces',
        '-empty_return',
        '-blankline_after_open_tag',
        'ordered_use',
        '-phpdoc_no_empty_return',
        '-phpdoc_params',
        '-phpdoc_short_description',
        '-pre_increment',
        '-trim_array_spaces',
    ))
    ->finder($finder)
;
