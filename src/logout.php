<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; //serve per far trovare le classi in php

use tuttiAppunti\Utils;

Utils::logUserOut();
Utils::tempRedirect('/');
