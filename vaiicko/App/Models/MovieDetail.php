<?php

namespace App\Models;

use Framework\Core\Model;

class MovieDetail extends Model
{
    public function __construct(
        protected ?int $workId = null,
        protected int $lengthMin = 0,
        protected string $prodCompany = '',
        protected string $director = ''
    ){
    }

    protected static function getPkColumnName(): string
    {
        return 'workId';
    }

    public function getWorkId(): ?int
    {
        return $this->workId;
    }
    public function setWorkId(?int $workId): void
    {
        $this->workId = $workId;
    }
    public function getLengthMin(): int
    {
        return $this->lengthMin;
    }
    public function setLengthMin(int $lengthMin): void
    {
        $this->lengthMin = $lengthMin;
    }
    public function getProdCompany(): string
    {
        return $this->prodCompany;
    }
    public function setProdCompany(string $prodCompany): void
    {
        $this->prodCompany = $prodCompany;
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