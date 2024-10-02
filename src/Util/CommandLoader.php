<?php
declare(strict_types=1);

namespace App\Util;

use App\Command\ContactCommand;
use ReflectionClass;

/**
 * Cette classe se charge d'aller à la découverte des commandes existantes,
 * ainsi que de les exposer à l'utilisateur.
 * Pour créer une nouvelle commande, il suffit d'utiliser l'attribut #[CommandAttribute] !
 */
class CommandLoader {
    private static ?array $commands = null;

    /**
     * Retourne $commands comprenant toutes les informations des commandes connues
     * @return array
     */
    public static function commands() : array
    {
        if (self::$commands == null) {
            self::commandsInitialization();
        }
        return self::$commands;
    }

    /**
     * Cherche et répertorie les commandes existantes dans l'application
     * @return void
     */
    private static function commandsInitialization() : void
    {
        $reflectionClass = new ReflectionClass(ContactCommand::class);
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method) {
            $attributes = $method->getAttributes();
            if(count($attributes) > 0) {
                foreach ($attributes as $attribute) {
                    $command = $attribute->newInstance();

                    self::$commands[$command->name] = [
                        'pattern' => $command->pattern,
                        'description' => $command->description,
                        'method' => $method->name
                    ];
                }
            }
        }
    }
}
