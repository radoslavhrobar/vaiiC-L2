<?php

namespace App\Models;

use Framework\Core\Model;

class Work extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?string $type = null,
        protected ?string $genre = null,
        protected ?\DateTime $dateOfIssue = null,
        protected  ?string $placeOfIssue = null,
        protected ?string $description = null,
        protected ?string $image = null
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
        return $this->genre;
    }

    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    public function getDateOfIssue(): ?\DateTime
    {
        return $this->dateOfIssue;
    }

    public function setDateOfIssue(?\DateTime $dateOfIssue): void
    {
        $this->dateOfIssue = $dateOfIssue;
    }

    public function getPlaceOfIssue(): ?string
    {
        return $this->placeOfIssue;
    }

    public function setPlaceOfIssue(?string $placeOfIssue): void
    {
        $this->placeOfIssue = $placeOfIssue;
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