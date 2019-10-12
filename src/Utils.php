<?php
declare(strict_types=1);


namespace tuttiAppunti;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Utils {

    public static function twig(): Environment {
        return new Environment(new FilesystemLoader(__DIR__ . '/../twig'));
    }

    public static function twigRender(string $page, array $data = []): void {
        echo self::twig()->render($page, array_merge($data, [
            'user' => self::loggedUser()
        ]));
    }

    public static function logUser(int $matricola): void {
        session_start();
        $_SESSION['user'] = $matricola;
    }

    public static function loggedUser(): ?int {
        session_start();
        return $_SESSION['user'] ?? null;
    }

    public static function redirectIfLogged() : void {
        if(self::loggedUser() !== null) {
            self::tempRedirect('/');
        }
    }


    public static function redirectIfNotLogged() : void {
        if(self::loggedUser() === null) {
            self::tempRedirect('/');
        }
    }

    public static function tempRedirect(string $location) : void {
        http_response_code(303);
        header("Location: $location");
        exit();
    }

    public static function logUserOut() {
        session_start();
        session_destroy();
    }
}