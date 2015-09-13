<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Repository;

/**
 * Repository Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface RepositoryInterface
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
