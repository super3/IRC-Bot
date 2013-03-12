<?
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

        $title     = $json[0]['title'];
        $rating    = $json[0]['rating'];
        $imdbUrl   = $json[0]['imdb_url'];

        /*
         * Check if response is given
        */
        if (!strlen($title)) {
            $this->say('IMDB: Error fetching data');
            return;
        }

        $this->say(sprintf('Title: %s | Rating: %s | %s', $title, $rating, $imdbUrl));
    }
}