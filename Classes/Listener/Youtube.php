<?php
// Namespace
namespace Listener;

/**
*
* @package IRCBot
* @subpackage Listener
* @author NeXxGeN (https://github.com/NeXxGeN)
*/
class Youtube extends \Library\IRC\Listener\Base {

	private $apiUri = "http://gdata.youtube.com/feeds/api/videos/%s";

	/**
	* Main function to execute when listen even occurs
	*/
	public function execute($data)
	{
		$ytTitle = $this->getYtTitle($data);
		if ($ytTitle)
		{
			$args = $this->getArguments($data);
			$this->say(sprintf("01,00You00,05Tube %s", $ytTitle),$args[2]);
		}
	}

	private function getYtTitle($data)
    {
		preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $data, $matches);
		if (isset($matches[0]))
		{
			$ytApi		= sprintf($this->apiUri, $matches[0]);
			$Ytdata	= $this->fetch($ytApi);
			preg_match("/(?<=<title type=\'text\'>).*(?=<\/title>)/", $Ytdata, $ytTitle); 
			return $ytTitle[0];
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