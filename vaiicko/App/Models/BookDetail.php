<?php

namespace App\Models;

use Framework\Core\Model;

class BookDetail extends Model
{
    public function __construct(
        protected ?int $workId = null,
        protected int $numOfPages = 0,
        protected  string $author = '',
        protected string $publishers = '',
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
    public function getAuthor(): string
    {
        return $this->author;
    }
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
    public function getPublishers(): string
    {
        return $this->publishers;
    }
    public function setPublishers(string $publishers): void
    {
        $this->publishers = $publishers;
    }
}