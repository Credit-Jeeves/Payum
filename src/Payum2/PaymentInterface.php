<?php
namespace Payum2;

use Payum2\Action\ActionInterface;
use Payum2\Extension\ExtensionInterface;

interface PaymentInterface
{
    /**
     * @param mixed $api
     *
     * @return void
     */
    function addApi($api);

    /**
     * @param ActionInterface $action
     * @param bool $forcePrepend
     *
     * @return void
     */
    function addAction(ActionInterface $action, $forcePrepend = false);

    /**
     * @param \Payum2\Extension\ExtensionInterface $extension
     * @param bool $forcePrepend
     *
     * @return void
     */
    function addExtension(ExtensionInterface $extension, $forcePrepend = false);

    /**
     * @param mixed $request
     * @param boolean $catchInteractive
     * 
     * @throws \Payum2\Exception\RequestNotSupportedException if any action supports the request.
     * @throws \Payum2\Request\InteractiveRequestInterface if $catchInteractive parameter set to false.
     * 
     * @return \Payum2\Request\InteractiveRequestInterface|null
     */
    function execute($request, $catchInteractive = false);
}