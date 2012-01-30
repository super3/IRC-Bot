<?php
    /**
     * This file contains the class: 'Exception'.
     *
     * @package
     * @subpackage
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created Jan 29, 2012 7:40:09 AM
     *
     * @filesource
     */

    namespace Library;

    /**
     * Description of Exception
     *
     * @package
     * @subpackage
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class Exception extends \Exception {

        /**
         * Creates a new Exception.
         * @param string     $message  The message of the Exception.
         * @param integer    $code     The status code of the Exception.
         * @param \Exception $previous The prevous Exception.
         */
        function __construct( $message, $code = 0, \Exception $previous = null ) {
            // some code
            // make sure everything is assigned properly
            parent::__construct( $message, $code, $previous );
        }

    }
?>
