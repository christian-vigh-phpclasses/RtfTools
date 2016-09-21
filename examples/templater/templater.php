<?php
	/****************************************************************************************************
	 * 
	 * This script demonstrates the Rtf text templating capabilities of the RtfTemplater classes 
	 * (RtfStringTemplater or RtfFileTemplater).
	 * 
	 * It extract text contents from file "template.rtf", which contains a whole set of templating
	 * instructions.
	 * 
	 ****************************************************************************************************/

	include ( '../../sources/RtfTemplater.phpclass' ) ;

	$variables	=  
	   [
		'VNAME1'	=>  'the value of vname1',
		'VNAME2'	=>  'the value of vname2',
		'INDEX'		=>  17,
		'ARRAY'		=>  [ 'string a', 'string b', 'string c' ]
	    ] ;

	 $templater	=  new RtfStringTemplater ( file_get_contents ( 'template.rtf' ), $variables ) ;
	 echo $templater -> AsString ( 'sample.rtf' ) ;