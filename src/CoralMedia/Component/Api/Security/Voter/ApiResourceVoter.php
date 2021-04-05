<?php

namespace CoralMedia\Component\Api\Security\Voter;

use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Component\Security\Model\UserInterface;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

final class ApiResourceVoter extends Voter
{
    private $_annotationReader;
    private $_apiResourceAnnotation;
    private $_security;

    public function __construct(Reader $annotationReader, Security $security) {
        $this->_annotationReader = $annotationReader;
        $this->_apiResourceAnnotation = ApiResource::class;
        $this->_security = $security;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     * @throws ReflectionException
     */
    protected function supports($attribute, $subject)
    {
        $supportsSubject = ($subject ===  UserInterface::ROLE_API || $subject !== null);

        if ($subject !== UserInterface::ROLE_API && $subject !== null && is_object($subject)) {
            $classAnnotation = $this->_annotationReader->getClassAnnotation(
                new ReflectionClass(ClassUtils::getClass($subject)),
                $this->_apiResourceAnnotation
            );
            if ($classAnnotation !== null) {
                $supportsSubject = true;
            }
        }

        $supportsAttribute = in_array(
            $attribute, [
                Request::METHOD_GET,
                Request::METHOD_POST,
                Request::METHOD_DELETE,
                Request::METHOD_PUT,
                Request::METHOD_PATCH
            ]
        );

        return $supportsAttribute && $supportsSubject;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->_security->isGranted(UserInterface::ROLE_SUPERADMIN)) {
            return true;
        }

        if (!$token->isAuthenticated() || !$this->_security->isGranted(UserInterface::ROLE_API)) {
            return false;
        }

        switch ($attribute) {
            case Request::METHOD_POST:
            case Request::METHOD_PATCH:
            case Request::METHOD_DELETE:
            case Request::METHOD_GET:
                return self::ACCESS_GRANTED;
        }

        return false;
    }
}
