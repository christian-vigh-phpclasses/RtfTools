# RtfTexter #

The **RtfTexter** abstract class allows you to extract text contents from an Rtf file, using one of the **RtfStringTexter** or **RtfFileTexter** derived classes.

It has been designed to be of simple use ; instantiate an object, then use either the *AsText()* or *SaveTo()* methods to retrieve the text contents from an Rtf file or save them to an output file, respectively.

Here is the version using Rtf contents available in a string :

		$contents 	=  file_get_contents ( 'myfile.rtf' ) ;
		$texter 	=  new RtfStringTexter ( $contents ) ;
		echo $texter -> AsText ( ) ;

And here is the file-based version :

		$texter 	=  new RtfFileTexter ( 'myfile.rtf' ) ;
		echo $texter -> AsText ( ) ;

# Reference # 

The following paragraphs describe the methods and properties available in the **RtfTexter** classes.

## Methods ##

### Constructor ###

The constructor of the **RtfStringTexter** class has the following signature :

		$texter		=  new RtfStringTexter ( $rtf_contents, $options = self::TEXTEROPT_ALL, $page_width = 80 ) ;

while the **RtfFileTexter** version is :

		$texter		=  new RtfFileTexter ( $filename, $options = self::TEXTEROPT_ALL, $page_width = 80 ) ;

The meaning of the parameters is the following :

- *rtf_contents* (string) : Rtf contents whose text parts are to be extracted.
- *filename* (string) : name of a file contaning Rtf data whose text contents are to be extracted.
- *options* (integer) : a combination of the following text-extraction options :
	- TEXTEROPT\_INCLUDE\_PAGE\_HEADERS : include page headers in the output (see Notes).

	- TEXTEROPT\_INCLUDE\_PAGE\_FOOTERS : include page footers in the output.

	- TEXTEROPT\_INCLUDE\_PAGE\_TITLES : A synonym for :
 
			TEXTEROPT_INCLUDE_PAGE_HEADERS | TEXTEROPT_INCLUDE_PAGE_FOOTERS

	- TEXTEROPT\_USE\_FORM\_FEEDS :	use form feeds to seperate pages. Works only for new sections or new pages (\\setcd and \\page Rtf tags).

	- TEXTEROPT\_WRAP\_TEXT : normally, all the text is written on a single line, until a new paragraph, page or section is started. This option ensures some basic text wrapping over several lines, making sure each line does not exceed *$page_width* columns (or the value specified by the *$PageWidth* property).

	- TEXTEROPT\_EOL\_STYLE\_DEFAULT, TEXTEROPT\_EOL\_STYLE\_WINDOWS, TEXTEROPT\_EOL\_STYLE\_UNIX : specifies the end of line characters to be used for each end of line. The default one is given by the *PHP_EOL* constant.

	- TEXTEROPT\_ALL : enables all of the above options.

- *page_width* (integer) : Indicates the maximum number of columns to be used when reformatting text (if the TEXTEROPT\_WRAP\_TEXT option has been specified).
 
*Notes regarding page headers and footers :*

Since the **RtfTexter** class does not try to evaluate the current vertical position in a page,  page headers and footers will only appear once per section, unless a *\\page* tag is encountered.

### AsText ( ) ###

The *AsText()* method returns text contents extracted from the underlying Rtf data.


### SaveTo ( $filename ) ###

Extracts text contents from the underlying Rtf data and saves them to the specified filename.

## Properties ##

### Eol ###

Returns the string used for end of lines when generating extracted text contents.

### Options ###

Gets/sets the text extraction options (see the *$options* parameter of the class constructor).


### PageWidth ###

Gets/sets the maximum number of columns to be used when the TEXTEROPT\_WRAP\_TEXT option has been specified.

