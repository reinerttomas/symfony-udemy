<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use App\Utils\Strings;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $publishedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isRemoved;

    public function __construct(
        string $title,
        string $content,
        DateTime $publishedAt,
    ) {
        $this->changeTitle($title);
        $this->content = $content;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = null;
        $this->publishedAt = $publishedAt;
        $this->isRemoved = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function changeTitle(string $title): Article
    {
        $slugger = new AsciiSlugger();
        $slug = Strings::unicode($title)->lower()->toString();
        $slug = $slugger->slug($slug)->toString();

        $this->title = $title;
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function changeContent(string $content): Article
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function updated(): Article
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getPublishedAt(): DateTime
    {
        return $this->publishedAt;
    }

    public function changePublishedAt(DateTime $publishedAt): Article
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function isRemoved(): bool
    {
        return $this->isRemoved;
    }

    public function removed(): Article
    {
        $this->isRemoved = true;

        return $this;
    }
}
