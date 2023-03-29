<?php

namespace App\Security\Voter;

use App\Entity\Duck;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class DuckVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const USER = ["ROLE_USER"];
    public const ADMIN = ["ROLE_ADMIN"];

//    private $requestStack;
//
//    public function __construct($requestStack) {
//        $this->requestStack = $requestStack;
//    }
//    private function getUid() {
//        return  $this->requestStack->getMasterRequest()->get('uid');
//    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Duck;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        //$attribute = "edit" ou "view"
        //$subject = le duck log

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
//        dd($subject);
//        dd($subject->getRoles());
//        dd($user->getRoles()[0]);

        if ($user->getRoles() == ["ROLE_ADMIN", "ROLE_USER"]) {
            return true;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                if ($user->getRoles() == self::USER) {
                    if ($subject->getId() == $user->getId()) {
                        return true;
                    }
                }
                return false;
            case self::VIEW:
                if ($user->getRoles() == ["ROLE_USER"]) {
                    return true;
                }
                return false;
        }
        return false;
    }
}
