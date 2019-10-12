<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

$pdo = DatabaseUtils::connect();

$lezione = DatabaseUtils::getLezione($pdo, (int)($_GET['id'] ?? 0));
if ($lezione === null) {
    http_response_code(404);
} else {
    $lezione['corso'] = DatabaseUtils::getCorso($pdo, $lezione['corso']);
    Utils::twigRender('lezione.twig', [
        'lezione' => $lezione,
        'appunti' => DatabaseUtils::allAppuntiForLezione($pdo, (int)$lezione['id'])
    ]);
}