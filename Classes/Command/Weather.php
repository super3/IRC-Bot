<?php
// Namespace
namespace Command;

/**
 * Sends the weather condition to the channel.
 * arguments[0] == Channel or User to say message to.
 * arguments[1] == Message text.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Matej Velikonja <matej@velikonja.si>
 */
class Weather extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!weather [location]';

    /**
     * Yahoo API key.
     *
     * @var string
     */
    private $yahooKey = '';

    /**
     * Location URI API call
     *
     * @var string
     */
    private $locationUri = "http://where.yahooapis.com/v1/places.q('%s')?appid=%s&format=json";

    /**
     * Weather URI API call
     *
     * @var string
     */
    private $weatherUri = "http://query.yahooapis.com/v1/public/yql?q=%s&format=json";

    /**
     * API for getting location from IP
     *
     * @var string
     */
    private $ipUri = "http://ip-api.com/json/%s";

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = -1;

    /**
     *
     * @param string $yahooKey
     */
    public function __construct($yahooKey) {
        if (empty($yahooKey)) {
            throw new \Exception('Invalid arguments');
        }

        $this->yahooKey = $yahooKey;
    }

    /**
     * Sends the arguments to the channel. Weather for location that user requested.
     *
     */
    public function command() {
        $location = implode(" ", $this->arguments);
        //remove new lines and double spaces
        $location = preg_replace('/\s\s+/', ' ', $location);
        $location = trim($location);
        $location = urlencode($location);

        if (strlen($location) == 0) {
            $this->say(sprintf("Enter location. (Usage: !weather location)"));
            return;
        }

        $this->bot->log("Looking for Woeid for location $location.");

        $locationObject = $this->getLocation($location);

        if ($locationObject) {
            $this->bot->log("Woeid for {$locationObject->name} is {$locationObject->woeid}");

            $weather = $this->getWeather($locationObject->woeid);

            if ($weather) {
                $this->say("Weather for {$locationObject->name}, {$locationObject->country}: " . $weather);
            } else {
                $this->say("Weather for {$locationObject->name}, {$locationObject->country} not found.");
            }

        } else {
            $this->say(sprintf("Location '%s' not found.", $location));
        }
    }

    protected function getWeather($woeid) {
        $yql = sprintf('select * from weather.forecast where woeid=%d and u="c"', $woeid);

        $response = $this->fetch(sprintf($this->weatherUri, urlencode($yql)));
        $jsonResponse = json_decode($response);

        if (!$jsonResponse) {
            return false;
        }

        if (!isset($jsonResponse->query->results)) {
            return false;
        }

        $results = $jsonResponse->query->results;

        $unitTemp = $results->channel->units->temperature;

        $condition = $results->channel->item->condition;

        return $condition->text . ", " . $condition->temp . " " . $unitTemp;
    }

    /**
     * Returns WOEid of $location
     *
     * @param string $location
     * @return int|null
     */
    protected function getLocation($location) {
        $uri = sprintf($this->locationUri, $location, $this->yahooKey);

        $response = $this->fetch($uri);

        $jsonResponse = json_decode($response);

        if ($jsonResponse) {
            if (isset($jsonResponse->places) && isset($jsonResponse->places->place) && is_array($jsonResponse->places->place)) {
                return array_shift($jsonResponse->places->place);
            }
        }

        return null;
    }
}