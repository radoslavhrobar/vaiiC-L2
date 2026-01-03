<?php

namespace App\Models;

use Framework\Core\Model;

class BookDetail extends Model
{
    public function __construct(
        protected ?int $workId = null,
        protected int $numOfPages = 0,
        protected string $publisher = '',
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
    public function getNumOfPages(): int
    {
        return $this->numOfPages;
    }
    public function setNumOfPages(int $numOfPages): void
    {
        $this->numOfPages = $numOfPages;
    }
    public function getPublisher(): string
    {
        return $this->publisher;
    }
    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }
}