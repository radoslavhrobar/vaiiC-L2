<?php

namespace App\Models;

use App\Helpers\Types;
use Framework\Core\Model;

class Genre extends Model
{
    public function __construct(
        protected ?int  $id = null,
        protected string $name = '',
        protected string $type = Types::Both->name
    ){
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}