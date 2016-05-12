<?php
declare(strict_types = 1);

namespace Common;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 * @ORM\MappedSuperclass(repositoryClass="Doctrine\ORM\EntityRepository")
 */
trait Entity
{
    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new DateTime();
        $this->updated = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new DateTime();
    }
}
