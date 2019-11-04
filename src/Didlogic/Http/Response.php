<?php


namespace Didlogic\Http;


use Didlogic\Exceptions\ResponseException;

class Response
{
    protected $request;
    protected $content;
    protected $statusCode;
    protected $headers;
    protected $decodedContent = [];
    protected $thrownException;

    /**
     * Response constructor.
     * @param Request|null $request
     * @param null $httpStatusCode
     * @param null $content
     * @param array $headers
     */
    public function __construct(
        Request $request = null,
        $httpStatusCode = null,
        $content = null,
        array $headers = [])
    {
        $this->request = $request;
        $this->content = $content;
        $this->statusCode = (int)$httpStatusCode;
        $this->headers = $headers;

        $this->decodeContent();
    }

    /**
     *
     */
    public function makeException()
    {
        $this->thrownException = new ResponseException(null, null, null, $this->decodedContent, $this->statusCode);
        echo $this->thrownException->getMessage();
    }

    /**
     *
     */
    public function decodeContent()
    {
        $this->decodedContent = json_decode($this->content, true) ?: ["error" => $this->content];
        if (!$this->ok()) {
            $this->makeException();
        }
    }


    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return ResponseException
     */
    public function getThrownException(): ResponseException
    {
        return $this->thrownException;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array|mixed
     */
    public function getContent()
    {
        return $this->decodedContent;
    }

    /**
     * @return bool
     */
    public function ok(): bool
    {
        return $this->getStatusCode() < 400;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '[DidlogicResponse] HTTP ' . $this->getStatusCode() . ' ' . $this->content;
    }

}