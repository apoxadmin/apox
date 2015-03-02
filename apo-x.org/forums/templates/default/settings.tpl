{! --- defines are used by the engine and vars are used by the template --- }

{! --- This is used to indent messages in threaded view --- }
{define indentstring &nbsp;&nbsp;&nbsp;}

{! --- This is used to load the message-bodies in the message-list for that template if set to 1 --- }
{define bodies_in_list 0}

{! --- This is the marker for messages in threaded view --- }
{define marker <img src="templates/default/images/carat.gif" border="0" width="8" height="8" alt="" style="vertical-align: middle;" />&nbsp;}

{! --- these are the colors used in the style sheet --- }

{! --- you can use them or replace them in the style sheet --- }

{! --- common body-colors --- }
{var bodybackground #878787}
{var defaulttextcolor }
{var backcolor White}
{var forumwidth 100%}
{var forumalign center}
{var newflagcolor #CC0000}
{var errorfontcolor Red}
{var okmsgfontcolor DarkGreen}

{! --- for the forum-list ... alternating colors --- }
{var altbackcolor #EEE}
{var altlisttextcolor white}

{! --- common link-settings --- }
{var linkcolor #000099}
{var activelinkcolor #FF6600}
{var visitedlinkcolor #000099}
{var hoverlinkcolor #FF6600}

{! --- for the Navigation --- }
{var navbackcolor DarkGray}
{var navtextcolor white}
{var navhoverbackcolor DarkGray}
{var navhoverlinkcolor white}
{var navtextweight normal}
{var navfont Tahoma, sans-serif}
{var navfontsize small}

{! --- for the PhorumHead ... the list-header --- }
{var headerbackcolor LightGrey}
{var headertextcolor Black}
{var headertextweight bold}
{var headerfont Tahoma, sans-serif}
{var headerfontsize small}



{var tablebordercolor Black}

{var listlinecolor #F2F2F2}

{var listpagelinkcolor #707070}
{var listmodlinkcolor #707070}



{! --- You can set the table width globaly here ... ONLY tables, no divs are changed--- }
{var tablewidth 980px}
{var tablewidthsmall 960px}
{var narrowtablewidth 600px}



{! --- Some font stuff --- }
{var defaultfont Verdana, sans-serif}
{var largefont Verdana, sans-serif}
{var tinyfont Verdana, sans-serif}
{var fixedfont Verdana, sans-serif}
{var defaultfontsize small}
{var largefontsize medium}
{var smallfontsize x-small}
{var tinyfontsize x-small}
