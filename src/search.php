<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

$pdo = DatabaseUtils::connect();

if (!empty($_GET['q'])) {
    $q = $_GET['q'];
    Utils::twigRender('search.twig', [
        'q' => $q,
        'appunti' => DatabaseUtils::cercaAppunti($pdo, $q)
    ]);
} else {
    Utils::tempRedirect('/');
}