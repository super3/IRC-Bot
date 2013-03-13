<?php
// Namespace
namespace Listener;

/**
*
* @package IRCBot
* @subpackage Listener
* @author Matej Velikonja <matej@velikonja.si>
*/
class Images extends \Library\IRC\Listener\Base {

   /**
* Main function to execute when listen even occurs
*/
    public function execute($data) {
		$image = $this->getImageUrl($data);
		
		if ($image)
		{
			$args = $this->getArguments($data);
			#$this->say("Bild gefunden");
			$this->say("Bild gefunden ($image)",$args[2]);
		}
    }


    private function getImageUrl($data) {
        $result = preg_match('((http|https):\/\/[^\s]+(?=\.(jpe?g|png|gif)))', $data, $matches);

        if (isset($matches[0]))
        {
            return $matches[0].'.'.$matches[2];
        }
        return false;
    }
    

    /**
* Returns keywords that listener is listening to.
*
* @return array
*/
    public function getKeywords() {
        return array("PRIVMSG");
    }
}