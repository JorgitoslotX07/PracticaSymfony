<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserServiceTest extends TestCase
{
    private $em;
    private $passwordEncoder;
    private $repository;
    private UserService $userService;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(ObjectRepository::class);

        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->em->method('getRepository')->willReturn($this->repository);

        $this->passwordEncoder = $this->createMock(UserPasswordEncoderInterface::class);

        $this->userService = new UserService($this->passwordEncoder, $this->em);
    }

    public function testGetAllUsers(): void
    {
        $users = [new User(), new User()];

        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $result = $this->userService->getAllUsers();

        $this->assertSame($users, $result);
    }

    public function testGetUserById(): void
    {
        $user = new User();

        $this->repository->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($user);

        $result = $this->userService->getUserById(123);

        $this->assertSame($user, $result);
    }

    public function testRegisterUser(): void
    {
        $user = new User();
        $plainPassword = 'mypassword';
        $encodedPassword = 'encoded_password';

        $this->passwordEncoder->expects($this->once())
            ->method('encodePassword')
            ->with($user, $plainPassword)
            ->willReturn($encodedPassword);

        $this->em->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->em->expects($this->once())
            ->method('flush');

        $this->userService->registerUser($user, $plainPassword);

        $this->assertSame($encodedPassword, $user->getPassword());
    }

    public function testUpdateUserWithPassword(): void
    {
        $user = new User();
        $plainPassword = 'newpass';
        $encodedPassword = 'encoded_newpass';

        $this->passwordEncoder->expects($this->once())
            ->method('encodePassword')
            ->with($user, $plainPassword)
            ->willReturn($encodedPassword);

        $this->em->expects($this->once())
            ->method('flush');

        $this->userService->updateUser($user, $plainPassword);

        $this->assertSame($encodedPassword, $user->getPassword());
    }

    public function testUpdateUserWithoutPassword(): void
    {
        $user = new User();

        $this->passwordEncoder->expects($this->never())
            ->method('encodePassword');

        $this->em->expects($this->once())
            ->method('flush');

        $this->userService->updateUser($user, null);
    }

    public function testDeleteUser(): void
    {
        $user = new User();

        $this->em->expects($this->once())
            ->method('remove')
            ->with($user);

        $this->em->expects($this->once())
            ->method('flush');

        $this->userService->deleteUser($user);
    }
}
