<?php

/**
 * The UserUpdDto class for handling user-related data.
 *
 * This class defines properties for name, last_name, active and provides a method for validating request bodies.
 */

namespace Dtos;

class UserUpdDto
{
  public $name = "";
  public $last_name = "";
  public $active = "";

  /**
   * Validates a request body for required fields (name, last_name, and active).
   *
   * @param object $body The request body to validate.
   * @return object An object containing validation errors (if any) and a validity flag.
   */
  public function validate($body)
  {
    $errors = new \stdClass();
    if (!isset($body->name)) $errors->name = "The name field is required.";
    if (!isset($body->last_name)) $errors->last_name = "The last_name field is required.";
    if (!isset($body->active)) $errors->active = "The active field is required.";
    $response = new \stdClass();
    $response->errors = $errors;
    $response->valid = empty(get_object_vars($errors));
    return $response;
  }
}
