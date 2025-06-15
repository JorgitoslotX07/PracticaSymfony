<?php
namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $em;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $em;
    }

    public function registerUser(User $user, string $plainPassword): void
    {
        $encoded = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);

        $this->em->persist($user);
        $this->em->flush();
    }
}

