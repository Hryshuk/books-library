<?php

namespace App\DTO;

use App\Entity\Author;

class BookFilterDTO
{
    private ?string $name;
    private ?string $description;
    private ?\DateTimeInterface $published;
    private ?int $authorId;

    /**
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param ?string $name
     * @return BookFilterDTO
     */
    public function setName(?string $name): BookFilterDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param ?string $description
     * @return BookFilterDTO
     */
    public function setDescription(?string $description): BookFilterDTO
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return ?DateTimeInterface
     */
    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    /**
     * @param ?DateTimeInterface $published
     * @return BookFilterDTO
     */
    public function setPublished(?\DateTimeInterface $published): BookFilterDTO
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return ?int
     */
    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    /**
     * @param ?Author $author
     * @return BookFilterDTO
     */
    public function setAuthorId(?Author $author): BookFilterDTO
    {
        $this->authorId = $author ? $author->getId() : null;
        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

}