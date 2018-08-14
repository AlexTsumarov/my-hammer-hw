<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends AbstractApi
{
    /**
     * Only read via API.
     * In order to insert data the fixtures and migrations loader/unloader should be triggered for each test.
     *
     */
    const DATA = [
        0 => ['locations', 2],
        1 => ['categories', 2],
        2 => ['job_requests', 1],
        3 => [
            'locations',
            null,
            Response::HTTP_BAD_REQUEST,
            Request::METHOD_POST,
            ['zip' => 32457, 'name' => "Porta Westfalica"]
        ],
    ];

    /**
     * @dataProvider dataProviderDefault
     * @group Json
     * */
    public function testJson($uri,
                             $expectedCount = null,
                             $expectedCode = Response::HTTP_OK,
                             $method = Request::METHOD_GET,
                             $payload = null)
    {
        $response = $this->request($uri, $method, json_encode($payload));
        $this->assertSame($expectedCode, $response->getStatusCode());

        if (!is_null($expectedCount)) {
            $data = json_decode($response->getContent(), true);
            $this->assertSame($expectedCount, count($data));
        }
    }

    /**
     * @dataProvider dataProviderDefaultOnlyGet
     * @group Xml
     */
    public function testXml($uri,
                            $expectedCount = null,
                            $expectedCode = Response::HTTP_OK,
                            $method = Request::METHOD_GET,
                            $payload = null)
    {
        $response = $this->request($uri, $method, $payload, Request::getMimeTypes('xml'));
        $isXml = @simplexml_load_string($response->getContent()) instanceof \SimpleXMLElement;
        $this->assertSame($expectedCode, $response->getStatusCode());
        $this->assertSame(true, $isXml);
    }
}
