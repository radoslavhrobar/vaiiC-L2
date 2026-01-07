<?php

namespace App\Models;

use Framework\Core\Model;

class Country extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected string $code = '',
        protected string $name = ''
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public static function getCountriesByWorkIds(array $works) : array {
        $countries = [];
        foreach ($works as $i => $work) {
            $countries[$i] = Country::getOne($work->getPlaceOfIssue());
        }
        return $countries;
    }
}