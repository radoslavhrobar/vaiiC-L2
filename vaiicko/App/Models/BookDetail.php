<?php

namespace App\Models;

use Framework\Core\Model;

class BookDetail extends Model
{
    public function __construct(
        protected ?int $work_id = null,
        protected int $num_of_pages = 0,
        protected  string $author = '',
        protected string $publishers = '',
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
    public function getNumOfPages(): int
    {
        return $this->num_of_pages;
    }
    public function setNumOfPages(int $numOfPages): void
    {
        $this->num_of_pages = $numOfPages;
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