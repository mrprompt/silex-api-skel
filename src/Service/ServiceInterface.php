<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Service;

/**
 * Service Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface ServiceInterface
{
    /**
     * Find all
     *
     * @return mixed
     */
    public function findAll();

    /**
     * Find One
     *
     * @param integer $id
     *
     * @return Entity
     */
    public function findById($id);
}
