<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tags = null;

    #[ORM\ManyToOne(inversedBy: 'quacks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Duck $duck_id = null;

    #[ORM\Column]
    private ?bool $is_comment = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_linked_post = null;

    public function __construct()
    {
        $this->created_at = (new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getDuckId(): ?Duck
    {
        return $this->duck_id;
    }

    public function setDuckId(?Duck $duck_id): self
    {
        $this->duck_id = $duck_id;

        return $this;
    }

    public function isIsComment(): ?bool
    {
        return $this->is_comment;
    }

    public function setIsComment(bool $is_comment): self
    {
        $this->is_comment = $is_comment;

        return $this;
    }

    public function getIdLinkedPost(): ?int
    {
        return $this->id_linked_post;
    }

    public function setIdLinkedPost(?int $id_linked_post): self
    {
        $this->id_linked_post = $id_linked_post;

        return $this;
    }
}
