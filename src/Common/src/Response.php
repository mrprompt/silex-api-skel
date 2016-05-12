<?php
declare(strict_types = 1);

namespace Common;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Serializer
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Response extends HttpResponse
{
    /**
     * @inheritDoc
     */
    public function __construct($content, int $status = HttpResponse::HTTP_OK)
    {
        $data = [
            'data' => $content,
            'code' => $status,
        ];

        parent::__construct(self::serialize($data), $status, ['Content-type' => 'application/json']);
    }

    /**
     * Serialize data
     *
     * @param  mixed $data
     * @return string
     */
    private static function serialize($data): string
    {
        $serializer = SerializerBuilder::create()->build();

        return $serializer->serialize($data, 'json');
    }
}
