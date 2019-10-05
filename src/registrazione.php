<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

Utils::redirectIfLogged();

if (!empty($_POST['matricola']) && !empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
    $password = $_POST['password'];
    if ($password !== $_POST['password2']) {
        $message = 'Le due password non coincidono!';
    } else {
        $matricola = intval($_POST['matricola']);
        if ($matricola <= 0) {
            $message = "Matricola non valida";
        } else {

            $pdo = DatabaseUtils::connect();
            $stmt = $pdo->prepare("INSERT INTO Utente(matricola, nome, cognome, password) VALUES(?,?,?,?)");
            $stmt->bindValue(1, $matricola);
            $stmt->bindValue(2, $_POST['nome']);
            $stmt->bindValue(3, $_POST['cognome']);
            $stmt->bindValue(4, password_hash($password, PASSWORD_DEFAULT));
            try {
                $stmt->execute();

                Utils::logUser($matricola);
                Utils::tempRedirect('/');
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $message = "L'utente con questa matricola esiste già!";
                } else {
                    throw $e;
                }
            }
        }
    }
}

Utils::twigRender('registrazione.twig', [
    'message' => $message ?? null
]);

