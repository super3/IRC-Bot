<?php
// Namespace
namespace Listener;

/**
 *
 * @package IRCBot
 * @subpackage Listener
 * @author Matej Velikonja <matej@velikonja.si>
 */
class Joins extends \Library\IRC\Listener\Base {

    /**
     * Main function to execute when listen even occurs
     */
    public function execute($data) {
        $args = $this->getArguments($data);

        $this->say($this->getUserNickName($args[0]) . ", welcome to channel " . $args[2] . ". Try following commands: " . $this->getCommandsName(), $args[2]);
    }

    private function getCommandsName() {
        $commands = $this->bot->getCommands();

        $names = array();
        /* @var $command \Library\IRC\Command\Base */
        foreach ($commands as $name => $command) {
            $names[] = $this->bot->getCommandPrefix() . $name;
        }

        return implode(", ", $names);
    }

    private function getUserNickName($data) {
        $result = preg_match('/:([a-zA-Z0-9_]+)!/', $data, $matches);

        if ($result !== false) {
            return $matches[1];
        }

        return false;
    }

    /**
     * Returns keywords that listener is listening to.
     *
     * @return array
     */
    public function getKeywords() {
        return array("JOIN");
    }
}
