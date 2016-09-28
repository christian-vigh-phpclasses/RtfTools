# RtfTemplater class #

The **RtfTemplater** class is an abstract class that allows you to preprocess Rtf template files, using either the **RtfStringTemplater** or **RtfFileTemplater** derived classes.

It includes a small macro language that you can use to generate customized output Rtf files.

# Example #

The following example instantiates an **RtfFileTemplater** object, passing it the name of a template Rtf file (*template.rtf*), then saves the preprocessed contents to output file *sample.rtf*. Note that a set of variables is also included in the templating process, provided by the *$variables* array :

	include ( 'path/to/RtfTemplater.phpclass' ) ;

	$variables	=  
	   [
		'VNAME1'	=>  'the value of vname1',
		'VNAME2'	=>  'the value of vname2',
		'INDEX'		=>  17,
		'ARRAY'		=>  [ 'string a', 'string b', 'string c' ]
	    ] ;

	 $templater	=  new RtfFileTemplater ( 'template.rtf', $variables ) ;
	 $templater -> SaveTo ( 'sample.rtf' ) ; 

The above example will be used throughout the Templating language reference guide.

# Example Rtf file #

A sample Rtf file (*template.rtf*) will also be used to demonstrate the capabilities of the **RtfTemplater** class and its macro language ; if you open it using some editor such as Microsoft Word, you will see the following contents :


----------

Sample.rtf

%$VNAME1%

Some text after VNAME1, then VNAME2 with spurious RTF tags interspersed :

**%$VN**AM**E2** . “ catenated with coucou”%

A hardcoded percentage result : 12,5%

Some text

A second hardcoded percentage result : 12,5%% (2) this example shows double percent signs


An undefined variable : %$TOTO%

Current date/time : %( date ( ‘Y/m/d H:i:s’ ) )%

%IF( $VNAME1 == ‘1 )%Text for VNAME1 = 1%
ELSEIF ($VNAME1 == “2” )%Text for VNAME1 = 2%
ELSEIF ($INDEX ==  16 )%INDEX is equal to 16%
ELSEIF ($INDEX ==  17)%Index is equal to 17%
ELSE%VNAME1 is neither equal to 1 nor to 2 (%$VNAME1%)%END%


%REPEAT ( $index = 10 )%Repeated line #%$index%
%END%

%FOR ( $i = 1 TO 10 )%FOR Line #%$i%
%END%

%FOREACH ($var IN $ARRAY)%CONTENTS WITH FOREACH : %$var%
%END%

----------

# Templating language reference #

The templating pseudo-language implements a few simple control structures. All expressions can
reference variables that have been passed to the constructor of the **RtfStringTemplater** or
**RtfFileTemplater** class constructor :

		$variables	=
		   [
			'VNAME1'	=>  'the value of vname1',
			'VNAME2'	=>  'the value of vname2',
			'INDEX'		=>  17,
			'ARRAY'		=>  [ 'string a', 'string b', 'string c' ]
		    ] ;
		$document	=  new  RtfStringTemplater ( $contents, $variables ) ;

Array keys are simply variable names, which are case-sensitive, while values represent variable	values.

Note that in the above example, one of the variables, 'ARRAY', is not scalar ; such an array variable can be used in **FOREACH** constructs.

Templating allows you to generate an output file based on a template, which will use the variables you specified to the class constructor.

## Language elements ##

The following section describes the various macro-language constructs that can be used in a Rtf template.

### Expressions ###

Expressions can reference variables passed to the class constructor, but they can also use any operators or functions provided by PHP. Expressions are replaced with their evaluation result in the output contents. As for PHP, variable names must be prefixed by the "$" sign ; for example (using our example $variables array in the above example) :

	%$VNAME%

will be substituted with :

	the value of vname1

Also :

	%( 2 + $INDEX )%

will be substituted with :

	19

Note that some compromises have to be done ; the above expression for example, has been enclosed in parentheses, otherwise it would have been recognized as pure text ("2 + $INDEX"). This is due to the fact that the delimiter has been fixed to be the percent sign, and that the class allows you, for flexibility reasons, to specify a percent sign in your template, such as in :

	Interest rate : 2,5%

Undefined variables will be expanded to an empty string and a warning will be issued, unless the *$warnings* parameter of the class constructor has been set to false.

### IF constructs ###
IF constructs can be specified with conditions that use the same elements as expressions ; for example :

	%IF ( $INDEX  ==  17)%Index = 17 !!!%END%

will be substituted with the string "Index = 17!!!" if the $INDEX variable passed in the $variables
array to the constructor is equal to 17.

An IF construct can have as many ELSEIF statements as needed and an optional ELSE statement :

	%IF ( $INDEX  == 19 )%
		index = 19
	%ELSEIF ( $INDEX == 18 )%
		index = 18
	%ELSE%
		index is neither 19 nor 18.
	%END%

will be substituted in the output with :

	index is neither 19 nor 18.

