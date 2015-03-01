<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Common\Iterator\Filter;

use FilterIterator;
use Iterator;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
class File extends FilterIterator
{
    /**
     * @var array
     */
    private $extensions = [];

    /**
     * Constructor
     *
     * @param Iterator $iterator
     * @param $extensions
     */
    public function __construct(Iterator $iterator, $extensions)
    {
        parent::__construct($iterator);

        $this->extensions = $extensions;
    }

    /**
     * Check whether the current element of the iterator is acceptable
     *
     * @link http://php.net/manual/en/filteriterator.accept.php
     *
     * @return bool true if the current element is acceptable, otherwise false.
     */
    public function accept()
    {
        /* @var $file \SplFileInfo */
        $file = $this->current();

        return $file->isFile() && in_array($file->getExtension(), $this->extensions);
    }
}
