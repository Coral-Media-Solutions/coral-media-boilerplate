<?php

namespace CoralMedia\Component\Api\Client\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractApiClientCommand extends Command
{

    protected $httpClient;
    protected $params;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params, string $name = null)
    {
        parent::__construct($name);
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    /**
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function getAuthenticationToken()
    {
        $apiParams = $this->params->get('API');

        $response = $this->httpClient->request(
            'POST',
            $apiParams['API_LOGIN_URI'],
            [
                'json' => ['username' => $apiParams['API_USERNAME'], 'password' => $apiParams['API_PASSWORD']]
            ]
        );

        return $response->toArray()['token'];
    }
}