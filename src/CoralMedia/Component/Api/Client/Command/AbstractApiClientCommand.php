<?php

namespace CoralMedia\Component\Api\Client\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
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