<?php
	/****************************************************************************************************
	 * 
	 * This script demonstrates the usage of the RtfMerger class, by merging files "sample1.rtf" to
	 * "sample4.rtf" and generating file "output.rtf".
	 * 
	 ****************************************************************************************************/

	include ( '../../sources/RtfMerger.phpclass' ) ;

	$merger	=  new RtfMerger ( 'sample1.rtf', 'sample2.rtf', 'sample3.rtf', 'sample4.rtf' ) ;
	$merger -> SaveTo ( "output.rtf" ) ;