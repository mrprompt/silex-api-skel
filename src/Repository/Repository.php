<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
