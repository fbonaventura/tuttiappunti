<?php
declare(strict_types=1);


namespace tuttiAppunti;

use PDO;

class DatabaseUtils {

    public static function connect() : PDO {
        $pdo = new PDO('mysql:host=localhost;dbname=my_tuttiappunti', 'tuttiappunti', 'appunti');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function allCorsi(PDO $pdo) : array {
        $stmt = $pdo->prepare("SELECT codice, nome FROM Corso");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCorso(PDO $pdo, string $corso) : ?array {
        $stmt = $pdo->prepare("SELECT codice, nome FROM Corso WHERE codice=?");
        $stmt->bindValue(1, $corso);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
    }

    public static function allLezioniForCorso(PDO $pdo, string $corso) : array {
        $stmt = $pdo->prepare("SELECT id, data FROM Lezione WHERE corso=?");
        $stmt->bindValue(1, $corso);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}