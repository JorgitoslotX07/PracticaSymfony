<?php
namespace App\Doctrine\DBAL\Types;

class TipoProveedorType extends EnumType
{
    protected array $values = ['hotel', 'pista', 'complemento'];
    const NAME = 'tipo_proveedor';

    public function getName(): string
    {
        return self::NAME;
    }

    public static function getValues(): array
    {
        return (new self())->values;
    }
}