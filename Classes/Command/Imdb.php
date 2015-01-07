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
    protected $help = 'Get information about IMDB movies.';
    
    /**
     * How to use the command.
     *
     * @var string
     */
    protected $usage = 'imdb [movie title]';

    /**
     * The API URL used for this command.
     *
     * @var string
     */
    private $apiUri = 'http://omdbapi.com/?t=%s&r=json&plot=short';

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
        $imdbTitle = implode(' ', $this->arguments);
        $imdbTitle = preg_replace('/\s\s+/', ' ', $imdbTitle);
        $imdbTitle = trim($imdbTitle);
        $imdbTitle = urlencode($imdbTitle);

        if (!strlen($imdbTitle)) {
            $this->say(sprintf('Enter movie title. (Usage: !imdb movie title)'));
            return;
        }

        $apiUri  = sprintf($this->apiUri, $imdbTitle);
        $getJson = $this->fetch($apiUri);

        $json = json_decode($getJson, true);

        $title     = $json['Title'];
        $rating    = $json['imdbRating'];
        $shortPlot = $json['Plot'];
        $link      = 'http://www.imdb.com/title/' . $json['imdbID'];

        /*
         * Check if response is given
        */
        if (!strlen($title)) {
            $this->say('IMDB: Error fetching data');
            return;
        }

        $this->say(sprintf('Title: %s | Rating: %s | %s | %s', $title, $rating, $shortPlot, $link));
    }
}

