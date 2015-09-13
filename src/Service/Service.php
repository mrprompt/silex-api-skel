<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Service;

use Doctrine\ORM\EntityManager;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class Service implements ServiceInterface
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
