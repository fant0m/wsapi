<?php


namespace core;

/**
 * Class HttpResponse
 * @package core
 */
class HttpResponse
{
    private $statusCode;
    private $body;
    // @todo include response headers and maybe some other info

    public const STATUS_ERROR = 999;

    /**
     * HttpResponse constructor.
     * @param int $statusCode
     * @param mixed $body
     */
    public function __construct(int $statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }
}
