<?php

namespace App\Security\Voter;

use App\Entity\Project;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class FrontendVoter extends Voter
{
    public const string ACTIVE = 'active';
    public const string PUBLISHED_AND_ACTIVE = 'published_and_active';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (in_array($attribute, [self::ACTIVE, self::PUBLISHED_AND_ACTIVE])) {
            if ($subject instanceof Project) {
                return true;
            }
        }

        return false;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return match ($attribute) {
            self::ACTIVE => $this->isActive($subject),
            self::PUBLISHED_AND_ACTIVE => $this->isPublishedAndActive($subject),
            default => throw new \LogicException('This code should not be reached!'),
        };
    }

    private function isActive(mixed $subject): bool
    {
        return $subject->isActive();
    }

    private function isPublishedAndActive(mixed $subject): bool
    {
        return $subject->showInFrontend() && $subject->isActive();
    }
}
