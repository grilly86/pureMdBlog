PHP Markdown Extra
==================

Version 1.2.3 - Wed 31 Dec 2008

by Michel Fortin
<http://www.michelf.com/>

Additional features and fixes by Henrik Paul
<http://github.com/wolfie/php-markdown/tree/extra>

based on Markdown by John Gruber  
<http://daringfireball.net/>


Introduction
------------

This is a special version of PHP Markdown with extra features. See
<http://www.michelf.com/projects/php-markdown/extra/> for details.

Markdown is a text-to-HTML conversion tool for web writers. Markdown
allows you to write using an easy-to-read, easy-to-write plain text
format, then convert it to structurally valid XHTML (or HTML).

"Markdown" is two things: a plain text markup syntax, and a software 
tool, written in Perl, that converts the plain text markup to HTML. 
PHP Markdown is a port to PHP of the original Markdown program by 
John Gruber.

PHP Markdown can work as a plug-in for WordPress and bBlog, as a 
modifier for the Smarty templating engine, or as a remplacement for
textile formatting in any software that support textile.

Full documentation of Markdown's syntax is available on John's 
Markdown page: <http://daringfireball.net/projects/markdown/>


Installation and Requirement
----------------------------

PHP Markdown requires PHP version 4.0.5 or later.


### WordPress ###

PHP Markdown works with [WordPress][wp], version 1.2 or later.

 [wp]: http://wordpress.org/

1.  To use PHP Markdown with WordPress, place the "makrdown.php" file 
    in the "plugins" folder. This folder is located inside 
    "wp-content" at the root of your site:


        (site home)/wp-content/plugins/

2.  Activate the plugin with the administrative interface of 
    WordPress. In the "Plugins" section you will now find Markdown. 
    To activate the plugin, click on the "Activate" button on the 
    same line than Markdown. Your entries will now be formatted by 
    PHP Markdown.

3.  To post Markdown content, you'll first have to disable the 
	"visual" editor in the User section of WordPress.

You can configure PHP Markdown to not apply to the comments on your 
WordPress weblog. See the "Configuration" section below.

It is not possible at this time to apply a different set of 
filters to different entries. All your entries will be formated by 
PHP Markdown. This is a limitation of WordPress. If your old entries 
are written in HTML (as opposed to another formatting syntax, like 
Textile), they'll probably stay fine after installing Markdown.


### bBlog ###

PHP Markdown also works with [bBlog][bb].

 [bb]: http://www.bblog.com/

To use PHP Markdown with bBlog, rename "markdown.php" to 
"modifier.markdown.php" and place the file in the "bBlog_plugins" 
folder. This folder is located inside the "bblog" directory of 
your site, like this:

    (site home)/bblog/bBlog_plugins/modifier.markdown.php

Select "Markdown" as the "Entry Modifier" when you post a new 
entry. This setting will only apply to the entry you are editing.


### Replacing Textile in TextPattern ###

[TextPattern][tp] use [Textile][tx] to format your text. You can 
replace Textile by Markdown in TextPattern without having to change
any code by using the *Texitle Compatibility Mode*. This may work 
with other software that expect Textile too.

 [tx]: http://www.textism.com/tools/textile/
 [tp]: http://www.textpattern.com/

1.  Rename the "markdown.php" file to "classTextile.php". This will
	make PHP Markdown behave as if it was the actual Textile parser.

2.  Replace the "classTextile.php" file TextPattern installed in your
	web directory. It can be found in the "lib" directory:

		(site home)/textpattern/lib/

Contrary to Textile, Markdown does not convert quotes to curly ones 
and does not convert multiple hyphens (`--` and `---`) into en- and 
em-dashes. If you use PHP Markdown in Textile Compatibility Mode, you 
can solve this problem by installing the "smartypants.php" file from 
[PHP SmartyPants][psp] beside the "classTextile.php" file. The Textile 
Compatibility Mode function will use SmartyPants automatically without 
further modification.

 [psp]: http://www.michelf.com/projects/php-smartypants/


### In Your Own Programs ###

You can use PHP Markdown easily in your current PHP program. Simply 
include the file and then call the Markdown function on the text you 
want to convert:

    include_once "markdown.php";
    $my_html = Markdown($my_text);

If you wish to use PHP Markdown with another text filter function 
built to parse HTML, you should filter the text *after* the Markdown
function call. This is an example with [PHP SmartyPants][psp]:

    $my_html = SmartyPants(Markdown($my_text));


### With Smarty ###

If your program use the [Smarty][sm] template engine, PHP Markdown 
can now be used as a modifier for your templates. Rename "markdown.php" 
to "modifier.markdown.php" and put it in your smarty plugins folder.

  [sm]: http://smarty.php.net/

If you are using MovableType 3.1 or later, the Smarty plugin folder is 
located at `(MT CGI root)/php/extlib/smarty/plugins`. This will allow 
Markdown to work on dynamic pages.


### Updating Markdown in Other Programs ###

Many web applications now ship with PHP Markdown, or have plugins to 
perform the conversion to HTML. You can update PHP Markdown -- or 
replace it with PHP Markdown Extra -- in many of these programs by 
swapping the old "markdown.php" file for the new one.

