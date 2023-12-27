<?php

/**
 * The Controller class for handling HTTP request and response operations.
 *
 * This class provides methods for parsing the request body as JSON and sending JSON responses, with optional
 * HTTP status codes.
 */

namespace System;

class Controller
{

    /**
     * Parses the request body as JSON and returns it as an object.
     *
     * @return object|null The parsed JSON request body as an object, or null if it's empty or invalid JSON.
     */
    public function body()
    {
        $request_body = file_get_contents('php://input');
        return (object) json_decode($request_body, true);
    }

    /**
     * Sends a JSON response with an optional HTTP status code.
     *
     * @param mixed $body The response data to be JSON-encoded.
     * @param int|string $code The HTTP status code for the response (optional).
     */
    public function response($body, $code = '')
    {
        if ($code) http_response_code($code);
        if ($body) echo json_encode($body);
        //exit;
    }
}
