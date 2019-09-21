<?php
declare(strict_types=1);

require_once __DIR__ .'/../vendor/autoload.php';

use tuttiAppunti\DatabaseUtils;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

DatabaseUtils::connect();

$twig = new Environment(new FilesystemLoader(__DIR__ . '/../twig'));
echo $twig->render('index.twig', [
   'name' => '<script>Francesco</script>'
]);