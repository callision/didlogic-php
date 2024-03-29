<?php


namespace Didlogic\Exceptions;

use Throwable;

class ResponseException extends RestException
{
    protected $responseData;
    protected $statusCode;

    /**
     * ResponseException constructor.
     * @param string|null $message
     * @param int|null $code
     * @param Throwable|null $previous
     * @param $responseData
     * @param $statusCode
     */
    public function __construct(?string $message, ?int $code, ?Throwable $previous, $responseData, $statusCode)
    {
        $this->responseData = $responseData;
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $this->getException($this->getErrorMessage()));
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        if (array_key_exists('error', $this->responseData ?: [])) {
            if (is_string($this->responseData['error'])) {
                return json_encode($this->responseData['error']);
            } elseif (array_key_exists('error', $this->responseData['error'])) {
                return json_encode($this->responseData['error']['error']);
            } else {
                return json_encode($this->responseData['error']);
            }
        } else {
            return "Unknown REST client error";
        }
    }

    /**
     * @param $message
     * @return RestException
     */
    public function getException($message): RestException
    {
        return new RestException($message);
    }
}