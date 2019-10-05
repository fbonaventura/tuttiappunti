<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;


if (!empty($_POST['codice']) && !empty($_POST['nome'])) {
    $stmt = DatabaseUtils::connect()->prepare("INSERT INTO Corso(codice, nome) VALUES(?,?)");
    $codice = $_POST['codice'];
    $stmt->bindValue(1, $codice);
    $stmt->bindValue(2, $_POST['nome']);

    try {
        $stmt->execute();

        Utils::tempRedirect('/corso.php?corso=' . urlencode($codice));
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            $message = "Il corso con questo codice esiste già!";
        } else {
            throw $e;
        }
    }
}
Utils::twigRender('aggiungiCorso.twig', [
    'message' => $message ?? null
]);

