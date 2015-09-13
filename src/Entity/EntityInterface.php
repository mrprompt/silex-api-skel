<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Entity;

use DateTime;

/**
 * Entity interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface EntityInterface
{
    /**
     * New album
     *
     * @var int
     */
    const NEWER = 1;

    /**
     * Active album
     *
     * @var int
     */
    const ACTIVE = 2;

    /**
     * Removed album
     *
     * @var int
     */
    const DELETED = 3;

    /**
     * @return int
     */
    public function getId();

    /**
     * @param $id
     * @return void
     */
    public function setId($id);

    /**
     * @return DateTime
     */
    public function getCreated();

    /**
     * @param DateTime $createdAt
     * @param DateTime $today
     * @return void
     */
    public function setCreated(DateTime $createdAt, DateTime $today = null);

    /**
     * @return DateTime
     */
    public function getUpdated();

    /**
     * @param DateTime $updatedAt
     * @return void
     */
    public function setUpdated(DateTime $updatedAt);

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @param int $status
     * @return void
     */
    public function setStatus($status);

    /**
     * Return when user is newer on the application
     *
     * @return boolean
     */
    public function isNewer();

    /**
     * Return when user is active on the application
     *
     * @return boolean
     */
    public function isActive();

    /**
     * Return when user is deleted from the application
     *
     * @return boolean
     */
    public function isDeleted();

    /**
     * Delete
     *
     * @return boolean
     *
     * @throws OutOfBoundsException
     */
    public function delete();
}
