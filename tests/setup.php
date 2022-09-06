<?php

declare(strict_types=1);

use Nette\Utils\Finder;

require __DIR__ . '/../vendor/autoload.php';

$runner->addPhpIniOption('auto_prepend_file', __DIR__ . '/boot.php');
foreach (Finder::findFiles('*.test.php')->from(__DIR__ . '/../src') as $key => $file) {
    $runner->paths[] = $key;
}
