<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use tuttiAppunti\Utils;

Utils::redirectIfLogged();

if (isset($_POST['matricola'], $_POST['password'])) {
    $stmt = DatabaseUtils::connect()->prepare("SELECT password FROM Utente WHERE matricola=?");
    $matricola = intval($_POST['matricola']);
    $stmt->bindValue(1, $matricola);
    $stmt->execute();

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
    if ($user === null) {
        $message = "Matricola non esistente";
    } else {
        $hash = $user['password'];
        if (password_verify($_POST['password'], $hash)) {
            Utils::logUser($matricola);
            Utils::tempRedirect('/');
        } else {
            $message = "Password non corretta";
        }
    }
}
Utils::twigRender('login.twig', [
    'message' => $message ?? null
]);

