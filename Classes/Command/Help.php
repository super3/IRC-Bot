<?php
namespace Command;
class Help extends \Library\IRC\Command\Base
{
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = 'Show information about commands.';
    
    /**
     * How to use the command.
     *
     * @var string
     */
    protected $usage = 'help [optional command]';
    
    /**
     * The number of arguments the command needs.
     *
     * @var mixed
     */
    protected $numberOfArguments = array(0, 1);

    /**
     * Shows help about commands.
     */
    public function command()
    {
        // We don't want any trailing \n, \r or anything in that area.
        $command = (!empty($this->arguments[0]) ? preg_replace('/\s\s+/', '', $this->arguments[0]) : '');
        
        // Get all available commands.
        $commands = $this->bot->getCommands();
        
        // Does this user have privileges?
        $view_all = $this->verifyUser();
        
        // If no command specified we show a list of commands.
        if (empty($command))
        {
            $output = array();
            foreach ($commands as $name => $details)
                if ($view_all || !$details->needsVerification())
                    $output[] = $name;
            $this->say('Available commands: ' . implode(', ', $output));
        }
            
        // Else a command was specified, so try to load the help for it.
        else
        {
            // Get all commands.
            $commands = $this->bot->getCommands();
            
            // Loop through each to get the one we need.
            foreach ($commands as $name => $details)
            {
                if (trim(ucfirst(strtolower($command))) == $name)
                {
		    // We found it!
                    if (empty($details->getHelp()))
                    {
                        // But it doesn't have any help... :(
                        $this->say('No help available for command ' . $name);
                        return;
                    }
                    $help = $details->getHelp();
                    $this->say($name . ': ' . $help[0] . ($details->needsVerification() ? ' (verified users only)' : ''));
                    $this->say('Command usage: ' . $this->bot->commandPrefix . $help[1]);
                    return;
                }
            }

            $this->say('No such command: ' . $command);
        }
    }
}
?> 