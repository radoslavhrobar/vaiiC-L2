<?php

namespace App\Models;

use Framework\Core\Model;

class SeriesDetail extends Model
{
    public function __construct(
        protected ?int $workId = null,
        protected int $numOfSeasons = 0,
        protected int $numOfEpisodes = 0,
        protected string $director = '',
        protected string $prodCompany = ''
    ){
    }

    public static function getPkColumnName() : string
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
    public function getNumOfSeasons(): int
    {
        return $this->numOfSeasons;
    }
    public function setNumOfSeasons(int $numOfSeasons): void
    {
        $this->numOfSeasons = $numOfSeasons;
    }
    public function getNumOfEpisodes(): int
    {
        return $this->numOfEpisodes;
    }
    public function setNumOfEpisodes(int $numOfEpisodes): void
    {
        $this->numOfEpisodes = $numOfEpisodes;
    }
    public function getDirector(): string
    {
        return $this->director;
    }
    public function setDirector(string $director): void
    {
        $this->director = $director;
    }
    public function getProdCompany(): string
    {
        return $this->prodCompany;
    }
    public function setProdCompany(string $prodCompany): void
    {
        $this->prodCompany = $prodCompany;
    }
}