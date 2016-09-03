# RtfBeautifier class #

The **RtfBeautifier** class is an abstract class that allows you to pretty-print Rtf files, using either the **RtfStringBeautifier** or **RtfFileBeautifier** classes.

But why pretty-printing Rtf contents ? 

Suppose you have to compare two Rtf files, who should have similar contents. You can do that using utilities such as the Unix *diff* command, or the Windows *windiff* command (available here : [http://www.grigsoft.com/windiff.zip](http://www.grigsoft.com/windiff.zip "http://www.grigsoft.com/windiff.zip")).

However, you will have to perform a difference checking on lines that include several Rtf control words. This may not be comfortable, since several dozens of control words or text data can be put on the same line, which can count thousands of characters.

The *RtfBeautifier* class ensures that every syntactic Rtf element is printed on a single line.
Rtf syntactic elements are not so numerous ; it can be :

- An opening or closing brace
- A control word that begins with a slash (such as "*\\par*", "*\\pard*", but also a character specification such as "*\\'ae*", or even an escape sequence such as "*\\{*")
- Any text that constitutes the contents of your document

Picture or binary data can be omitted in the output. You can also set the indentation space required.

Note that the output will not be valid Rtf data ; it's goal is definitely to easily enable you to compare two Rtf files.

## Example ##

Pretty-printing an Rtf file is very simple ; you can use either the **Beautify** or **BeautifyTo** methods. The **Beautify** method can be used if you're sure that your Rtf file contents fits into memory, even if you're using the *file* version of the class :

	$pp 	=  new RtfFileBeautifier ( "sample.rtf" ) ;
	$text 	=  $pp -> Beautify ( ) ;
	echo $text ;

but you can also use the **BeautifyTo** method to write pretty-printed contents to an output file, whathever the class you are using, *string* or *file* :

	$pp 	=  new RtfStringBeautifier ( "sample.rtf" ) ;
	$pp -> BeautifyTo ( 'sample.txt' ) ;

## Reference ##

The following section describe the properties and methods available in the *RtfBeautifier* classes.

### Constructor ###

An Rtf beautifier object can be instantiated with the following instructions :

	$pp 	=  new RtfStringBeautifier ( $rtfdata, $options, $indentation_size ) ;

or :

	$pp 	=  new RtfFileBeautifier ( $file, $options, $indentation_size ) ;

The parameters are the following :

- *$rtfdata* : Rtf contents to be pretty-printed
- *$file* : File whose Rtf contents are to be pretty-printed.
- *options* : A combination of the following flags :
	- **BEAUTIFY\_GROUP\_SPECIAL\_WORDS** : When a \\\*\\word construct is encountered, keeps them together instead of putting them on a separate line. This works only if the *BEAUTIFY\_SPLIT\_ADJACENT\_WORDS* flag is set.
	- **BEAUTIFY\_SPLIT\_ADJACENT\_WORDS** : 	When several control words are catenated, such as in :
	    			
	    	\word1\word2\word3

	indicates the beautifier to split them, one per line, instead of keeping them on	the same line.
	    			
	- **BEAUTIFY\_SPLIT\_CHARS** : Indicates whether character code control words (of the form \'xy) should be put on a separate line or not. For example, "En-tête" is encoded as "En-t\'eate" and the encoded version will be output as is if this flag is not specified. When specified, it will be output as :
	    			
	    				En-t
	    				\'ea
	    				te
	    			
	- **BEAUTIFY\_STRIP\_IMAGE\_DATA** : For large files containing many images (*\pict* control word), it could be of interest not to include image data to save space and processing time. In this case, image data will be replaced with a comment indicating how many bytes were present.
	    			
	- **BEAUTIFY\_STRIP\_BIN\_DATA** : Same, for *\bin* control words.
	    			
	- **BEAUTIFY\_STRIP\_DATA** : Enables the *BEAUTIFY\_STRIP\_IMAGE\_DATA* and *BEAUTIFY\_STRIP_BIN\_DATA* flags.
	    			
	- **BEAUTIFY\_ALL** : Enables all flags.

- *$indentation\_size* : Specifies how many spaces to insert for each indentation level. The default is 4.

### AsString ###

Pretty-prints Rtf contents and returns them as a string :

	$pp 	=  new RtfStringBeautifier ( $rtfdata, $options, $indentation_size ) ;
	$text 	=  $pp -> AsString ( ) ;

or : 

	$pp 	=  new RtfFileBeautifier ( $file, $options, $indentation_size ) ;
	$text 	=  $pp -> AsString ( ) ;


### SaveTo ###

Pretty-prints Rtf contents and saves them to a file :

	$pp 	=  new RtfStringBeautifier ( $rtfdata, $options, $indentation_size ) ;
	$pp -> SaveTo ( 'sample.txt' ) ;

or : 

	$pp 	=  new RtfFileBeautifier ( $file, $options, $indentation_size ) ;
	$pp -> SaveTo ( 'sample.txt' ) ;


