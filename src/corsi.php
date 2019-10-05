<?php
declare(strict_types=1);

require_once __DIR__ .'/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

$pdo = DatabaseUtils::connect();

Utils::twigRender('corsi.twig', [
    'corsi' => DatabaseUtils::allCorsi($pdo)
]);