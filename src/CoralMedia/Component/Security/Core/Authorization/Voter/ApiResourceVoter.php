<?php


namespace CoralMedia\Component\Security\Core\Authorization\Voter;


use ApiPlatform\Core\DataProvider\PaginatorInterface;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;
use CoralMedia\Component\Security\Core\Security;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ApiResourceVoter extends Voter
{
    protected $resourceNameCollection;
    protected $security;

    /**
     * ApiResourceVoter constructor.
     * @param ResourceNameCollectionFactoryInterface $resourceNameCollection
     * @param Security $security
     * @throws Exception
     */
    public function __construct(ResourceNameCollectionFactoryInterface $resourceNameCollection, Security $security)
    {
        $this->resourceNameCollection = (array) $resourceNameCollection->create()->getIterator();
        $this->security = $security;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool|void
     * @throws Exception
     */
    protected function supports(string $attribute, $subject)
    {
        $supportsSubject = ($subject !== null && in_array(get_class($subject), $this->resourceNameCollection)) ||
            $subject instanceof PaginatorInterface;
        $supportsAttribute = in_array(
            $attribute, [
                Security::API_ACTION_GET,
                Security::API_ACTION_POST,
                Security::API_ACTION_PATCH,
                Security::API_ACTION_PUT,
                Security::API_ACTION_DELETE
            ]
        );
        return $supportsSubject && $supportsAttribute;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        if($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case Security::API_ACTION_GET:
                return $this->security->isGranted(Security::API_ACTION_GET, $subject);
            case Security::API_ACTION_POST:
                return $this->security->isGranted(Security::API_ACTION_POST, $subject);
            case Security::API_ACTION_PATCH:
                return $this->security->isGranted(Security::API_ACTION_PATCH, $subject);
            case Security::API_ACTION_PUT:
                return $this->security->isGranted(Security::API_ACTION_PUT, $subject);
            case Security::API_ACTION_DELETE:
                return $this->security->isGranted(Security::API_ACTION_DELETE, $subject);

        }
        return false;
    }
}