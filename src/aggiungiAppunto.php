<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

Utils::redirectIfNotLogged();

$lezione = $_GET['lezione'] ?? null;
if ($lezione === null) {
    Utils::tempRedirect('/');
}

if (!empty($_POST['argomento']) && !empty($_POST['testo'])) {
    $pdo = DatabaseUtils::connect();
    $stmt = $pdo->prepare("INSERT INTO Appunto(utente, lezione, argomento, testo) VALUES(?,?,?,?)");
    $stmt->bindValue(1, Utils::loggedUser());
    $stmt->bindValue(2, $lezione);
    $stmt->bindValue(3, $_POST['argomento']);
    $stmt->bindValue(4, $_POST['testo']);

    $stmt->execute();

    Utils::tempRedirect('/lezione.php?id=' . $lezione);
}
Utils::twigRender('aggiungiAppunto.twig', [
    'lezione' => $lezione,
    'message' => $message ?? null
]);

