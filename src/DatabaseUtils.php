<?php
declare(strict_types=1);


namespace tuttiAppunti;

use PDO;

class DatabaseUtils {

    public static function connect(): PDO {
        $pdo = new PDO('mysql:host=localhost;dbname=my_tuttiappunti', 'tuttiappunti', 'appunti');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function allCorsi(PDO $pdo): array {
        $stmt = $pdo->prepare("SELECT codice, nome FROM Corso");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCorso(PDO $pdo, string $corso): ?array {
        $stmt = $pdo->prepare("SELECT codice, nome FROM Corso WHERE codice=?");
        $stmt->bindValue(1, $corso);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
    }

    public static function getLezione(PDO $pdo, int $id): ?array {
        $stmt = $pdo->prepare("SELECT * FROM Lezione WHERE id=?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
    }

    public static function allLezioniForCorso(PDO $pdo, string $corso): array {
        $stmt = $pdo->prepare("SELECT id, data FROM Lezione WHERE corso=? ORDER BY data DESC");
        $stmt->bindValue(1, $corso);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function selectAppunti(PDO $pdo, string $where): \PDOStatement {
        $stmt = $pdo->prepare("
            SELECT CONCAT(u.nome, ' ', u.cognome, ' (', u.matricola, ')') AS nomeUtente, a.utente, a.argomento, a.testo 
            FROM Appunto a 
            INNER JOIN Utente u ON a.utente = u.matricola
            WHERE $where
            ORDER BY id DESC
        ");
        return $stmt;
    }

    public static function allAppuntiForLezione(PDO $pdo, int $idLezione): array {
        $stmt = self::selectAppunti($pdo, 'a.lezione=?');
        $stmt->bindValue(1, $idLezione);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cercaAppunti(PDO $pdo, string $query): array {
        $stmt = self::selectAppunti($pdo, "
            argomento LIKE CONCAT('%', ?, '%') OR 
            testo LIKE CONCAT('%', ?, '%')
        ");
        $stmt->bindValue(1, $query);
        $stmt->bindValue(2, $query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}