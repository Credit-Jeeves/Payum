<?php
namespace Payum2\Request;

use Payum2\Request\BaseInteractiveRequest;

class RedirectUrlInteractiveRequest extends BaseInteractiveRequest
{
    protected $url;
    
    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
}