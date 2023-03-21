<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'books')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 300)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    #[Assert\LessThanOrEqual("today", message="La date de publication doit être inférieure ou égale à la date d'aujourd'hui.")]
    private ?\DateTimeInterface $dateOfPublication = null;

    #[ORM\ManyToOne(targetEntity: 'Author', inversedBy: 'books')]
    #[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id', nullable: false)]
    private ?Author $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDateOfPublication(): ?\DateTimeInterface
    {
        return $this->dateOfPublication;
    }

    public function setDateOfPublication(\DateTimeInterface $dateOfPublication): self
    {
        $this->dateOfPublication = $dateOfPublication;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}