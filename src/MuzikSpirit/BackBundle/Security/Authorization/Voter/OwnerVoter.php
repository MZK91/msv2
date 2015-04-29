<?php
namespace MuzikSpirit\BackBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use MuzikSpirit\BackBundle\Entity\News;

class OwnerVoter implements VoterInterface
{

    public function supportsAttribute($attribute)
    {
        return true;
    }

    public function supportsClass($class)
    {
        return true;
    }

    /**
     * @var \AppBundle\Entity\Post $post
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {

        /**
         * VoterInterface::ACCESS_DENIED
         * VoterInterface::ACCESS_GRANTED
         * VoterInterface::ACCESS_ABSTAIN
         */
        $user = $token->getUser();
        //exit(dump($user));

        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if(method_exists($object, 'getUser') && $object instanceof News){
            exit(dump($object->getUser()));
            if($object->getUser()->getId() == $user->getId()){
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}