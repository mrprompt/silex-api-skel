<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Entity;

use Datetime;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Exclude;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 *
 * @ORM\MappedSuperclass(repositoryClass="Doctrine\ORM\EntityRepository")
 */
abstract class Entity implements EntityInterface
{
    /**
     * @ORM\Column(name="created", type="datetime", nullable=true, options={"default" = "0000-00-00 00:00:00"})
     * @Exclude
     *
     * @var DateTime
     */
    protected $created;

    /**
     * @ORM\Column(name="updated", type="datetime", nullable=true, options={"default" = "0000-00-00 00:00:00"})
     * @Exclude
     *
     * @var DateTime
     */
    protected $updated;

    /**
     * @ORM\Column(name="status", type="smallint", nullable=true, options={"default" = 1})
     *
     * @var int
     */
    protected $status;

    /**
     * @see \Domain\Entity\Entity::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @see \Domain\Entity\Entity::setId()
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @see \Domain\Entity\Entity::getCreated()
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @see \Domain\Entity\Entity::setCreated()
     *
     * @throws InvalidArgumentException
     */
    public function setCreated(DateTime $createdAt, DateTime $today = null)
    {
        $today = $today ?: new DateTime();

        $tomorrow = clone $today;
        $tomorrow->modify('+1 day');

        if ($createdAt >= $tomorrow) {
            throw new InvalidArgumentException('Create date cannot be in the future');
        }

        $this->created = $createdAt;
    }

    /**
     * @see \Domain\Entity\Entity::getUpdated()
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @see \Domain\Entity\Entity::setUpdated()
     *
     * @throws InvalidArgumentException
     */
    public function setUpdated(DateTime $updatedAt)
    {
        if (is_null($this->created)) {
            throw new InvalidArgumentException('Create must be informed before');
        }

        if ($updatedAt < $this->created) {
            throw new InvalidArgumentException('Update cannot be less than create attribute');
        }

        $this->updated = $updatedAt;
    }

    /**
     * @see \Domain\Entity\Entity::getStatus()
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @see \Domain\Entity\Entity::setStatus()
     *
     * @throws InvalidArgumentException
     */
    public function setStatus($status)
    {
        try {
            v::in([static::NEWER, static::ACTIVE, static::DELETED])->assert($status);

            $this->status = $status;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Status %s is Invalid', $status));
        }
    }

    /**
     * Return when user is newer on the application
     *
     * @return boolean
     */
    public function isNewer()
    {
        return $this->status === static::NEWER;
    }

    /**
     * Return when user is active on the application
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status === static::ACTIVE;
    }

    /**
     * Return when user is deleted from the application
     *
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->status === static::DELETED;
    }

    /**
     * Delete
     *
     * @return boolean
     *
     * @throws OutOfBoundsException
     */
    public function delete()
    {
        if ($this->status === static::DELETED) {
            throw new InvalidArgumentException('Already deleted');
        }

        $this->status = static::DELETED;

        return true;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new Datetime();
        $this->updated = new Datetime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new Datetime();
    }
}