Well, in fact you will see two empty lines in the output result, because paragraph marks have been
put in the template RTF contents after the IF and ELSEIF constructs. If you would like no line break
to be inserted, then you should rewrite you expression this way :

	%IF ( $INDEX  == 19 )
		%index = 19
	%ELSEIF ( $INDEX == 18 )
		%index = 18
	%ELSE
		%index is neither 19 nor 18.
	%END%

Paragraph marks (line breaks) between the enclosing percent signs of an instruction are ignored.

### FOR loops ###

FOR loops are a way to repeat text a certain number of times. Specify a start and end index :

	%FOR ( $i = 1 TO $INDEX )
		%This is line #$i
	%END%

will output "This is line #1" through "This is line 16".
You can also specify an optional step :

	%FOR ( $i = 1 TO $INDEX BY 2 )%

or :

	%FOR ( $i = 1 TO $INDEX STEP 2 )%

which will output "This is line #1", then "This is line #3", "This is line #5", etc.

### REPEAT loops ###
Repeat loops are simply a notational shortcut :

	%REPEAT ( $i = $INDEX )%

is equivalent to :

	%FOR ( $i = 1 TO $INDEX )%

### FOREACH loops ###
FOREACH loops are based on array variables (look at the 'ARRAY' entry of the $variables 
array in the example above).

The following instruction will display the text "string a", "string b", "string c" on
separate lines :

	%FOREACH ( $value IN $ARRAY )%$value
	%END%

## Predefined variables ##

The following variables are predefined and can be referenced anywhere :

- *$FILENAME* : Name of the input template file. Expands to the empty string for the RtfStringTemplater class.


## Coping with percent signs #

The templater class does its best in distinguishing control statements from pure text. It will for example correctly handle the following case :

	Tax rate is : 20%
	some other text
	%$VNAME%

  which will expand to :

	Tax rate is : 20%
	some other text
	the value of vname1

However, if you follow "20%" with a sign that is recognized as the start of an expression, such as an opening parenthesis :

	Tax rate is : 20% (since 2016)
	some other text
	%$VNAME%

then it will try to interpret the string "% (since 2016) some other text%" as an expression and will issue a warning.

To avoid such situations, simply double the percent sign, as in the following :

	Tax rate is : 20%% (since 2016)

## Under the hood ##

Imagine that your user references the following variable in his template :

	%$VNAME2%

This will give the following RTF code :

	{ some rtf tags... %VNAME2% }

but put in boldface the "%V" and "2%" portion of the variable reference ; you will now have to deal with the following Rtf code :

	{\rtlch\fcs1 \af0 \ltrch\fcs0 
	\b\lang2057\langfe1036\langnp2057\insrsid15075231\charrsid15075231 VN}{\rtlch\fcs1 \af0 \ltrch\fcs0 
	\lang2057\langfe1036\langnp2057\insrsid15075231 AM}
	{\rtlch\fcs1 \af0 \ltrch\fcs0 \b\lang2057\langfe1036\langnp2057\insrsid15075231\charrsid15075231 E2}

The code that includes the percent sign has been omitted here ; but note the start of the *VNAME2* variable on line 2 ("VN"), the middle on line 3 ("AM") and the remaining on line 4 ("E2").

The **RtfTemplater** class correctly handles such crazy cases, by extracting the Rtf tags from the whole contents and reconstituting the original text ("%VNAME2%").

## Reference ##

The following section describe the properties and methods available in the *RtfTemplater* classes.

### Constructor ###

An Rtf templater object can be instantiated with one of the following instructions :

	$pp 	=  new RtfStringTemplater ( $rtfdata, $variables, $warnings ) ;

or :

	$pp 	=  new RtfFileTemplater ( $file, $variables, $warnings ) ;

The parameters are the following :

- *$rtfdata* : Rtf template contents
- *$file* : Rtf template file
- *$variables* : An associative array defining the variables that can be used in the template. Keys are variable names, and values variable values.
- *$warnings* : A boolean value specifying whether warning should be issued in cases such as referencing an undefined variable (ie, a variable not contained in the *$variables* array) or when an expression in an IF or FOR loop is syntactically incorrect.

### AsString ###

Returns the preprocessed contents of a template file as a string :

	$pp 	=  new RtfStringTemplater ( $rtfdata, $variables ) ;
	$text 	=  $pp -> AsString ( ) ;

or : 

	$pp 	=  new RtfFileTemplater ( $file, $variables ) ;
	$text 	=  $pp -> AsString ( ) ;


### SaveTo ###

Preprocesses the contents of an Rtf template and write them to an output file :

	$pp 	=  new RtfStringTemplater ( $rtfdata, $variables ) ;
	$pp -> SaveTo ( 'sample.rtf' ) ;

or : 

	$pp 	=  new RtfFileTemplater ( $file, $variables ) ;
	$pp -> SaveTo ( 'sample.rtf' ) ;


