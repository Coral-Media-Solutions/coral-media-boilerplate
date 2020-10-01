<?php


namespace CoralMedia\Component\HttpFoundation;


use DOMDocument;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

final class XmlResponse extends Response
{
    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        $this->_validateContent($content);

        parent::__construct($content, $status, $headers);

        $this->headers->set('Content-Type', 'text/xml');
    }

    private function _validateContent(string $content)
    {
        $dom = new DOMDocument();
        $dom->validateOnParse = true;
        if($dom->loadXML($content) === false) {
            throw new InvalidArgumentException('Invalid XML response content');
        }
    }
}