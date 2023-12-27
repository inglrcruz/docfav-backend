<?php

/**
 * The UserDto class for handling user-related data.
 *
 * This class defines properties for name, last_name, username, and password, and provides a method for validating request bodies.
 */

namespace Dtos;

class UserDto
{
  public $name = "";
  public $last_name = "";
  public $username = "";
  public $password = "";

  /**
   * Validates a request body for required fields (name, last_name, username, and password).
   *
   * @param object $body The request body to validate.
   * @return object An object containing validation errors (if any) and a validity flag.
   */
  public function validate($body)
  {
    $errors = new \stdClass();
    if (!isset($body->name)) $errors->name = "The name field is required.";
    if (!isset($body->last_name)) $errors->last_name = "The last_name field is required.";
    if (!isset($body->username)) $errors->username = "The username field is required.";
    if (!isset($body->password)) $errors->password = "The password field is required.";
    $response = new \stdClass();
    $response->errors = $errors;
    $response->valid = empty(get_object_vars($errors));
    return $response;
  }
}
