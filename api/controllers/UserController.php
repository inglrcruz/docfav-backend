<?php

/**
 * The UserController class for managing user-related actions.
 *
 * This class extends the Controller class and provides methods for listing, creating, viewing, updating, and deleting user records.
 */

use System\Controller;
use Repositories\UserRepository;
use Dtos\UserDto;
use Dtos\UserUpdDto;

class UserController extends Controller
{

    private $repository;
    private $userDto;
    private $userUpdDto;

    /**
     * Constructor for the UserController class.
     * Initializes the repository and userDto instances.
     */
    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->userDto = new UserDto();
        $this->userUpdDto = new UserUpdDto();
    }

    /**
     * Retrieves a list of all users.
     * Requires a valid token for access.
     */
    public function index()
    {
        $list = $this->repository->findAll();
        $this->response($list);
    }

    /**
     * Stores a new user if the provided data is valid and the username is not already in use.
     * Requires a valid token for access.
     */
    public function store()
    {
        $valid = $this->userDto->validate($this->body());
        if (!$valid->valid) {
            $this->response($valid->errors, 400);
        } else {
            $exist = $this->repository->findByUsername($this->body()->username);
            if ($exist) {
                $this->response(["message" => "This username is already in use."], 404);
            } else {
                $this->repository->store($this->body());
                $this->response([], 201);
            }
        }
    }

    /**
     * Retrieves a user by their ID.
     * Requires a valid token for access.
     *
     * @param int $id The ID of the user to retrieve.
     */
    public function show($id)
    {
        $user = $this->repository->findById($id);
        if ($user) {
            $this->response($user);
        } else {
            $this->response(["message" => "No user found with the provided ID."], 404);
        }
    }

    /**
     * Updates a user's information if the provided data is valid and the user exists.
     * Requires a valid token for access.
     *
     * @param int $id The ID of the user to update.
     */
    public function update($id)
    {
        $valid = $this->userUpdDto->validate($this->body());
        if (!$valid->valid) {
            $this->response($valid->errors, 400);
        } else {
            $user = $this->repository->findById($id);
            if ($user) {
                $this->repository->update($this->body(), $id);
                $this->response([], 204);
            } else {
                $this->response(["message" => "No user found with the provided ID."], 404);
            }
        }
    }

    /**
     * Deletes a user by their ID if the user exists.
     * Requires a valid token for access.
     *
     * @param int $id The ID of the user to delete.
     */
    public function destroy($id)
    {
        $user = $this->repository->findById($id);
        if ($user) {
            $this->repository->delete($id);
            $this->response([]);
        } else {
            $this->response(["message" => "No user found with the provided ID."], 404);
        }
    }
}
