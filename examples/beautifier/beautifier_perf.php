<?php
	/****************************************************************************************************
	 * 
	 * This script uses the RtfStringBeautifier and RtfFileBeautifier classes to process the following
	 * files :
	 * 
	 * - bigfile.rtf
	 * - verybigfile.rtf
	 * 
	 * (note that these files are generated by the create_samples.php script).
	 * 
	 * It generates the following files :
	 * - bigfile.string.txt, the beautified contents of bigfile.rtf using the RtfStringBeautifier class
	 * - bigfile.file.txt, the beautified contents of bigfile.rtf using the RtfFileBeautifier class
	 * - verybigfile.txt, the beautified contents of verybigfile.rtf using the RtfFileBeautifier class
	 *   (the RtfStringBeautifier class won't be used on this file since it's too large to fit into memory)
	 *   
	 * In each case, it outputs the elapsed time in seconds/milliseconds taken by each operation. 
	 * 
	 ****************************************************************************************************/

	 include ( '../../sources/RtfBeautifier.phpclass' ) ;

	 if  ( ! file_exists ( 'bigfile.rtf' ) )
	    {
		echo "You need to run the \"create_samples.php\" file first before running ths script." ;
		exit ;
	     }

	 // Process 'bigfile.rtf' using the RtfStringBeautifier class
	 $tm1	=  microtime ( true ) ;
	 $pp 	=  new RtfStringBeautifier ( file_get_contents ( 'bigfile.rtf' ) ) ;
	 $pp -> SaveTo ( 'bigfile.string.txt' ) ;
	 $tm2	=  microtime ( true ) ;

	 echo ( "Elapsed time for processing 'bigfile.rtf' using RtfStringBeautifier     : " . round ( $tm2 - $tm1, 3 ) . "\n" ) ;

	 // Process 'bigfile.rtf' using the RtfFileBeautifier class
	 $tm1	=  microtime ( true ) ;
	 $pp 	=  new RtfFileBeautifier ( 'bigfile.rtf' ) ;
	 $pp -> SaveTo ( 'bigfile.file.txt' ) ;
	 $tm2	=  microtime ( true ) ;

	 echo ( "Elapsed time for processing 'bigfile.rtf' using RtfFileBeautifier       : " . round ( $tm2 - $tm1, 3 ) . "\n" ) ;

	 // Process 'verybigfile.rtf' using the RtfFileBeautifier class
	 $tm1	=  microtime ( true ) ;
	 $pp 	=  new RtfFileBeautifier ( 'verybigfile.rtf' ) ;
	 $pp -> SaveTo ( 'verybigfile.file.txt' ) ;
	 $tm2	=  microtime ( true ) ;

	 echo ( "Elapsed time for processing 'verybigfile.rtf' using RtfFileBeautifier   : " . round ( $tm2 - $tm1, 3 ) . "\n" ) ;

