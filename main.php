<?php

require_once './config/Autoloader.php';
Autoloader::register();

$help = "";
foreach (\App\Util\CommandLoader::commands() as $command) {
    $help .= $command['description']."\n";
}

while (true) {
    echo "\n";
    $line = readline("Entrez votre commande : ");

    if ($line === "help") {
        echo $help;
        continue;
    }

    if ($line === "quit") {
        break;
    }

    $continue = false;

    foreach(\App\Util\CommandLoader::commands() as $command) {
        if (preg_match($command['pattern'], $line, $matches)) {
            array_shift($matches);
            call_user_func_array(array(new App\Command\ContactCommand, $command['method']), $matches);
            $continue = true;
            break;
        }
    }

    if($continue) {
        continue;
    }

    echo "Commande inconnue. Voici la liste des commandes disponibles :\n";
    echo $help;
}
