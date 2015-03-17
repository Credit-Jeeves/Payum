<?php
namespace Payum2\Action;

use Payum2\Exception\RequestNotSupportedException;
use Payum2\Model\DetailsAggregateInterface;
use Payum2\Request\CaptureRequest;

class CaptureDetailsAggregatedModelAction extends PaymentAwareAction
{
    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {
        /** @var $request CaptureRequest */
        if (false == $this->supports($request)) {
            throw RequestNotSupportedException::createActionNotSupported($this, $request);
        }

        $request->setModel($request->getModel()->getDetails());
        
        $this->payment->execute($request);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return 
            $request instanceof CaptureRequest &&
            $request->getModel() instanceof DetailsAggregateInterface && 
            $request->getModel()->getDetails()
        ;
    }
}