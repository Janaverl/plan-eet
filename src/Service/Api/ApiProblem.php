<?php

namespace App\Service\Api;

use Symfony\Component\HttpFoundation\Response;

class ApiProblem
{

    const TYPE_VALIDATION_ERROR = "validation_error";
    const TYPE_INVALID_REQUEST_BODY_FORMAT = "invalid_body_format";
    const TYPE_NOT_FOUND = "type_not_found";
    const TYPE_MUST_BE_UNIQUE_VALUE = "type_must_be_unique_value";

    private static $titles = [
        self::TYPE_VALIDATION_ERROR => "There was a validation error",
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => "Invalid JSON format send",
        self::TYPE_MUST_BE_UNIQUE_VALUE => "Value must be unique",

    ];
    
    private $statusCode;

    private $type;

    private $title;

    private $extraData = array();

    /**
     * ApiProblem constructor.
     * @param $statusCode
     * @param $type
     * @param $title
     */
    public function __construct($statusCode, $type = null)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;
        
        if ($type === null) {
            $this->type = 'about:blank';
        }

        $this->title = isset(self::$titles[$type])
            ? self::$titles[$type]
            : (isset(Response::$statusTexts[$statusCode])
                ? Response::$statusTexts[$statusCode]
                : 'Unknown status code');
    }

    public function toArray()
    {
        return array_merge(
            $this->extraData,
            array(
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title
            )
        );
    }

    public function set($name, $value)
    {
        $this->extraData[$name] = $value;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getTitle()
    {
        return $this->title;
    }
}