<?php

namespace App\Models;

use Framework\Core\Model;

class Review extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $body = null,
        protected int $rating = 0,
        protected ?int $user_id = null,
        protected ?int $work_id = null,
        protected string $created_at = '',
        protected ?string $updated_at = null
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getWorkId(): ?int
    {
        return $this->work_id;
    }

    public function setWorkId(?int $work_id): void
    {
        $this->work_id = $work_id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}