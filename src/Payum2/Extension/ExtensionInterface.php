<?php
namespace Payum2\Extension;

use Payum2\Action\ActionInterface;
use Payum2\Request\InteractiveRequestInterface;


interface ExtensionInterface 
{
    /**
     * @param mixed $request
     *
     * @return void
     */
    function onPreExecute($request);

    /**
     * @param mixed $request
     * @param \Payum2\Action\ActionInterface $action
     *
     * @return void
     */
    function onExecute($request, ActionInterface $action);

    /**
     * @param mixed $request
     * @param \Payum2\Action\ActionInterface $action
     *
     * @return void
     */
    function onPostExecute($request, ActionInterface $action);

    /**
     * @param \Payum2\Request\InteractiveRequestInterface $interactiveRequest
     * @param mixed $request
     * @param \Payum2\Action\ActionInterface $action
     *
     * @return null|InteractiveRequestInterface an extension able to change interactive request to something else.
     */
    function onInteractiveRequest(InteractiveRequestInterface $interactiveRequest, $request, ActionInterface $action);

    /**
     * @param \Exception $exception
     * @param mixed $request
     * @param \Payum2\Action\ActionInterface $action
     *
     * @return void
     */
    function onException(\Exception $exception, $request, ActionInterface $action = null);
}