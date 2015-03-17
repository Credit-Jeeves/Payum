<?php
namespace Payum2\Request;

use Payum2\Model\TokenizedDetails;
use Payum2\Request\CaptureRequest;

class CaptureTokenizedDetailsRequest extends CaptureRequest
{
    /**
     * @var \Payum2\Model\TokenizedDetails
     */
    protected $tokenizedDetails;

    /**
     * @param \Payum2\Model\TokenizedDetails $tokenizedDetails
     */
    public function __construct(TokenizedDetails $tokenizedDetails)
    {
        $this->tokenizedDetails = $tokenizedDetails;

        $this->setModel($tokenizedDetails);
    }

    /**
     * @return \Payum2\Model\TokenizedDetails
     */
    public function getTokenizedDetails()
    {
        return $this->tokenizedDetails;
    }
}