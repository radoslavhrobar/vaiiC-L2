<?php

namespace App\Models;

use Framework\Core\Model;

class SeriesDetail extends Model
{
    public function __construct(
        protected ?int $work_id = null,
        protected int $num_of_seasons = 0,
        protected int $num_of_episodes = 0,
        protected string $prod_company = '',
        protected string $director = ''
    ){
    }

    public static function getPkColumnName() : string
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
    public function getNumOfSeasons(): int
    {
        return $this->num_of_seasons;
    }
    public function setNumOfSeasons(int $numOfSeasons): void
    {
        $this->num_of_seasons = $numOfSeasons;
    }
    public function getNumOfEpisodes(): int
    {
        return $this->num_of_episodes;
    }
    public function setNumOfEpisodes(int $numOfEpisodes): void
    {
        $this->num_of_episodes = $numOfEpisodes;
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