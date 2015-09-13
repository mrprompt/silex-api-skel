<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Entity\Users;

/**
 * User Entity Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface UserInterface
{
    /**
     * Set Name
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setName($Name = '');

    /**
     * Get the Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set the email
     *
     * @param string $email
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setEmail($email);

    /**
     * Get the password
     *
     * @return string
     */
    public function getPassword();

    /**
     * Set the password
     *
     * @param string $password
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setPassword($password);
}
