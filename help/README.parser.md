# RtfParser class #

The **RtfParser** class is an abstract class that allows you to parse Rtf files, using either the **RtfStringParser** or **RtfFileParser** derived classes. The method from this class you will probably use the most is *NextToken()*, which returns you an object derived from the **RtfToken** abstract class, representing the next Rtf token in your Rtf data.

Using the **RtfStringParser** or **RtfFileParser** is pretty straightforward ; instantiate an object providing your Rtf data, then put a *while* loop to retrieve the tokens :

	$parser 	=  new RtfStringParser ( $rtfdata ) ;

	while  ( ( $token = $parser -> NextToken ( ) )  ===  false )
	   {
			switch ( $token -> Type )
			   {
					case 	RtfDocument::TOKEN_CONTROL_WORD :
						// ....
						break ;
			    }
	    } 

The above example works on Rtf data supplied by an in-memory string, but you can also parse files that are too big to fit into memory using the **RtfFileParser** class :

	$parser 	=  new RtfFileParser ( "myfile.rtf" ) ;

The value returned by the *NextToken()* method is an object inheriting from the **RtfToken** abstract class, corresponding to the token that has been read ; see the paragraph below for an explanation on the various token types (and corresponding classes) you can be faced with. 

The **RtfParser** class helps you in reading Rtf data and extracting tokens from it but it is definitely not designed to be an *interpreter* that could render a document or provide you with a level of abstraction like the Document Object Model (DOM) in Javascript. If you need to interpret things from your Rtf data, then you will still have to do the job by yourself and develop a class inheriting from **RtfParser**. 

## The Rtf syntax ##

The Rtf syntax is really simple and can even be easily parsed using routines written in  assembly language. An Rtf file basically includes the following syntactic elements :

- *Control words* : Control words start with a backslash followed by an alphabetic identifier which is case-sensitive, and optionally followed by an integer parameter, which can be negative ;  the control word **\rtf** for example, which must start every Rtf document, has an optional parameter representing the Rtf version for which the document was generated (which will always be "1") :

		{\rtf1...}

A control word can be followed by an optional space which is to be considered as being part of the control word itself.

- *Curly braces* {} : curly braces allow to group items together but also to *push* a context of paragraph/character formatting attributes. The following example will display the string "Hello **beautiful** world" (with the word *beautiful* being bold) :

		{ ... Hello {\b beautiful}  world}

The \b control word tells the Rtf interpreter (maybe Word or WordPad or OpenOffice Writer) that the next data enclosed in this set of curly braces has to be rendered in bold face ; however, the bold attribute reverts back to normal font weight when the next closing brace is encountered.

Also note the double space between the closing brace and "world" ; the first one belongs to the closing brace element and is not to be interpreted as textual data, while the second one is really textual content, ie a space to be put between the words "beautiful" and "world".

Curly braces can be nested.

-  *Control symbols* : they are of several types but share the same characteristics ; they start with a backslash and are followed by a **non-**alphabetic character. Here are basically the three types of control symbols that you will encounter :

	- *Escaped characters* : since all tokens in an Rtf flow are either curly braces or control words/symbols starting with a backslash (apart from character data), you need a way to escape them so that they will not be interpreted as Rtf syntactic elements. This is the right way to do that : \\{, \\} and \\\\.
	- *Special control symbols* : they represent something special, such as \\~ which means "unbreakable space", or \\- which means "optional hyphen"
	- *Character codes* : character codes are introduced by the string \\' followed by two hexadecimal characters. They represent a character code in the current code page, for example : \\'41 (uppercase A).

Note that some control words can be preceded by \\\* (such as : *\\\*\\blipuid*) ; the Rtf specification states that :

*This control symbol identifies destinations whose related text should be ignored if the RTF reader does not recognize the destination control word.* 


Other kind of data can of course appear within Rtf contents ; three categories of data are defined :

- *Character data* : this represents, as is, the textual contents of your Rtf document ; in the above example, the textual data are the strings "hello", "beautiful" and " world". Character data is referred to as **PCDATA** in the Rtf specification.
- *Hexadecimal data* (**SDATA**) : you will encounter hex data in pictures (introduced by the \pict control word) such as in the following example :

		{\pict ... {\*\blipuid 4efdcbebb6e8ae47ae9ef7d9d6e1a135}10009000003c302000002004802000000001400000...}

