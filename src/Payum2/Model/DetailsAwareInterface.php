<?php
namespace Payum2\Model;

interface DetailsAwareInterface  
{
    /**
     * @param object $details
     * 
     * @return void
     */
    function setDetails($details);
}