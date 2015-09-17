<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Serializer
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Romeu Mattos <romeu.smattos@gmail.com>
 */
class Response extends HttpResponse
{
    /**
     * @inheritDoc
     */
    public function __construct(
        $content = '',
        $status = Response::HTTP_OK,
        $type = 'json',
        $page = 1,
        $lpp = 30,
        $limit = 0
    ) {
        $next       = false;
        $newContent = null;
        $rows       = count($content);
        $pages      = 0;
        $page       = (int) $page;
        $lpp        = (int) $lpp;
        $limit      = (int) $limit;

        if ($lpp > 100) {
            $lpp = 100;
        }

        if ($limit !== 0) {
            if (is_array($content) && $rows !== 0 && !array_key_exists('status', $content)) {
                $content = array_slice($content, 0, $limit);
                $rows    = count($content);
            }
        }

        if (is_array($content) && $rows !== 0 && $rows > $lpp && !array_key_exists('status', $content)) {
            $newContent = array_chunk($content, $lpp);
            $pages      = count($newContent);

            if ($page > $pages) {
                $page = 1;
            }

            if ($page < $pages) {
                $next = true;
            }
        }

        $data = [
            'data'          => $newContent === null ? $content : $newContent[($page - 1)],
            'code'          => $status,
        ];

        $data = array_merge(
            $data,
            [
                'pagination'    => [
                    'rows'      => count($data['data']),
                    'page'      => $pages === 0 ? 1 : $page,
                    'pages'     => $pages,
                    'hasNext'   => $next,
                    'totalRows' => $rows,
                ]
            ]
        );


        if (is_array($data['data']) &&
            array_key_exists('status', $data['data']) &&
            $data['data']['status'] === 'error'
        ) {
            unset($data['pagination']);
        }

        parent::__construct($this->serialize($data, $type), $status, ['Content-type' => 'application/' . $type]);
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
