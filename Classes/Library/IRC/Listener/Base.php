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

    /**
     * Sends PRIVMSG to source with $msg
     *
     * @param string $msg
     */
    protected function say($msg, $source) {
        $this->connection->sendData(
                'PRIVMSG ' . $source . ' :' . $msg
        );
    }

    /**
     * Returns the raw data as an array of parsed data.
     * @param string $data
     * @return array
     */
    protected function getArguments($data) {
        $args = explode( ' ', $data );
        $func = function($value) {
            return trim( \Library\FunctionCollection::removeLineBreaks( $value ) );
        };
        
        // Strip leading colons off messages (that are meant to be seen by IRC only), only look at   //
        // the first three elements to avoid cutting off a user who starts an argument with a colon. //
        // Corrects :test!example@example.com PRIVMSG #cs :foo bar :baz ::: to                       //
        //           test!example@example.com PRIVMSG #cs  foo bar :baz :::                          //
        // This is useful because it means listener writers don't have to manually remove these      //
        // characters (which is what Joins.php was doing).                                           //
        for($i = 0; $i <= (((sizeof($args) - 1 ) < 3) ? (sizeof($args) -1) : 3); $i++)
            $args[$i] = (strpos($args[$i], ":") === 0) ? substr($args[$i], 1) : $args[$i];
        ///////////////////////////////////////////////////////////////////////////////////////////////

        return array_map($func, $args);
    }
}
