<?php
declare(strict_types = 1);

namespace App\Attribute;

use Attribute;

/**
 * Définition de l'attribut "CommandAttribute"
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class CommandAttribute
{
    public function __construct(
        public string $name,
        public string $pattern,
        public string $description
    ) {}
}
