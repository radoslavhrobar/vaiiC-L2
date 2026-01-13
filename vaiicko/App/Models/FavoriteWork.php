<?php

namespace App\Models;

use Framework\Core\Model;

class FavoriteWork extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?int $user_id = null,
        protected ?int $work_id = null
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
}