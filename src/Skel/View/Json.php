<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\View;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Album Controller
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Json extends Response
{
    /**
     * @inheritDoc
     */
    public function __construct($content = '', $status = Response::HTTP_OK)
    {
        $data = [
            'data' => $content,
            'code' => $status
        ];

        parent::__construct($this->serialize($data, 'json'), $status, ['Content-type' => 'application/json']);
    }

    /**
     *
     * @param mixed $data
     * @param string $type
     * @return mixed
     */
    public function serialize($data, $type)
    {
        $serializer = SerializerBuilder::create()->build();

        return $serializer->serialize($data, $type);
    }
}
