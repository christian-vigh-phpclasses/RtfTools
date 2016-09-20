<?php
	/****************************************************************************************************
	 * 
	 * This script uses the RtfStringBeautifier to beautify file "sample.rtf" and echoes the beautified
	 * contents onto its standard output.
	 * 
	 ****************************************************************************************************/

	 include ( '../../sources/SearchableFile.phpclass' ) ;
	 include ( '../../sources/RtfBeautifier.phpclass' ) ;

	 if  ( php_sapi_name ( )  !=  'cli' )
		echo "<pre>" ;

	 $pp	=  new RtfStringBeautifier ( file_get_contents ( 'sample.rtf' ) ) ;
	 echo $pp -> AsString ( ) ;
