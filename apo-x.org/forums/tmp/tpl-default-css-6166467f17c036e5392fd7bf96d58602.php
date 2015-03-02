<?php if(!defined("PHORUM")) return; ?>

    /* Element level classes */

    td, th
    {
        color: <?php echo $PHORUM['DATA']['defaulttextcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        background-color: <?php echo $PHORUM['DATA']['backcolor']; ?>;
    }

    img
    {
        border-width: 0px;
        vertical-align: middle;
    }

    /*a
    {
        color: <?php echo $PHORUM['DATA']['linkcolor']; ?>;
        text-decoration: none;
    }
    a:active
    {
        color: <?php echo $PHORUM['DATA']['activelinkcolor']; ?>;
        text-decoration: none;
    }
    a:visited
    {
        color: <?php echo $PHORUM['DATA']['visitedlinkcolor']; ?>;
        text-decoration: none;
    }        

    a:hover
    {
        color: <?php echo $PHORUM['DATA']['hoverlinkcolor']; ?>;
    }*/

    input[type=text], input[type=password], input[type=file], select
    {
/*        border: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>; */

        /*background-color: <?php echo $PHORUM['DATA']['backcolor']; ?>;*/
        color: <?php echo $PHORUM['DATA']['defaulttextcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;

        vertical-align: middle;

    }

    /*textarea
    {
        background-color: <?php echo $PHORUM['DATA']['backcolor']; ?>;
        color: <?php echo $PHORUM['DATA']['defaulttextcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['fixedfont']; ?>;
    }
    
	input[type=submit]
	{
        border: 1px dotted <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        background-color: <?php echo $PHORUM['DATA']['navbackcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        vertical-align: middle;
	}

	input
	{
        vertical-align: middle;
	}*/

    /* Standard classes for use in any page */
    /* PhorumDesignDiv - a div for keeping the forum-size size */
    .PDDiv
    {
        width: <?php echo $PHORUM['DATA']['forumwidth']; ?>;
        text-align: left;
    }        
    /* new class for layouting the submit-buttons in IE too */
    .PhorumSubmit { 
        border: 1px dotted <?php echo $PHORUM['DATA']['tablebordercolor']; ?>; 
        color: <?php echo $PHORUM['DATA']['defaulttextcolor']; ?>; 
        background-color: <?php echo $PHORUM['DATA']['navbackcolor']; ?>; 
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>; 
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>; 
        vertical-align: middle; 
    }    
    
    .PhorumTitleText
    {
        float: right;
    }

    .PhorumStdBlock
    {
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        background-color: <?php echo $PHORUM['DATA']['backcolor']; ?>;
        border: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
/*        width: <?php echo $PHORUM['DATA']['tablewidth']; ?>; */
        padding: 3px;		
    }

    .PhorumStdBlockHeader
    {
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        background-color: <?php echo $PHORUM['DATA']['navbackcolor']; ?>;
/*        width: <?php echo $PHORUM['DATA']['tablewidth']; ?>; */
        border-left: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-right: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-top: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        padding: 3px;
    }

    .PhorumHeaderText
    {
        font-weight: bold;
    }

    .PhorumNavBlock
    {
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        border: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        margin-top: 1px;
        margin-bottom: 1px;
/*        width: <?php echo $PHORUM['DATA']['tablewidth']; ?>; */
        background-color: <?php echo $PHORUM['DATA']['navbackcolor']; ?>;
        padding: 2px 3px 2px 3px;
    }

    .PhorumNavHeading
    {
        font-weight: bold;
    }

    A.PhorumNavLink
    {
        color: <?php echo $PHORUM['DATA']['navtextcolor']; ?>;
        text-decoration: none;
        font-weight: <?php echo $PHORUM['DATA']['navtextweight']; ?>;
        font-family: <?php echo $PHORUM['DATA']['navfont']; ?>;
        font-size: <?php echo $PHORUM['DATA']['navfontsize']; ?>;
        border-style: solid;
        border-color: <?php echo $PHORUM['DATA']['navbackcolor']; ?>;
        border-width: 1px;
        padding: 0px 4px 0px 4px;
    }

    A.PhorumNavLink:hover
    {
        background-color: <?php echo $PHORUM['DATA']['navhoverbackcolor']; ?>;
        font-weight: <?php echo $PHORUM['DATA']['navtextweight']; ?>;
        font-family: <?php echo $PHORUM['DATA']['navfont']; ?>;
        font-size: <?php echo $PHORUM['DATA']['navfontsize']; ?>;        
        border-style: solid;
        border-color: <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-width: 1px;
        color: <?php echo $PHORUM['DATA']['navhoverlinkcolor']; ?>;
    }

    .PhorumFloatingText
    {
        padding: 10px;
    }

    .PhorumHeadingLeft
    {
        padding-left: 3px;
        font-weight: bold;
    }

    .PhorumUserError
    {
        padding: 10px;
        text-align: center;
        color: <?php echo $PHORUM['DATA']['errorfontcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['largefontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['largefont']; ?>;
        font-weight: bold;
    }

    .PhorumOkMsg
    {
        padding: 10px;
        text-align: center;
        color: <?php echo $PHORUM['DATA']['okmsgfontcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['largefontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['largefont']; ?>;
        font-weight: bold;
    }

   .PhorumNewFlag
    {
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        font-size: <?php echo $PHORUM['DATA']['tinyfontsize']; ?>;
        font-weight: bold;
        color: <?php echo $PHORUM['DATA']['newflagcolor']; ?>;
    }

    .PhorumNotificationArea
    {
        float: right;
        border-style: dotted;
        border-color: <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-width: 1px;
    }

    /* PSUEDO Table classes                                       */
    /* In addition to these, each file that uses them will have a */
    /* column with a style property to set its right margin       */    

    .PhorumColumnFloatXSmall
    {
        float: right; 
        width: 75px;
    }

    .PhorumColumnFloatSmall
    {
        float: right; 
        width: 100px;
    }

    .PhorumColumnFloatMedium
    {
        float: right; 
        width: 150px;
    }

    .PhorumColumnFloatLarge
    {
        float: right; 
        width: 200px;
    }

    .PhorumColumnFloatXLarge
    {
        float: right; 
        width: 400px;
    }

    .PhorumRowBlock
    {
        background-color: <?php echo $PHORUM['DATA']['backcolor']; ?>;
        border-bottom: 1px solid <?php echo $PHORUM['DATA']['listlinecolor']; ?>;
        padding: 5px 0px 0px 10px;
    }

    .PhorumRowBlockAlt
    {
        background-color: <?php echo $PHORUM['DATA']['altbackcolor']; ?>;
        border-bottom: 1px solid <?php echo $PHORUM['DATA']['listlinecolor']; ?>;
        padding: 5px 0px 0px 10px;
    }

    /************/
    

    /* All that is left of the tables */

    .PhorumStdTable
    {
        border-style: solid;
        border-color: <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-width: 1px;
        width: <?php echo $PHORUM['DATA']['tablewidth']; ?>;
    }

    .PhorumTableHeader
    {
        background-color: <?php echo $PHORUM['DATA']['headerbackcolor']; ?>;
        border-bottom-style: solid;
        border-bottom-color: <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-bottom-width: 1px;
        color: <?php echo $PHORUM['DATA']['headertextcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['headerfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['headerfont']; ?>;
        font-weight: <?php echo $PHORUM['DATA']['headertextweight']; ?>;
        padding: 3px;
    }

    .PhorumTableRow
    {
        background-color: <?php echo $PHORUM['DATA']['backcolor']; ?>;
        border-bottom-style: solid;
        border-bottom-color: <?php echo $PHORUM['DATA']['listlinecolor']; ?>;
        border-bottom-width: 1px;
        color: <?php echo $PHORUM['DATA']['defaulttextcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        height: 35px;
        padding: 3px;
    }
    
    .PhorumTableRowAlt
    {
        background-color: <?php echo $PHORUM['DATA']['altbackcolor']; ?>;
        border-bottom-style: solid;
        border-bottom-color: <?php echo $PHORUM['DATA']['listlinecolor']; ?>;
        border-bottom-width: 1px;
        color: <?php echo $PHORUM['DATA']['altlisttextcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        height: 35px;
        padding: 3px;
    }    

    table.PhorumFormTable td
    {
        height: 26px;
    }

    /**********************/


    /* Read Page specifics */
    
    .PhorumReadMessageBlock
    {
        margin-bottom: 5px;
    }
    
   .PhorumReadBodySubject
    {
        font-size: <?php echo $PHORUM['DATA']['largefontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['largefont']; ?>;
        font-weight: bold;
        padding-left: 3px;
    }

    .PhorumReadBodyHead
    {
        padding-left: 5px;
    }

    .PhorumReadBodyText
    {
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        padding: 5px;
    }

    .PhorumReadNavBlock
    {
        font-size: <?php echo $PHORUM['DATA']['defaultfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['defaultfont']; ?>;
        border-left: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-right: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
        border-bottom: 1px solid <?php echo $PHORUM['DATA']['tablebordercolor']; ?>;
/*        width: <?php echo $PHORUM['DATA']['tablewidth']; ?>; */
        background-color: <?php echo $PHORUM['DATA']['navbackcolor']; ?>;
        padding: 2px 3px 2px 3px;
    }

    /********************/
    
    /* List page specifics */

    .PhorumListSubText
    {
        color: <?php echo $PHORUM['DATA']['listpagelinkcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['tinyfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['tinyfont']; ?>;
    }

    .PhorumListPageLink
    {
        color: <?php echo $PHORUM['DATA']['listpagelinkcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['tinyfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['tinyfont']; ?>;
    }

    .PhorumListSubjPrefix
    {
        font-weight: bold;
    }    

    .PhorumListModLink, .PhorumListModLink a
    {
        color: <?php echo $PHORUM['DATA']['listmodlinkcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['tinyfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['tinyfont']; ?>;
    }
    /********************/

    /* Override classes - Must stay at the end */

    .PhorumNarrowBlock
    {
        width: <?php echo $PHORUM['DATA']['narrowtablewidth']; ?>;
    }

    .PhorumSmallFont
    {
        font-size: <?php echo $PHORUM['DATA']['smallfontsize']; ?>;
    }    

    .PhorumLargeFont
    {
        color: <?php echo $PHORUM['DATA']['defaulttextcolor']; ?>;
        font-size: <?php echo $PHORUM['DATA']['largefontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['largefont']; ?>;
        font-weight: bold;
    }    


    .PhorumFooterPlug
    {
        margin-top: 10px;
        font-size: <?php echo $PHORUM['DATA']['tinyfontsize']; ?>;
        font-family: <?php echo $PHORUM['DATA']['tinyfont']; ?>;
    }
