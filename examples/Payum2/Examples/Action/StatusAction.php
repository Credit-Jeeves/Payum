<?php
namespace Payum2\Examples\Action;

use Payum2\Action\ActionInterface;
use Payum2\Request\StatusRequestInterface;

class StatusAction implements ActionInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute($request)
    {
        $request->markSuccess();
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return $request instanceof StatusRequestInterface;
    }
}