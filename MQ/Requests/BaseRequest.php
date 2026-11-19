<?php
namespace MQ\Requests;

abstract class BaseRequest
{
    protected $headers;
    protected $resourcePath;
    protected $method;

    protected $body;
    protected $queryString;
    protected $instanceId;

    public function __construct($instanceId, $method, $resourcePath) {
        $this->instanceId = $instanceId;
        $this->method = $method;
        $this->resourcePath = $resourcePath;
    }

    abstract public function generateBody();
    abstract public function generateQueryString();

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setQueryString($queryString)
    {
        $this->queryString = $queryString;
    }

    public function getQueryString()
    {
        return $this->queryString;
    }

    public function isHeaderSet($header)
    {
        return isset($this->headers[$header]);
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function removeHeader($header)
    {
        if (isset($this->headers[$header]))
        {
            unset($this->headers[$header]);
        }
    }

    public function setHeader($header, $value)
    {
        // psr7 2.11+ deprecates non-string header values and 3.0 rejects them.
        if (is_array($value))
        {
            if ($value === array())
            {
                unset($this->headers[$header]);
                return;
            }
            $this->headers[$header] = array_map('strval', $value);
        }
        else
        {
            $this->headers[$header] = (string)$value;
        }
    }

    public function getResourcePath()
    {
        return $this->resourcePath;
    }

    public function getMethod()
    {
        return $this->method;
    }
}

?>
