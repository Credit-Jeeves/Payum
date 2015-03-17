<?php
namespace Payum2\Bridge\Buzz;

use Buzz\Message\Response;

use Payum2\Exception\LogicException;

class JsonResponse extends Response
{
    /**
     * @throws \Payum2\Exception\LogicException
     * 
     * @return array|object
     */
    public function getContentJson()
    {
        $json = json_decode($this->getContent());
        if (null === $json) {
            throw new LogicException("Response content is not valid json: \n\n{$this->getContent()}");
        }

        return $json;
    }
}