(the ellipses are provided here as a shortcut to represent the actual Rtf data, which may  really be longer than that).

- *Binary data* (**BDATA**) : binary data is an arbitrary sequence of binary characters that is to be collected as is. It can even include special symbols such as {, } or \\. Binary data is generally introduced by a special control word, whose parameter specifies the number of bytes to be read. This is the case for example of the **\bin** keyword, whose parameter gives the number of bytes representing the binary data ; for example :

		{\bin6 12{}\\6}

represents a binary data of 6 characters : "12{}\\6".

The **RtfParser** class handles all these cases and will provide you with the appropriate token class inheriting from **RtfToken**.


## RtfToken classes ##

The **Rtf\*Token** classes map tokens that are returned by the *NextToken()* method from the **RtfParser** class and provide with the appropriate behavior related to the token type.
 
They all inherit from **RtfToken**, which provides a basic set of properties and methods common to all token types.

Of course, each derived class will provide with its own set of specific properties and methods.

The following paragraphs list the various object types that can be returned by the *NextToken()* method.

### RtfToken class ###

The **RtfToken** class is the base abstract class for all other Rtf token classes ; it offers the following properties :

- *Type* : the token type, set by the derived class and defined in the **RtfDocument** class. It can be one of the following values. Note that each value has a corresponding class defined :

	- *TOKEN\_LBRACE*, *TOKEN\_RBRACE* : An opening or closing curly brace (classes **RtfLeftBraceToken** and **RtfRightBraceToken**)
	- *TOKEN\_CONTROL\_WORD* : A control word, starting with a backslash (class **RtfControlWord**).
	- *TOKEN\_CONTROL\_SYMBOL* : A control symbol, eg \\~, \\-, \\\_, etc. (class **RtfControlSymbol**).
	- *TOKEN\_CHAR* : A character using a 1-byte hex representation, such as \\'41 (uppercase A) (class **RtfEscapedCharacterToken**).
	- *TOKEN\_ESCAPED\_CHAR* : An escaped character, that would be otherwise interpreted as Rtf syntactic element : \\\\, \\{ and \\} (class **RtfEscapedExpressionToken**).
	- *TOKEN\_PCDATA* : Character data (class **RtfPCDataToken**).
	- *TOKEN\_SDATA* : Hexadecimal data (class **RtfSDataToken**).
	- *TOKEN\_BDATA* : Binary data (class **RtfBDataToken**).
	- *TOKEN\_NEWLINE* : End of line, either crlf or newline (class **RtfNewlineToken**).
- *Text* : the token text
- *SpaceAfter* : *true* if a space belonging to the token appears right after it.
- *Offset* : Byte offset, in the supplied Rtf contents, of the token start.
- *Line* : Line where the token was encountered in the supplied Rtf contents.
- *Column* : Column where the token was encountered in the supplied Rtf contents.


The following methods are available :

- *ToRtf()* : Returns the token as is, without interpretation
- *ToText()* : Returns the token text, with possible interpretation. 	This method can be overridden by derived classes to return a text value representing the real token text, not its Rtf representation. For example, the *ToText()* method of the **RtfEscapedExpressionToken** class will return the escaped character (eg, it will return "{" instead of "\\{").
- *\_\_tostring()* : Alias for *ToRtf()*.

### RtfLeftBraceToken and RtfRightBraceToken classes ###

Implements an opening or closing brace in the Rtf flow.

This class does not provide additional properties or methods to the **RtfToken** class.

### RtfNewlineToken class ###

Implements an end of line found in the Rtf stream. This class is provided only for parsers that need to handle line-changing situations.

It does not provide additional properties or methods to the **RtfToken** class.


### RtfControlSymbolToken class ###

Implements a control symbol such as \\~, \\- or \\_.

The *ToText()* method will return a space for \\~ and an hyphen for \\- and \\_. For all other symbols, it will return the character as is.

### RtfControlWordToken class ###

Implements a control word. The following properties are available :

- *ControlWord* : the control word itself, without the leading backslash
- *Parameter* : control word parameter.
- *Special* : true if the control word is preceded by the special control symbol \\\*.

