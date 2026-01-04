<?php

namespace App\Models;

use Framework\Core\Model;

class Work extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected string $name = '',
        protected string $type = '',
        protected ?int $genre_id = null,
        protected string $date_of_issue = '',
        protected string $place_of_issue = '',
        protected string $description = '',
        protected string $image = ''
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getGenre(): ?string
    {
        return $this->genre_id;
    }

    public function setGenre(?int $genre): void
    {
        $this->genre_id = $genre;
    }

    public function getDateOfIssue(): string
    {
        return $this->date_of_issue;
    }

    public function setDateOfIssue(string $dateOfIssue): void
    {
        $this->date_of_issue = $dateOfIssue;
    }

    public function getPlaceOfIssue(): ?string
    {
        return $this->place_of_issue;
    }

    public function setPlaceOfIssue(?string $placeOfIssue): void
    {
        $this->place_of_issue = $placeOfIssue;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}