<?php 
/**
 * @since      1.0
 * @access     public
 * @author  Maksym Prihodko
 * @package wp-code-deploy
 * @subpackage wp-code-deploy-classes
 */

class WPCD_Logs  
{	

	public static function writeLog( $log )
	{
		$file = fopen( WPCD_PLUGIN_LOGS_DIR.date("Y-m").".log", "a");
		fwrite($file, $log."\r\n");
		fclose($file);
	}

	public static function getLogsList()
	{
		$logFiles = array();
		$filesDirectory = scandir( WPCD_PLUGIN_LOGS_DIR );
		foreach ( $filesDirectory as $filename ) {
			if( preg_match( "/[0-9]{4}-[0-9]{2}.log/", $filename ) )
			{
				$logFiles[$filename] = WPCD_PLUGIN_LOGS_DIR.$filename;
			}
		}
		return $logFiles;
	}

}