<?php
namespace Library\IRC\Listener;

abstract class Base extends \Library\IRC\Base
{
    /**
     * The listener main function.
     * @param string The raw data the listener receives.
     *
      */
    abstract function execute($data);

    /**
     * Returns keywords that listener is listening to.
     *
     * @return array
     */
    abstract function getKeywords();
}
