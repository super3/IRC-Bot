<?php
/**
 * WildBot
 *
 * LICENSE: This source file is subject to Creative Commons Attribution
 * 3.0 License that is available through the world-wide-web at the following URI:
 * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
 * and use this script commercially/non-commercially. My only requirement is that
 * you keep this header as an attribution to my work. Enjoy!
 *
 * @license http://creativecommons.org/licenses/by/3.0/
 *
 * @package WildBot
 * @author Hoshang Sadiq <superaktieboy@gmail.com>
 */

/**
 * Main WildBot class.
 * This will invoke everything
 *
 * @package WildBot
 *         
 * @author Hoshang Sadiq <superaktieboy@gmail.com>
 */
class WildBot {
    /**
     * This contains the registered data
     * 
     * @var array
     */
    private static $_registry = array ();
    
    /**
     * This will contain the bot class
     * 
     * @var \Library\IRC\Bot
     */
    public static $bot = null;
    
    /**
     * Initiates the application.
     * Loads the autoloader and runs the configurations
     */
    public static function init() {
        require_once ( 'Autoloader.php' );
        spl_autoload_register( 'Autoloader::load' );
        date_default_timezone_set( 'Europe/London' );
        
        self::$bot = new Library\IRC\Bot();
        self::configure();
        self::registerCommands();
        self::registerListeners();
        
        if ( function_exists( 'setproctitle' ) ) {
            $title = basename( __FILE__, '.php' ) . ' - ' . self::get( 'config' )->nick;
            setproctitle( $title );
        }
        
        // Connect to the server.
        self::$bot->connectToServer();
    }
    
    /**
     * Loads and saves the configuration to the registry
     */
    public static function configure() {
        if ( file_exists( ROOT_DIR . DS . 'config.local.php' ) ) {
            $config = include_once ( ROOT_DIR . DS . 'config.local.php' );
        } else {
            $config = include_once ( ROOT_DIR . DS . 'config.php' );
        }
        self::set( 'config', (object) $config );
        self::$bot->configure();
    }
    
    /**
     * Finds all the commands and registers them
     */
    public static function registerCommands() {
        // Add commands to the bot.
        foreach ( self::get( 'config' )->commands as $class => $args ) {
            try {
                $command = new $class( $args ); // Try to instantiate a new command
                                                    // with the arguments.
            } catch ( Exception $e ) {
                $command = new $class(); // Try to instantiate a new command with no
                                         // arguments if it fails to work before.
                if ( !empty( $args ) )
                    self::$bot->log( 'The command "' . $class . '" has arguments in the config but doesn\'t accept any!', 'WARNING' );
            }
            
            self::$bot->addCommand( $command );
        }
    }
    
    /**
     * Finds all the listeners and registers them
     */
    public static function registerListeners() {
        foreach ( self::get( 'config' )->listeners as $class => $args ) {
            try {
                $listener = new $class( $args ); // Try to instantiate a new
                                                 // listener
                                                 // with the arguments.
            } catch ( Exception $e ) {
                $listener = new $class(); // Try to instantiate a new listener with
                                          // no arguments if it fails to work
                                          // before.
                if ( !empty( $args ) )
                    self::$bot->log( 'The listener "' . $class . '" has arguments in the config but doesn\'t accept any!', 'WARNING' );
            }
            
            self::$bot->addListener( $listener );
        }
    }
    
    /**
     * Register a new variable
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set( $key, $value ) {
        self::$_registry[$key] = $value;
    }
    
    /**
     * Unregister a variable from register by key
     *
     * @param string $key
     */
    public static function unregister( $key ) {
        if ( isset( self::$_registry[$key] ) ) {
            if ( is_object( self::$_registry[$key] ) && ( method_exists( self::$_registry[$key], '__destruct' ) ) ) {
                self::$_registry[$key]->__destruct();
            }
            unset( self::$_registry[$key] );
        }
    }
    
    /**
     * Retrieve a value from registry by a key
     *
     * @param string $key
     * @return mixed
     */
    public static function get( $key ) {
        if ( isset( self::$_registry[$key] ) ) {
            return self::$_registry[$key];
        }
        return null;
    }
}
