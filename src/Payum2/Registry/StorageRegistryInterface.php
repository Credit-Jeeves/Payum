<?php
namespace Payum2\Registry;

use Payum2\Exception\InvalidArgumentException;
use Payum2\Storage\StorageInterface;

interface StorageRegistryInterface 
{
    /**
     * @return string
     */
    function getDefaultStorageName();

    /**
     * @param object|string $class
     * @param string|null $name
     * 
     * @throws InvalidArgumentException if storage with such name not exists
     * 
     * @return StorageInterface
     */
    function getStorageForClass($class, $name = null);

    /**
     * @param string|null $name
     *
     * @throws InvalidArgumentException if storages with such name not exist
     *
     * @return StorageInterface
     */
    function getStorages($name = null);
}