### RtfEscapedExpressionToken class ###

Implements an escaped special character (\\\\, \{ or \}).

The *ToText()* method returns the escaped character itself, without the leading backslash.

### RtfEscapedCharacterToken class ###

Implements a character specified through its code in the current codepage, in the form : \\'xy.

The following properties are available :

- *Char* : Character code
- *Ord* : Character ordinal value.

For example, with the character specification \'41, *Char* will be equal to "A", and *Ord* to integer 65.

The *ToText()* method returns the escaped character itself, without the leading backslash.

### RtfPCDataToken class ###

Implements free-form text data.

The *ToText()* method returns the textual data without any line break. This is required since some Rtf generators can arbitrarily break the text onto multiple lines. In such cases, line braks in the Rtf flow are meaningless.

### RtfSData class ###

Implements a hexadecimal data string, such as those that can be found in \\pict constructs.

### RtfBData class ###

Implements a binary data string.

## RtfParser class reference ##

### Properties ###

The following properties are available :

- *CurrentPosition* : current offset in the Rtf contents
- *CurrentLine* : current line
- *CurrentColumn* : current column position in the current line
- *NestingLevel* : Current brace nesting level. Starts at zero.

### Methods ###

#### GetControlWordValue ( $word, $default = '' ) ####

The current parameter value of control words that have been tracked using the *TrackControlWord()* method can be retrieved using this method.

The best example I can give for explaining the utility of this method comes from the **RtfTexter** class, and is regarding Unicode characters, which are specified by the \u tag like in the following example :

		\u10356

However, Unicode characters are followed by character symbols (using the "\'" tag) which gives the number of the code page that best matches the preceding Unicode character :

		\u10356\'a1\'b0

The number of character symbols that follow a Unicode character specification is given by the \uc tag ; in the above example, it should be written like this :

		\uc2 \u10356\'a1\'b0

However, the specification states that this number (the parameter of the \uc2 tag) should be tracked and	that a stack of applicable values should be handled, to keep applicable values depending on the current curly brace nesting level (the \uc tag may be present elsewhere in the document, not specifically before Unicode character specifications, and its default value should be 1).

In this case, *GetControlWordValue ( "uc" )* will return the parameter of the *\uc* control word that is applicable for the current nesting level.

Note that the *TrackControlWord()* method must be called to track the control word "uc" before any parsing occurs for this method to work.

If no value is applicable for the current nesting level then the one supplied by the *$default* parameter will be returned.

#### IgnoreCompounds ( $list ) ####

Ignore "compound" control words that are given in the array specified by the *$list* parameter.

Although not explicitly stated in the Rtf specification, some control words, such as \pict, need to be specified in a group enclosed within curly braces, and accept PCDATA or SDATA.

Depending on your parsing needs, you may not be interested to retrieve the contents of control words such as \stylesheet or \fonttbl (this is the case for example of the **RtfTexter** class, which ignores several compound words that have no sense in the context of its activity).

In this case, simply call this method before the first call to *NextToken()*, to make it ignore the specified words ; for example :

	$parser -> IgnoreCompounds ( [ 'stylesheet', 'fonttbl' ] ) ;  

#### NextToken ( ) ####

Returns the next token available in the underlying Rtf stream in the form of an object deriving from the **RtfToken** abstract class.

Note that the method will silently ignore all control words that may have been specified to the *IgnoreCompounds()* method.

#### Reset ( ) ####

Resets the parser and puts it in a state where the *NextToken()* method can be called again to start parsing at the beginning of the Rtf flow.


#### SkipCompound ( ) ####

Initially meant to skip compound control words, this method actually processes incoming characters until the current nesting level is closed by a right curly brace (}).


#### TrackControlWord ( $word, $stackable, $default_value = false ) ####

Tracks a control word specification in the current Rtf document. This allows for example to associate raw data with a control word, such as for the "\pict" tags.

The parameters are the following :

- *$word (string)* : Control word to be tracked.
- *$stackable (boolean)* : true when the control word have a parameter that needs to be stacked according to the current brace nesting level. A control word such as \uc is stackable (different parameter values can be specified at different nesting levels), while \pict is non-stackable.
- *$default_value (string)* : initial default value for the tracked control word.

  