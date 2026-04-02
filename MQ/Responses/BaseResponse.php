<?php
namespace MQ\Responses;

use MQ\Exception\MQException;

abstract class BaseResponse
{
    protected $succeed;
    protected $statusCode;
    // from header
    protected $requestId;

    abstract public function parseResponse($statusCode, $content);

    abstract public function parseErrorResponse($statusCode, $content, MQException $exception = NULL);

    public function isSucceed()
    {
        return $this->succeed;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    public function getRequestId()
    {
        return $this->requestId;
    }

    protected function loadXmlContent($content)
    {
        $xmlReader = new \XMLReader();
        $isXml = $xmlReader->XML($content);
        if ($isXml === FALSE) {
            throw new MQException($this->statusCode, $content);
        }
        try {
            while ($xmlReader->read()) {}
        } catch (\Exception $e) {
            throw new MQException($this->statusCode, $content);
        }
        $xmlReader->XML($content);
        return $xmlReader;
    }

    protected function loadAndValidateXmlContent($content, &$xmlReader)
    {
        // ====================== 核心修复：清洗非法字符 ======================
        // 过滤 XML 不允许的非法字符：0xFFFE / 0x00~0x1F 等乱码
        $content = preg_replace('/[^\x09\x0A\x0D\x20-\x{D7FF}\x{E000}-\x{FFFD}]/u', '', $content);
        libxml_use_internal_errors(true); // 屏蔽 XML 错误警告
        
        $doc = new \DOMDocument();
        if(!$doc->loadXML($content)) {
            libxml_clear_errors();
            
            return false;
        }
        libxml_clear_errors();
        
        $xmlReader = $this->loadXmlContent($content);
        return true;
    }
}

?>
