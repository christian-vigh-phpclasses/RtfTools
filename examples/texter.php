<?php
	/****************************************************************************************************
	 * 
	 * This script demonstrates the Rtf text extraction capabilities of the RtfTexter classes 
	 * (RtfStringTexter or RtfFileTexter).
	 * 
	 * It extract text contents from file "sample_file.rtf", which contains the first two pages of the
	 * Microsoft Rtf Specifications version 1.9.
	 * 
	 ****************************************************************************************************/

	 include ( 'Rtf.php' ) ;

	 $texter	=  new RtfFileTexter ( 'sample_file.rtf' ) ;
	 echo $texter -> AsText ( ) ;