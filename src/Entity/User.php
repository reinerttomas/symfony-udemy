<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $surname;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $password;

    /**
     * @var array<int, string>
     * @ORM\Column(type="json")
     */
    private array $roles;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt;

    public function __construct(
        string $name,
        string $surname,
        string $email,
    ) {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = null;
        $this->roles = [];
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getFullname(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function changeName(string $name, string $surname): User
    {
        $this->name = $name;
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function changeEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantee every user at least has ROLE_USER
        if ($roles === []) {
            $roles[] = UserRole::user()->getValue();
        }

        return $roles;
    }

    public function addRole(UserRole $userRole): User
    {
        $this->roles[] = $userRole->getValue();

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function changePassword(string $password): User
    {
        $this->password = $password;

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

    public function updated(): User
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
