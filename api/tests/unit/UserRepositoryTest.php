<?php

require_once __DIR__ . '/../../repositories/UserRepository.php';

use PHPUnit\Framework\TestCase;
use Repositories\UserRepository;

class UserRepositoryTest extends TestCase
{
    protected $userRepository;

    public function setUp(): void
    {
        $this->userRepository = new UserRepository();

    }

    /**
     * (Tests that the findAll() method returns an array of users.
     */
    public function testFindAll()
    {
        $users = $this->userRepository->findAll();
        $this->assertIsArray($users);
    }

    /**
     * (Tests that the findById() method returns a user object for the given ID.
     */
    public function testFindById(): void
    {
        $userId = 12;
        $user = $this->userRepository->findById($userId);
        $this->assertNotNull($user);
    }

    /**
     * (Tests that the findByUsername() method returns a user object for the given username.
     */
    public function testFindByUsername(): void
    {
        $username = 'lrcruz';
        $user = $this->userRepository->findByUsername($username);
        $this->assertNotNull($user);
    }
}