Here is a short non-exhaustive list of some programs and where they 
hide the "markdown.php" file.

| Program   | Path to Markdown
| -------   | ----------------
| [Pivot][] | `(site home)/pivot/includes/markdown/`

If you're unsure if you can do this with your application, ask the 
developer, or wait for the developer to update his application or 
plugin with the new version of PHP Markdown.

 [Pivot]: http://pivotlog.net/


Configuration
-------------

By default, PHP Markdown produces XHTML output for tags with empty 
elements. E.g.:

    <br />

Markdown can be configured to produce HTML-style tags; e.g.:

    <br>

To do this, you  must edit the "MARKDOWN_EMPTY_ELEMENT_SUFFIX" 
definition below the "Global default settings" header at the start of 
the "markdown.php" file.


### WordPress-Specific Settings ###

By default, the Markdown plugin applies to both posts and comments on 
your WordPress weblog. To deactivate one or the other, edit the 
`MARKDOWN_WP_POSTS` or `MARKDOWN_WP_COMMENTS` definitions under the 
"WordPress settings" header at the start of the "markdown.php" file.


Bugs
----

To file bug reports please send email to:
<michel.fortin@michelf.com>

Please include with your report: (1) the example input; (2) the output you
expected; (3) the output PHP Markdown actually produced.


Version History
---------------

Extra 1.2.3 (31 Dec 2008):

*	In WordPress pages featuring more than one post, footnote id prefixes are 
	now automatically applied with the current post ID to avoid clashes
	between footnotes belonging to different posts.

*	Fix for a bug introduced in Extra 1.2 where block-level HTML tags where 
	not detected correctly, thus the addition of erroneous `<p>` tags and
	interpretation of their content as Markdown-formatted instead of
	HTML-formatted.


Extra 1.2.2 (21 Jun 2008):

*	Fixed a problem where abbreviation definitions, footnote
	definitions and link references were stripped inside
	fenced code blocks.

*	Fixed a bug where characters such as `"` in abbreviation
	definitions weren't properly encoded to HTML entities.

*	Fixed a bug where double quotes `"` were not correctly encoded
	as HTML entities when used inside a footnote reference id.


1.0.1m (21 Jun 2008):

*	Lists can now have empty items.

*	Rewrote the emphasis and strong emphasis parser to fix some issues
	with odly placed and overlong markers.


Extra 1.2.1 (27 May 2008):

*	Fixed a problem where Markdown headers and horizontal rules were
	transformed into their HTML equivalent inside fenced code blocks.


Extra 1.2 (11 May 2008):

*	Added fenced code block syntax which don't require indentation
	and can start and end with blank lines. A fenced code block
	starts with a line of consecutive tilde (~) and ends on the
	next line with the same number of consecutive tilde. Here's an
	example:
	
	    ~~~~~~~~~~~~
		Hello World!
		~~~~~~~~~~~~

*	Rewrote parts of the HTML block parser to better accomodate
	fenced code blocks.

*	Footnotes may now be referenced from within another footnote.

*	Added programatically-settable parser property `predef_attr` for 
	predefined attribute definitions.

*	Fixed an issue where an indented code block preceded by a blank
	line containing some other whitespace would confuse the HTML 
	block parser into creating an HTML block when it should have 
	been code.


1.0.1l (11 May 2008):

*	Now removing the UTF-8 BOM at the start of a document, if present.

*	Now accepting capitalized URI schemes (such as HTTP:) in automatic
	links, such as `<HTTP://EXAMPLE.COM/>`.

*	Fixed a problem where `<hr@example.com>` was seen as a horizontal
	rule instead of an automatic link.

*	Fixed an issue where some characters in Markdown-generated HTML
	attributes weren't properly escaped with entities.

*	Fix for code blocks as first element of a list item. Previously,
	this didn't create any code block for item 2:
	
		*   Item 1 (regular paragraph)
		
		*       Item 2 (code block)

*	A code block starting on the second line of a document wasn't seen
	as a code block. This has been fixed.
	
*	Added programatically-settable parser properties `predef_urls` and 
	`predef_titles` for predefined URLs and titles for reference-style 
	links. To use this, your PHP code must call the parser this way:
	
		$parser = new Markdwon_Parser;
		$parser->predef_urls = array('linkref' => 'http://example.com');
		$html = $parser->transform($text);
	
	You can then use the URL as a normal link reference:
	
		[my link][linkref]	
		[my link][linkRef]
		
	Reference names in the parser properties *must* be lowercase.
	Reference names in the Markdown source may have any case.

*	Added `setup` and `teardown` methods which can be used by subclassers
	as hook points to arrange the state of some parser variables before and 
	after parsing.


Extra 1.1.7 (26 Sep 2007):

1.0.1k (26 Sep 2007):

*	Fixed a problem introduced in 1.0.1i where three or more identical
	uppercase letters, as well as a few other symbols, would trigger
	a horizontal line.


Extra 1.1.6 (4 Sep 2007):

1.0.1j (4 Sep 2007):

