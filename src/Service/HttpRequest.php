<?php


namespace App\Service;


use Symfony\Component\HttpClient\HttpClient;

class HttpRequest
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * HttpRequest constructor.
     */
    public function __construct()
    {
        $this->client = HttpClient::create([
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
    }

    /**
     * @param String $verbe
     * @param String $url
     * @param array $data
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function request($verbe,$url, array $data)
    {
        $response = $this->client->request($verbe,$url,$data);
        $status = $response->getStatusCode();
        $content = $response->toArray();
        return [
            'status'=>$status,
            'content'=>$content
        ];
    }
}