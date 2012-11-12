<?php 

/**
 * get hoststatus from nagios statusfile
 * 
 * @return array:array:string
 */
function nagios_state() {
	$status = shell_exec('cat /usr/local/nagios/var/status.dat');
	
	$results = array();
	preg_match_all('/hoststatus {(.*?)}/s', $status, $results);
	
	$entries = array();
	foreach ($results[1] as $result) {
		$lines = explode("\n", $result);
		$entry = array();
		foreach ($lines as $line) {
			$line = explode('=', $line);
			if (count($line) > 1) {
				$entry[trim($line[0])] = trim($line[1]);
			}
		}
		
		$entries[] = $entry;
	}
	
	return $entries;
}