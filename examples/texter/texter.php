<?php
	/****************************************************************************************************
	 * 
	 * This script demonstrates the Rtf text extraction capabilities of the RtfTexter classes 
	 * (RtfStringTexter or RtfFileTexter).
	 * 
	 ****************************************************************************************************/

	include ( '../../sources/SearchableFile.phpclass' ) ;
	include ( '../../sources/RtfTexter.phpclass' ) ;

	$texter	=  new RtfFileTexter ( 'sample.rtf' ) ;
	echo $texter -> AsString ( ) ;