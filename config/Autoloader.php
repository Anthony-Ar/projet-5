<?php
declare(strict_types=1);

class Autoloader
{
    /**
     * Les aliases donnent à l'application une indication sur le dossier où chercher un namespace
     * Les namespace commençant par "App" se trouvent dans le dossier "src"
     */
    const array ALIASES = [
        'App' => 'src'
    ];

    const string FILE_EXTENSION = ".php";

    /**
     * L'application est capable, grâce aux namespace des classes,
     * de trouver le fichier dont elle a besoin et de l'importer
     * @return void
     */
    public static function register() : void
    {
        spl_autoload_register(function (string $class): void {
            $namespace = explode('\\', $class);

            if (in_array($namespace[0], array_keys(self::ALIASES))) {
                $namespace[0] = self::ALIASES[$namespace[0]];
            }

            $filepath = dirname(__DIR__).'/'.implode('/', $namespace).self::FILE_EXTENSION;
            require_once $filepath;
        });
    }
}
