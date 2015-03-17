<?php
namespace Payum2\Examples\Action;

use Payum2\Action\PaymentAwareAction;
use Payum2\Examples\Model\AuthorizeRequiredModel;
use Payum2\Request\CaptureRequest;
use Payum2\Examples\Request\AuthorizeRequest;

class CaptureAction extends  PaymentAwareAction
{
    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {   
        /** @var $request CaptureRequest */
        if ($request->getModel() instanceof AuthorizeRequiredModel) {
            $this->payment->execute(new AuthorizeRequest);
        }
        
        //sell code here.
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return $request instanceof CaptureRequest;
    }
}
