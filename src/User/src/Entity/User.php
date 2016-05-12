<?php
declare(strict_types = 1);

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Common\Entity;
use InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 * User Entity
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="\User\Repository\User")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    use Entity;

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Type("integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=1024, nullable=false)
     * @Serializer\Type("string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     * @Serializer\Type("string")
     * @Serializer\Exclude
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=true)
     * @Serializer\Type("boolean")
     * @Serializer\Exclude
     * @var bool
     */
    protected $active;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @Serializer\Type("DateTime")
     * @var DateTime
     */
    protected $created;

    /**
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     * @Serializer\Type("DateTime")
     * @var DateTime
     */
    protected $updated;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->active = true;
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id ?: 0;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName(string $name)
    {
        try {
            v::notEmpty()->assert($name);

            $this->name = $name;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException('Name is invalid');
        }
    }

    /**
     * @inheritdoc
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function setEmail(string $email)
    {
        try {
            v::notEmpty()->email()->assert($email);

            $this->email = $email;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException('E-mail is invalid');
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(): bool
    {
        $this->active = false;

        return true;
    }
}
