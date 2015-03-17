<?php
namespace Payum2;

use Payum2\Exception\LogicException;
use Payum2\Exception\UnsupportedApiException;
use Payum2\Extension\ExtensionCollection;
use Payum2\Extension\ExtensionInterface;
use Payum2\Request\InteractiveRequestInterface;
use Payum2\Action\ActionInterface;
use Payum2\Exception\RequestNotSupportedException;

class Payment implements PaymentInterface
{
    /**
     * @var ActionInterface[]
     */
    protected $actions = array();

    /**
     * @var mixed[]
     */
    protected $apis = array();

    /**
     * @var ExtensionCollection
     */
    protected $extensions;

    /**
     */
    public function __construct()
    {
        $this->extensions = new ExtensionCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function addApi($api)
    {
        $this->apis[] = $api;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addAction(ActionInterface $action, $forcePrepend = false)
    {
        if ($action instanceof PaymentAwareInterface) {
            $action->setPayment($this);
        }
        
        if ($action instanceof ApiAwareInterface) {
            $apiSet = false;
            foreach ($this->apis as $api) {
                try {
                    $action->setApi($api);
                    $apiSet = true;
                    break;
                } catch (UnsupportedApiException $e) {}
            }
            
            if (false == $apiSet) {
                throw new LogicException(sprintf(
                    'Cannot find right api supported by %s',
                    get_class($action)
                ));
            }
        }

        $forcePrepend ?
            array_unshift($this->actions, $action) :
            array_push($this->actions, $action)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtension(ExtensionInterface $extension, $forcePrepend = false)
    {
        $this->extensions->addExtension($extension, $forcePrepend);
    }

    /**
     * {@inheritdoc}
     */
    public function execute($request, $catchInteractive = false)
    {
        $action = null;
        try {
            $this->extensions->onPreExecute($request);
            
            if (false == $action = $this->findActionSupported($request)) {
                throw RequestNotSupportedException::create($request);
            }
            
            $this->extensions->onExecute($request, $action);
        
            $action->execute($request);
            
            $this->extensions->onPostExecute($request, $action);
        } catch (InteractiveRequestInterface $interactiveRequest) {
            $interactiveRequest = 
                $this->extensions->onInteractiveRequest($interactiveRequest, $request, $action) ?:
                $interactiveRequest
            ;
            
            if ($catchInteractive) {                
                return $interactiveRequest;
            }
            
            throw $interactiveRequest;
        } catch (\Exception $e) {
            $this->extensions->onException($e, $request, $action);
            
            throw $e;
        }
    }

    /**
     * @param mixed $request
     *
     * @return ActionInterface|null
     */
    protected function findActionSupported($request)
    {
        foreach ($this->actions as $action) {
            if ($action->supports($request)) {
                return $action;
            }
        }
    }
}