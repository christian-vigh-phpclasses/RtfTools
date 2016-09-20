# RtfMerger #

The **RtfMerger** class allows you to combine the contents of several Rtf files into a single one. It can be used for mass printing or for storing a set of related files into a single archive.

Unlike all the other classes of this package that process Rtf contents, this class does not inherit from **RtfDocument**. 

Merging Rtf files is fairly simple ; first, create a instance of the **RtfMerger** class ; you can supply a list of files to be merged together, or add them later by calling the *Add()* method :

	$merger 	=  new RtfMerger ( 'sample1.rtf', 'sample2.rtf' ) ;
	$merger -> Add ( 'sample3.rtf' ) ;

The above example specified the names of the files to be merged ; but you can also give instances of the **RtfDocument** class, such as in the example below :

	$merger 	=  new RtfMerger ( ) ;
	$merger -> Add ( new RtfFileDocument ( 'sample3.rtf' ) ) ;
	$merger -> Add ( new RtfStringDocument ( 'sample4.rtf' ) ) ;

	$template_variables 	=  [ 'a' => 'this is variable A', 'b' => 'this is variable b' ] ;
	$merger -> Add ( new RtfFileTemplater ( 'sample5.rtf', $template_variables ) ;	

So you can see that you can specify both strings (filenames) and objects inheriting from the **RtfDocument** class ; however, the way strings are handled can be modified. You can tell for example that every string specified either to the class constructor or to the *Add()* method should be considered as pure Rtf contents, instead of being seen as a file name. This can be done by specifying the *RtfMerger::RTFMERGE\_STRINGS\_AS\_DATA* option to the constructor, or by setting the *Options* property :

	$merger 		=  new  RtfMerger ( RtfMerger::RTFMERGE\_STRINGS\_AS\_DATA ) ;

Other version :

	$merger 			=  new RtfMerger ( ) ;
	$merger -> Options 	=  RtfMerger::RTFMERGE\_STRINGS\_AS\_DATA ;

Now, every data you will add as a string will be considered as Rtf data, not as a filename :

	$contents 			=  file_get_contents ( 'sample1.rtf' ) ;
	$merger -> Add ( $contents ) ;

To save merged contents to a file, you can use the *SaveTo()* method :

	$merger -> SaveTo ( 'output.rtf' ) ;

or you can get the merged contents as a string, provided you are sure that everything will fit into memory :

	$contents 	=  $merger -> AsString ( ) ;
	echo $contents ;

# Reference #

The following paragraphs describe the methods and properties available in the **RtfMerger** class.

Basically, you can specify the documents to be merged when invoking the constructor or the *Add()* method. Nothing will happen until you call either the *SaveTo()* or *AsString()* methods.

This means that you can add as many documents as you like before merging them ; this will have a very little impact on the available memory if you are using document objects inheriting from the **RtfFileDocument** class.

To avoid memory exhaustion when you have many big documents to be merged together, the preferred solution will be to use document objects of class **RtfFileDocument** or **RtfFileTemplater** (if you use template).

## Methods ##

### Constructor ###

The constructor has the following signature :

	$merger 	=  new RtfMerger ( [ $doc1, $doc2, ..., $docn ] [, $options ] ) ;

Every *$doc* parameter can be either an object inheriting from the **RtfDocument** class, or the path of an Rtf file, or direct Rtf contents (see the *Add()* method for an explanation).

The *$options* parameter specifies whether the strings specified to the constructor or the *Add()* method should be considered as filenames or Rtf contents (see the *Options* property for further explanations on this parameter).

The order of the parameters has no importance.
 

### $merger -> Add ( $document ) ###

Adds a document to the list of documents to be merged.

The specified document can be either an object inheriting from the **RtfDocument** base class, or a string.

In the latter case, the string will be interpreted differently depending on the bits set in the	*Options* property :

- The string will be interpreted as a file name if the *RTFMERGE\_STRINGS\_AS\_FILENAMES* option is set (this is the default) ; in this case, an object of type **RtfFileDocument** will be created
- The string will be interpreted as Rtf contents if the *RTFMERGE\_STRINGS\_AS\_DATA* option is set. In this case, an object of class **RtfStringDocument** will be created.	

### $merger -> AsString ( ) ###

Returns the merged contents of all the documents that have been added either through the class constructor or the *Add()* method.

### $merger -> SaveTo ( $filename ) ###

Saves the merged contents of all the documents that have been added either through the class constructor or the *Add()* method to the specified filename.

## Properties ##

# Options #

A combination of the following flags :

- *RTFMERGE\_STRINGS\_AS\_FILENAMES* : This option says that whenever a string is specified when adding a document by specifying only a string, it should be considered as a filename which will be used to create an object of type **RTfFileDocument**.
- *RTFMERGE\_STRINGS\_AS\_DATA* : This one says that string should be considered as Rtf data that should be used to create an object of type **RtfStringDocument**.
- *RTFMERGE\_NONE* : Default options.

When nothing is specified, the *RTFMERGE\_STRINGS\_AS\_FILENAMES* flag is the default option.

# Document information properties #

Each individual document to be merged contains its own set of information ; this can be for example the author name, the document title, some comments or keywords to be associated with the document, and so on.

It will not be possible to merge all this information coming from multiple documents to be merged ; this is why the following set of properties can be defined before the final document is generated (if not specified, they will not appear in the merged contents) :

- *Title* : merged document title
- *Subject* : merged document subject
- *Author* : document author
- *Manager*, *Company*, *Operator* : various information that can be specified if you are working in a company environment.
- *Keywords* : an array of keywords to be associated with your merged document.
- *Comment* : put some comments here.
- *Summary* : summary information.
- *Version* : version number (must be an integer number).

Note that none of the above information will be included in the generated merge file if you do not explicitly specify them.
