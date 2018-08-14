<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractApi extends WebTestCase
{
    const API_PREFIX = 'api';
    const DATA       = [];

    /* @var Client $client */
    private $client;
    /* @var [] $defaultAccept */
    private $defaultAccept;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->defaultAccept = Request::getMimeTypes('json');
    }

    public static function dataProviderDefault($data = null)
    {
        $arr = [];
        $src = !is_array($data) ? static::DATA : $data;
        array_walk(
            $src,
            function ($item) use (&$arr) {
                $uri = $item[0];
                $method = isset($item[3]) ? $item[3] : Request::METHOD_GET;
                $id = sprintf('%s %s', $uri, $method);
                $arr[$id] = $item;
            }
        );
        return $arr;
    }

    public static function dataProviderDefaultOnlyGet()
    {
        $arr = array_filter(
            static::DATA,
            function ($a) {
                return !isset($a[3]) || $a[3] === Request::METHOD_GET;
            }
        );
        return static::dataProviderDefault($arr);
    }

    /**
     * @return Response
     * */
    protected function request($uri, $method, $payload, $accept = null)
    {
        $accept = is_null($accept) ? $this->defaultAccept : $accept;
        $this->client->request(
            $method,
            sprintf('/%s/%s', static::API_PREFIX, $uri),
            array(),
            array(),
            array(
                'CONTENT_TYPE' => $accept,
                'HTTP_ACCEPT'  => $accept,
            ),
            $payload
        );
        return $this->client->getResponse();
    }
}
