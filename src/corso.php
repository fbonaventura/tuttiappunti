<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

$pdo = DatabaseUtils::connect();

$corso = DatabaseUtils::getCorso($pdo, $_GET['corso'] ?? '');
if ($corso === null) {
    http_response_code(404);
} else {
    Utils::twigRender('corso.twig', [
        'corso' => $corso,
        'lezioni' => DatabaseUtils::allLezioniForCorso($pdo, $_GET['corso'])
    ]);
}