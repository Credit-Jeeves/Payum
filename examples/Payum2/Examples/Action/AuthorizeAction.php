<?php
namespace Payum2\Examples\Action;

use Payum2\Action\ActionInterface;
use Payum2\Request\RedirectUrlInteractiveRequest;
use Payum2\Examples\Request\AuthorizeRequest;

class AuthorizeAction implements ActionInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {   
        throw new RedirectUrlInteractiveRequest('http://login.thePayment.com');
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return $request instanceof AuthorizeRequest;
    }
}