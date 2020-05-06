<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 2019-04-09
 * Time: 08:20
 */

namespace App\Security;

use App\Entity\Bug;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AutorizationBugVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])){
            return false;
        }
        if (!$subject instanceof Bug) {
            return false;
        }
        return true;
    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User){
            return false;
        }

        if ($user !== $subject->getUserBug()){
            return false;
        }
        return true;
    }
}