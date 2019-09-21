<?php
declare(strict_types=1);


namespace tuttiAppunti;

use PDO;

class DatabaseUtils {

    public static function connect() : PDO {
        return new PDO('mysql:host=localhost;dbname=my_tuttiappunti', 'tuttiappunti', '');
    }
}