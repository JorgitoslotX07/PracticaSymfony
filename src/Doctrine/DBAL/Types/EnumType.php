<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EnumType extends Type
{
    const ENUM_NAME = 'enum';
    protected array $values = [];

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(fn($val) => "'$val'", $this->values);
        return "ENUM(" . implode(", ", $values) . ")";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->values, true)) {
            throw new \InvalidArgumentException("Invalid value for enum '{$this->getName()}'.");
        }
        return $value;
    }

    public function getName(): string
    {
        return self::ENUM_NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

