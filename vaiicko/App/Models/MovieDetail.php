<?php

namespace App\Models;

use Framework\Core\Model;

class MovieDetail extends Model
{
    public function __construct(
        protected ?int $work_id = null,
        protected int $length = 0,
        protected string $prod_company = '',
        protected string $director = ''
    ){
    }

    protected static function getPkColumnName(): string
    {
        return 'work_id';
    }

    public function getWorkId(): ?int
    {
        return $this->work_id;
    }
    public function setWorkId(?int $workId): void
    {
        $this->work_id = $workId;
    }
    public function getLength(): int
    {
        return $this->length;
    }
    public function setLength(int $length): void
    {
        $this->length = $length;
    }
    public function getProdCompany(): string
    {
        return $this->prod_company;
    }
    public function setProdCompany(string $prodCompany): void
    {
        $this->prod_company = $prodCompany;
    }

    public function getDirector(): string
    {
        return $this->director;
    }
    public function setDirector(string $director): void
    {
        $this->director = $director;
    }
}