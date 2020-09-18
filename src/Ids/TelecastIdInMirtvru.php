<?php


namespace Observatby\TelecastVault;


use InvalidArgumentException;


class TelecastIdInMirtvru implements IdInterface
{
    private int $id;

    public static function fromScalar($id): TelecastIdInMirtvru
    {
        self::ensureIsValid($id);

        return new self($id);
    }

    public function toScalar()
    {
        return $this->id;
    }

    private function __construct($id)
    {
        $this->id = $id;
    }

    private static function ensureIsValid($id)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException(sprintf("Invalid %s given", self::class));
        }
    }
}