*	Fixed a problem introduced in 1.0.1i where the closing `code` and 
	`pre` tags at the end of a code block were appearing in the wrong 
	order.

*	Overriding configuration settings by defining constants from an 
	external before markdown.php is included is now possible without 
	producing a PHP warning.


Extra 1.1.5 (31 Aug 2007):

1.0.1i (31 Aug 2007):

*	Fixed a problem where an escaped backslash before a code span 
	would prevent the code span from being created. This should now
	work as expected:
	
		Litteral backslash: \\`code span`

*	Overall speed improvements, especially with long documents.


Extra 1.1.4 (3 Aug 2007):

1.0.1h (3 Aug 2007):

*	Added two properties (`no_markup` and `no_entities`) to the parser 
	allowing HTML tags and entities to be disabled.

*	Fix for a problem introduced in 1.0.1g where posting comments in 
	WordPress would trigger PHP warnings and cause some markup to be 
	incorrectly filtered by the kses filter in WordPress.


Extra 1.1.3 (3 Jul 2007):

*	Fixed a performance problem when parsing some invalid HTML as an HTML 
	block which was resulting in too much recusion and a segmentation fault 
	for long documents.

*	The markdown="" attribute now accepts unquoted values.

*	Fixed an issue where underscore-emphasis didn't work when applied on the 
	first or the last word of an element having the markdown="1" or 
	markdown="span" attribute set unless there was some surrounding whitespace.
	This didn't work:
	
		<p markdown="1">_Hello_ _world_</p>
	
	Now it does produce emphasis as expected.

*	Fixed an issue preventing footnotes from working when the parser's 
	footnote id prefix variable (fn_id_prefix) is not empty.

*	Fixed a performance problem where the regular expression for strong 
	emphasis introduced in version 1.1 could sometime be long to process, 
	give slightly wrong results, and in some circumstances could remove 
	entirely the content for a whole paragraph.

*	Fixed an issue were abbreviations tags could be incorrectly added 
	inside URLs and title of links.

*	Placing footnote markers inside a link, resulting in two nested links, is 
	no longer allowed.


1.0.1g (3 Jul 2007):

*	Fix for PHP 5 compiled without the mbstring module. Previous fix to 
	calculate the length of UTF-8 strings in `detab` when `mb_strlen` is 
	not available was only working with PHP 4.

*	Fixed a problem with WordPress 2.x where full-content posts in RSS feeds 
	were not processed correctly by Markdown.

*	Now supports URLs containing literal parentheses for inline links 
	and images, such as:

		[WIMP](http://en.wikipedia.org/wiki/WIMP_(computing))

	Such parentheses may be arbitrarily nested, but must be
	balanced. Unbalenced parentheses are allowed however when the URL 
	when escaped or when the URL is enclosed in angle brakets `<>`.

*	Fixed a performance problem where the regular expression for strong 
	emphasis introduced in version 1.0.1d could sometime be long to process, 
	give slightly wrong results, and in some circumstances could remove 
	entirely the content for a whole paragraph.

*	Some change in version 1.0.1d made possible the incorrect nesting of 
	anchors within each other. This is now fixed.

*	Fixed a rare issue where certain MD5 hashes in the content could
	be changed to their corresponding text. For instance, this:

		The MD5 value for " " is "26b17225b626fb9238849fd60eabdf60".
	
	was incorrectly changed to this in previous versions of PHP Markdown:

		<p>The MD5 value for " " is " ".</p>

*	Now convert escaped characters to their numeric character 
	references equivalent.
	
	This fix an integration issue with SmartyPants and backslash escapes. 
	Since Markdown and SmartyPants have some escapable characters in common, 
	it was sometime necessary to escape them twice. Previously, two 
	backslashes were sometime required to prevent Markdown from "eating" the 
	backslash before SmartyPants sees it:
	
		Here are two hyphens: \\--
	
	Now, only one backslash will do:
	
		Here are two hyphens: \--


Extra 1.1.2 (7 Feb 2007)

*	Fixed an issue where headers preceded too closely by a paragraph 
	(with no blank line separating them) where put inside the paragraph.

*	Added the missing TextileRestricted method that was added to regular
	PHP Markdown since 1.0.1d but which I forgot to add to Extra.


1.0.1f (7 Feb 2007):

*	Fixed an issue with WordPress where manually-entered excerpts, but 
	not the auto-generated ones, would contain nested paragraphs.

*	Fixed an issue introduced in 1.0.1d where headers and blockquotes 
	preceded too closely by a paragraph (not separated by a blank line) 
	where incorrectly put inside the paragraph.

*	Fixed an issue introduced in 1.0.1d in the tokenizeHTML method where 
	two consecutive code spans would be merged into one when together they 
	form a valid tag in a multiline paragraph.

*	Fixed an long-prevailing issue where blank lines in code blocks would 
	be doubled when the code block is in a list item.
	
	This was due to the list processing functions relying on artificially 
	doubled blank lines to correctly determine when list items should 
	contain block-level content. The list item processing model was thus 
	changed to avoid the need for double blank lines.

*	Fixed an issue with `<% asp-style %>` instructions used as inline 
	content where the opening `<` was encoded as `