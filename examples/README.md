# HOW TO RUN THE EXAMPLES #

This directory contains a script, *create\_samples.php*, and a sample RTF file, *sample\_file.php*.

Running the *create\_samples.php* PHP script will generate two files by putting the contents of *sample\_file.php*  

- *bigfile.rtf*, which will be around 40Mb.
- *verybigfile.txt*, which will be around 800Mb.

The first file is used to compare the relative performance of string-based vs file-based versions of the Rtf classes.

The second one is used to demonstrate the capabilities of the file-based versions of the Rtf classes to handle files that do not fit into memory.

All the example scripts in this directory need the files *bigfile.rtf* and *verybigfile.rtf* files, so you **have to** run the *create\_samples.php* script first (you need it to do it only once).

# Sample file #

The sample file, used by the by the *create\_sample.php* script described above, contains the first two pages of the latest Rtf format specification from Microsoft, which you can download here :

	[https://www.microsoft.com/en-us/download/details.aspx?id=10725](https://www.microsoft.com/en-us/download/details.aspx?id=10725 "https://www.microsoft.com/en-us/download/details.aspx?id=10725")

# Example script : beautify.php #

This script generates 3 files :

- *bigfile.string.txt*, the beautified contents of bigfile.rtf using the *RtfStringBeautifier* class
- *bigfile.file.txt*, the beautified contents of bigfile.rtf using the *RtfFileBeautifier* class
- verybigfile.txt, the beautified contents of verybigfile.rtf using the *RtfFileBeautifier* class (the *RtfStringBeautifier* class won't be used on this file since it's too large to fit into memory)

The contents of *bigfile.string.txt* and *bigfile.file.txt* must be the same.

Don't be surprised if the contents of the beautified files are shorter than their original version : this is because we use here the default beautifying options, which include the **BEAUTIFY\_STRIP\_IMAGE_DATA** ; therefore, image contents are stripped from the output and replaced with a comment saying : "/* x bytes of image data not shown */".  