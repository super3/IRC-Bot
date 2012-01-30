<?php
    /**
     * IRC Bot
     *
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license    http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created Jan 29, 2012 6:58:45 AM
     *
     * @filesource
     */

    /**
     * Description of ExceptionHandler
     *
     * @package IRCBot
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class ExceptionHandler {
        /**
         * Newline string for cli.
         * @var string
         */

        const CLINewlineCharakter = "\n";
        /**
         * Newline string for browser.
         * @var string
         */
        const browserNewlineCharakter = "<br>\n";

        const divider = '/////////////////////////////////////////////';

        /**
         * Displays an excaption in the cli.
         * @param \Exception $exception
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public static function handleCLIException( \Exception $exception ) {
            echo "Uncaught exception Please report this to us, if you think this is a bug!" . self::CLINewlineCharakter . self::CLINewlineCharakter;

            echo self::divider . self::CLINewlineCharakter . self::CLINewlineCharakter;

            echo "\t\tInformation" . self::CLINewlineCharakter;
            echo "Message: \t\t" . $exception->getMessage() . self::CLINewlineCharakter;
            echo "Code: \t\t\t" . $exception->getCode() . self::CLINewlineCharakter;
            echo "More information:\t" . Bootstrap::url_to_exception . '#' . $exception->getCode() . self::CLINewlineCharakter . self::CLINewlineCharakter;

            echo self::divider . self::CLINewlineCharakter . self::CLINewlineCharakter;

            echo "\t\tFor bug report" . self::CLINewlineCharakter;
            echo "Current Environment: \tCLI" . self::CLINewlineCharakter;
            echo "Current Version: \t" . Bootstrap::version . self::CLINewlineCharakter;
            echo "Authors: \t\t" . Bootstrap::authors . self::CLINewlineCharakter . self::CLINewlineCharakter;
            echo "File: \t\t" . $exception->getFile() . self::CLINewlineCharakter;
            echo "Line: \t\t" . $exception->getLine() . self::CLINewlineCharakter;
            echo "Trace:" . self::CLINewlineCharakter;
            echo $exception->getTraceAsString() . self::CLINewlineCharakter;
            if (!is_null( $exception->getPrevious() )) {
                self::handleCLIException( $exception->getPrevious() );
            }
        }

        public static function handleBrowserException( \Exception $exception ) {
            echo 'Current Environment: Browser' . self::browserNewlineCharakter;
            echo "Uncaught exception: " . $exception->getMessage() . self::browserNewlineCharakter;
        }

    }
?>
