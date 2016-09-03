<?php
	/****************************************************************************************************
	
		Creates two files by catenating the contents of 'sample_file.rtf' located in this directory :

		- 'bigfile.rtf', which will be around 40Mb
		- 'verybigfile.rtf', which will be around 800Mb. This is big enough to cause a fatal error
		  when trying to read it into memory (at least on Windows systems).

		Of course, the generated rtf files won't be valid but it will allow to demonstrate the
		capabilities of the RtfTools classes that operate directly on files.

	 ****************************************************************************************************/

	$sample			=  'sample.rtf' ;
	$bigfile_copies		=  50 ;
	$very_bigfile_copies	=  1000 ;

	$contents		=  file_get_contents ( $sample ) ;

	$fp			=  fopen ( "bigfile.rtf", "w" ) ;

	for  ( $i = 0 ; $i  <  $bigfile_copies ; $i ++ )
		fputs ( $fp, $contents ) ;

	fclose ( $fp ) ;

	$fp			=  fopen ( "verybigfile.rtf", "w" ) ;

	for  ( $i = 0 ; $i  <  $very_bigfile_copies ; $i ++ )
		fputs ( $fp, $contents ) ;

	fclose ( $fp ) ;

