<?php

namespace Library\IRC;

/**
 * The Log Manager for the bot.
 *
 * @package IRCBot
 * @subpackage Library
 *
 */
class Log
{
	/**
	 * Use a buffer to temporarily store data in. Useful on systems with slow disk access.
	 * @var bool
	 */
	private $useBuffer = false;
	
	/**
	 * The buffer itself.
	 * @var string
	 */
	private $buffer = '';
	
	/**
	 * The flush interval, in seconds.
	 * @var int
	 */
	private $flushInterval = 600;
	
	/**
	 * The time the buffer was last flushed.
	 * @var int
	 */
	private $lastFlushed = 0;
	
	/**
	 * The file handle, used for manipulating the current log file.
	 * @var resource
	 */
	private $handle = '';
	
	/**
	 * The path to the current log file.
	 * @var string
	 */
	private $logFile = '';
	
	/**
	 * Filter the output to only log a specific channel.
	 * @var array
	 */
	private $filterChannels = array();
	
	/**
	 * Set up the class.
	 * @param array $config The configuration variables.
	 */
	public function __construct($config)
	{
		// Can't log to a file not set.
		if (empty($config['file']))
			trigger_error('LogManager: A log file needs to be set to use logging. Aborting.', E_USER_ERROR);
		
		// Also can't log to a directory we can't write to.
		if (!is_writable($config['dir']))
			trigger_error('LogManager: A log file cannot be created in the set directory (' . $config['dir'] . '). Please make it writable. Aborting.', E_USER_ERROR);
		
		// Start off with the base path to the file.
		$this->logFile = $config['dir'] . '/' . $config['file'];
		
		// Now, we're going to count up until we find a file that doesn't yet exist.
		$i = 0;
		do
		{
			$i++;
		}
		while (file_exists($this->logFile . $i . '.log'));
		
		// And fix up the final log name.
		$this->logFile = $this->logFile . $i . '.log';
		
		// Are we only logging output from channels?
		if (!empty($config['filter']))
			$this->filterChannels = $config['filter'];
		
		// Ready!
		if ($this->handle = fopen($this->logFile, 'w'))
			$this->log('Using log file ' . $this->logFile);
		
		// Well this went great...
		else
			trigger_error('LogManager: Cannot create file ' . $this->logFile . '. Aborting.', E_USER_ERROR);
	}
	
	/**
	 * Add data to the log.
	 * @param string $data   The data to add.
	 * @param string $status The status message to add to the data.
	 */
	public function log($data, $status = '')
	{
		// No status? Use log.
		if (empty($status))
		    $status = 'LOG';

		// Add the date and status to the message.
		$msg = date('d.m.Y - H:i:s') . "\t  [ " . $status . " ] \t" . \Library\FunctionCollection::removeLineBreaks($data) . "\r\n";
		
		// Print the message to the console.
		echo $msg;
		
		// If we're filtering channel messages, do so now.
		if (!empty($this->filterChannels))
		{
			$isFromChannel = false;
			foreach ($this->filterChannels as $channel)
			{
				if (stripos($data, 'PRIVMSG ' . $channel . ' :') !== false)
					$isFromChannel = true;
			}
			
			if (!$isFromChannel)
				return;
		}
        
		// Are we using a buffer? If so, queue the message; we'll write it later.
        	if ($this->useBuffer)
        		$this->buffer = $this->buffer . $msg;
			
		// Otherwise, we can just write it.
        	else
        	{
			if (!fwrite($this->handle, $msg))
				echo 'Failed to write message to file...';
		}
	}
	
	/**
	 * Flush any existing buffers to file.
	 */
	public function flush()
	{
		// We can't flush a buffer we don't have.
		if (!$this->hasBuffer())
		{
			$this->log('No buffer to flush. Either the buffer is disabled or has no data.', 'WARNING');
			return false;
		}
		
		// Notify that we're going to flush buffers.
		$this->log('Flushing log buffer to disk...', 'INFO');
		
		// Write it.
		fwrite($this->handle, $this->buffer);
		
		// Update the time we last flushed.
		$this->lastFlushed = microtime(true);
		
		// Clear the buffer.
		$this->buffer = '';
	}
	
	/**
	 * Flush the buffer, but only after a set interval.
	 */
	public function intervalFlush()
	{
		// Time yet?
		if (!$this->useBuffer || (microtime(true) < ($this->lastFlushed + $this->flushInterval)))
			return;
		
		// Make notes.
		$this->log('Doing routine buffer flush. Next buffer flush at ' . date('d-m-Y - H:i:s', (microtime(true) + $this->flushInterval)));
		
		// Yes! It's time!
		$this->flush();
	}
	
	/**
	 * Close the log file.
	 */
	public function close()
	{
		fclose($this->handle);
	}
	
	/**
	 * Check if the log has a buffer.
	 */
	public function hasBuffer()
	{
		// The log has a buffer if the buffer is enabled and not empty.
		return ($this->useBuffer && !empty($this->buffer));
	}
}
?>
