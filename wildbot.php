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

define( 'ROOT_DIR', __DIR__ );
define( 'DS', DIRECTORY_SEPARATOR );
define( 'PS', PATH_SEPARATOR );
define( 'PE', PHP_EOL );

set_include_path( ROOT_DIR . DS . 'Classes' . DS );

require 'WildBot.php';
WildBot::init();
