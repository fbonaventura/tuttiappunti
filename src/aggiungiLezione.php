<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

Utils::redirectIfNotLogged();

$corso = $_GET['corso'] ?? null;
if ($corso === null) {
    Utils::tempRedirect('/');
}

if (!empty($_POST['data'])) {
    $pdo = DatabaseUtils::connect();
    $stmt = $pdo->prepare("INSERT INTO Lezione(data, corso) VALUES(?,?)");
    $stmt->bindValue(1, $_POST['data']);
    $stmt->bindValue(2, $corso);

    try {
        $stmt->execute();
        $id = (int)$pdo->lastInsertId();

        Utils::tempRedirect('/lezione.php?id=' . $id);
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            $message = "La lezione per questo corso con questa data esiste già!";
        } else {
            throw $e;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = 'Dati mancanti';
}

Utils::twigRender('aggiungiLezione.twig', [
    'corso' => $corso,
    'message' => $message ?? null
]);

