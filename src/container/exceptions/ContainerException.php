<?php

namespace frostealth\container\exceptions;

use Interop\Container\Exception\ContainerException as InteropContainerException;
use RuntimeException;

/**
 * Class ContainerException
 *
 * @package frostealth\container
 */
class ContainerException extends RuntimeException implements InteropContainerException
{

}
