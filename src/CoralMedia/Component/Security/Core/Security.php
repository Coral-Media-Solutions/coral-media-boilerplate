<?php


namespace CoralMedia\Component\Security\Core;


use Symfony\Component\Security\Core\Security as BaseSecurity;

class Security extends BaseSecurity
{
    const API_ACTION_GET = 'GET';
    const API_ACTION_POST = 'POST';
    const API_ACTION_PATCH = 'PATCH';
    const API_ACTION_PUT = 'PUT';
    const API_ACTION_DELETE = 'DELETE';
}