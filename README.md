# INTRODUCTION #

This package provides several classes to handle Rtf data. It has been designed to be able to handle files whose contents are too big to fit into memory. This is why you will see a dichotomy among classes :

- Classes whose name starts with *RtfString* handle in-memory Rtf contents.
- Classes whose name starts with *RtfFile* handle file-based Rtf contents.

It is up to you to decide whether you will have to handle big files. If you are sure that your Rtf contents will always fit into memory, use the *RtfString* classes. If you are sure that your files *may* be bigger than the available memory, use the *RtfFile* classes. This will add some overhead due to file IO (this can more than double the execution time if you have low performance IO subsystem, but I noticed some systems where the difference between the in-memory and file versions are only a few tenths of milliseconds).

This package currently implements the following classes :

- *RtfStringBeautifier* and *RtfFileBeautifier* : pretty-prints Rtf file contents so that you will be able to compare two Rtf files using utilities such as *diff* or *windiff*. You will find some help here : [README.beautifier.md](README.beautifier.md "README.beautifier.md").
- *RtfStringParser* and *RtfFileParser* : a generic parser for Rtf contents. It provides a set of *Rtf\*Token* classes that map to underlying Rtf token types, along with a minimal intelligence that allows you to track certain control word values depending on the current nesting level, as well as handling picture or binary data contents ([README.parser.md](README.parser.md "README.parser.md")).
- *RtfStringTexter* and *RtfFileTexter* : a class that extracts raw text from Rtf contents, with some basic formatting capabilities ([README.texter.md](README.texter.md "README.texter.md")). 

 

More to come :

- *RtfMerger*, a class that allows you to merge various Rtf files into a single Rtf document (should be available by july 2016).
- *RtfTemplater*, a class that allows you to preprocess Rtf contents that reference variables, have loops and conditional constructs (should be available by june 2016).


# PACKAGING #

The class sources of this package do not belong to any namespace. This is intentional, so that you will be able to add the one of your own if you want to integrate them into some workspace having its own class autoloader.

All the classes throw an exception when an error is encountered. If you have your own error handling mechanism, then you might be interested into substituting exception throwings with it. For that, a reliable method would be to search for the keyword *throw* over all files and replace every occurrence with your error handling routine. You can also use *try/catch* blocks whenever you use the Rtf classes of this package.


# DEPENDENCIES #

All the classes in this package rely on the **SearchableFile** class ([http://www.phpclasses.org/package/9697-PHP-Process-text-files-too-big-to-fit-into-memory.html](http://www.phpclasses.org/package/9697-PHP-Process-text-files-too-big-to-fit-into-memory.html "http://www.phpclasses.org/package/9697-PHP-Process-text-files-too-big-to-fit-into-memory.html")) that allows to search for contents in files too big to fit into memory. A copy of this class is present in this package for your convenience but note that it may not be the latest release.

All the main class files in this package ([RtfBeautifier.phpclass](RtfBeautifier.phpclass "RtfBeautifier.phpclass"), [RtfParser.phpclass](RtfParser.phpclass "RtfParser.phpclass")
 and [RtfTexter.phpclass](RtfTexter.phpclass "RtfTexter.phpclass")) also inherit from the **RtfDocument** class ([RtfDocument.phpclass](RtfDocument.phpclass "RtfDocument.phpclass")).

To use the **RtfBeautifier** class, you will need the following includes :

	require ( 'SearchableFile.phpclass' ) ;
	require ( 'RtfDocument.phpclass' ) ;
	require ( 'RtfBeautifier.phpclass' ) ;

Using the **RtfParser** class requires an additional include, *RtfToken.phpclass* so you will need the following includes :

	require ( 'SearchableFile.phpclass' ) ;
	require ( 'RtfDocument.phpclass' ) ;
	require ( 'RtfToken.phpclass' ) ;
	require ( 'RtfParser.phpclass' ) ;

Finally, the **RtfTexter** class inherits from **RtfParser**, so you will need the following includes in this case :

	require ( 'SearchableFile.phpclass' ) ;
	require ( 'RtfDocument.phpclass' ) ;
	require ( 'RtfToken.phpclass' ) ;
	require ( 'RtfParser.phpclass' ) ;
	require ( 'RtfTexter.phpclass' ) ;


# REFERENCES #

This package depends on the following package, **SearchableFile**, which allows you to search text data from files too big to fit into memory :

	[http://www.phpclasses.org/package/9697-PHP-Process-text-files-too-big-to-fit-into-memory.html](http://www.phpclasses.org/package/9697-PHP-Process-text-files-too-big-to-fit-into-memory.html "http://www.phpclasses.org/package/9697-PHP-Process-text-files-too-big-to-fit-into-memory.html")

For convenience reasons, the *SearchableFile.phpclass* file has been included here, but note that this may not be the latest version.

The latest Microsoft Rtf format specifications can be downloaded here :

	[https://www.microsoft.com/en-us/download/details.aspx?id=10725](https://www.microsoft.com/en-us/download/details.aspx?id=10725 "https://www.microsoft.com/en-us/download/details.aspx?id=10725")

But you can also consult the excellent book *"Rtf pocket guide"* from Sean M. Burke :
 
	[https://books.google.fr/books/about/RTF_Pocket_Guide.html?id=4N_lVcyyhqMC&redir_esc=y](https://books.google.fr/books/about/RTF_Pocket_Guide.html?id=4N_lVcyyhqMC&redir_esc=y "https://books.google.fr/books/about/RTF_Pocket_Guide.html?id=4N_lVcyyhqMC&redir_esc=y")

or visit his page :

	[http://interglacial.com/~sburke/](http://interglacial.com/~sburke/ "http://interglacial.com/~sburke/")


