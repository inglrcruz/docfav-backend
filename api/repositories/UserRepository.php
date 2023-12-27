<?php

/**
 * The UserRepository class for handling user-related database operations.
 *
 * This class extends the Model class and provides methods for storing, updating, retrieving, and deleting user records.
 */

namespace Repositories;

use System\Repository;
use Dtos\UserDto;
use Dtos\UserUpdDto;
use stdClass;

class UserRepository extends Repository
{

    /**
     * Stores a new user record in the database.
     *
     * @param object $body The request body containing user data.
     * @return bool True on success, false on failure.
     */
    public function store($body)
    {
        $user = new UserDto();
        $user->name = $body->name;
        $user->last_name = $body->last_name;
        $user->username = $body->username;
        $user->password = md5($body->password);
        return $this->orm->insert('users', $user);
    }

    /**
     * Updates an existing user record in the database.
     *
     * @param object $body The request body containing updated user data.
     * @param int $id The ID of the user to be updated.
     * @return bool True on success, false on failure.
     */
    public function update($body, $id)
    {
        $user = new UserUpdDto();
        $user->name = $body->name;
        $user->last_name = $body->last_name;
        $user->active = intval($body->active);
        $where = new stdClass();
        $where->user_id = $id;
        return $this->orm->update('users', $user, $where);
    }

    /**
     * Retrieves all user records from the database.
     *
     * @return array An array of user records.
     */
    public function findAll()
    {
        return $this->orm->findAll('users');
    }

    /**
     * Retrieves a user record by ID from the database.
     *
     * @param int $id The ID of the user to retrieve.
     * @return object|null The user record as an object, or null if not found.
     */
    public function findById($id)
    {
        return $this->orm->findOne('users', ["user_id" => $id]);
    }

    /**
     * Retrieves a user record by username from the database.
     *
     * @param string $username The username of the user to retrieve.
     * @return object|null The user record as an object, or null if not found.
     */
    public function findByUsername($username)
    {
        return $this->orm->findOne('users', ["username" => $username]);
    }

    /**
     * Deletes a user record from the database by ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True on success, false on failure.
     */
    public function delete($id)
    {
        return $this->orm->delete('users', ["user_id" => $id]);
    }
}
