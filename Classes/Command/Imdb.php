<?php
// Namespace
namespace Command;

/**
 * Sends IMDB Info to channel.
 *
 * @package IRCBot
 * @subpackage Command
 * @author NeXxGeN (https://github.com/NeXxGeN)
 * 
 */
class Imdb extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
    */
    protected $help = '!imdb [movie title]';

	private $apiUri = 'http://imdbapi.org/?title=%s&type=json&plot=none&episode=0&limit=1&yg=0&mt=none&lang=en-US&offset=&aka=full&release=simple&business=0&tech=0';

    /**
     * The number of arguments the command needs.
     *
     * @var integer
    */
    protected $numberOfArguments = -1;

    /**
     * Search for IMDB Data, and give response to channel
     *
     * IRC-Syntax: PRIVMSG Movie title
    */
    
	public function command()
	{
		$rating = $title = $imdburl = $genres = $runtime = $directors = $rating_count = '';
		
		$imdbtitle = implode(" ", $this->arguments);
		$imdbtitle = preg_replace('/\s\s+/', ' ', $imdbtitle);
		$imdbtitle = trim($imdbtitle);
		$imdbtitle = urlencode($imdbtitle);

		if (!strlen($imdbtitle))
		{
			$this->say(sprintf("Enter movie title. (Usage: !imdb movie title)"));
			return;
		}

		$apiUri  	= sprintf($this->apiUri, $imdbtitle);
		$getjson	= $this->fetch($apiUri);

		$json		= json_decode($getjson, true);

		$count		= 0;
		foreach ($json[0]["also_known_as"] as $key)
		{
			if ($key['country'] == 'Germany' && $count == 0)
			{
				$title = $key['title'];
				$count++;
			}
		}
		if ($title == '')
		{
			$title = $json[0]["title"];
		}

		$rating	= $json[0]["rating"];
		$imdburl	= $json[0]["imdb_url"];
		
		/*
		 * A few other outputs you can use if you want
		
		$genres			= implode("/", $json[0]["genres"]);
		$runtime		= $json[0]["runtime"];
		$directors		= implode("/", $json[0]["directors"]);
		$rating_count	= $json[0]["rating_count"];
		*/
		
		/*
		 * Check if response is given
		*/ 
		if (!strlen($title))
		{
			$this->say("01,8 IMDB  Error fetching data");
			return;
		}
		
		$this->say(sprintf("01,8 IMDB  %s | Wertung %s | %s", $title, $rating, $imdburl));

<<<<<<< HEAD
        $this->say(sprintf('Title: %s | Rating: %s | %s', $title, $rating, $imdbUrl));
    }
}
=======
	}
    
}
>>>>>>> 6b287234a76bf24c480b0857d5215c9ed4cb6f3e
