//  ============================================================================
//  spMARKS
//
//  A Web 2.0 Bookmark Management System
//  ============================================================================
//  The MIT License
//
//  Copyright (c) 2008 Sanjeev Premi <spremi@ymail.com>
//
//  Permission is hereby granted, free of charge, to any person obtaining a copy
//  of this software and associated documentation files (the "Software"), to
//  deal in the Software without restriction, including without limitation the
//  rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
//  sell copies of the Software, and to permit persons to whom the Software is
//  furnished to do so, subject to the following conditions:
//
//  The above copyright notice and this permission notice shall be included in
//  all copies or substantial portions of the Software.
//
//  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
//  FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
//  IN THE SOFTWARE.
//  ============================================================================


//  ============================================================================
//  This file contains core application functions.
//
//  All 'visual' operations are expected to be implemented in the themes. To
//  enable the division, specific hooks are provided for themes to do their own
//  stuff. These hooks are easily identified by these prefixes:
//  - beforeXXX ()  : Called before an action is initiated.
//  - afterXXX  ()  : Called after  an action was completed successfully.
//  - errXXX    ()  : Called after  an action completes unsuccessfully.
//  ============================================================================


//  ============================================================================
//  Constants
//  TBD: Get these constant values via PHP
//  ============================================================================
const ACT_TRACE     = 'trace' ;

const ACT_BMARK_LST = 'bm_lst' ;
const ACT_BMARK_ADD = 'bm_add' ;
const ACT_BMARK_MOD = 'bm_mod' ;
const ACT_BMARK_DEL = 'bm_del' ;

const ACT_BMCAT_LST = 'cat_lst' ;
const ACT_BMCAT_ADD = 'cat_add' ;
const ACT_BMCAT_MOD = 'cat_mod' ;
const ACT_BMCAT_DEL = 'cat_del' ;

/**
 * Should the trace information be displayed on page load?
 */
const TRACE_ONLOAD  = true ;


//  ============================================================================
//  Base AJAX operations
//  ============================================================================

/**
 *  Sends an AJAX request to the server. On success, it calls a generic
 *  callback function implemented by the theme.
 *
 *  @param  string  Method - GET | POST
 *  @param  string  Requested operation (Passed to the callback function).
 *  @param  string  Arguments (optional)
 */
function doAction (sm, op, args)
{
    var strArg ;

    if (sm == 'GET') {
        if (args == null) {
            strArg = 'act=' + op ;
        }
        else {
            strArg = 'act=' + op + '&' + args ;
        }
    }
    else {
        if (args != null) {
            strArgs = args ;
        }
    }

    var req = new Ajax.Request (
                    'index.php',
                    {
                        method    : sm,
                        parameters: strArg,
                        onSuccess : function (transport)
                                    {
                                        // This function is implemented by the
                                        // theme. At minimum, it should insert
                                        // the response text into appropriate
                                        // HTML container.
                                        actionComplete (sm, op, transport.responseText) ;
                                    }
                    }
                ) ;
}

/**
 *  Submits AJAX request containing the form data. Before submitting, it also
 *  checks if mandatory fields have been filled.
 */
function doForm (name)
{
    var form  = $(name) ;

    var valid = false ;
    var url   = "" ;
    var cmd   = "" ;

    switch (name)
    {
    case 'addBm' :
        cmd   = ACT_BMARK_ADD ;

        valid =     $(form.bmTitle).present ()
                &&  $(form.bmDesc).present ()
                &&  $(form.bmUrl).present () ;
        break ;

    case 'modBm' :
        cmd   = ACT_BMARK_MOD ;

        valid =     $(form.bmId).present ()
                &&  $(form.bmTitle).present ()
                &&  $(form.bmDesc).present ()
                &&  $(form.bmUrl).present () ;
        break ;

    case 'delBm' :
        cmd   = ACT_BMARK_DEL ;
        break ;

    case 'addCat' :
        cmd   = ACT_BMCAT_ADD ;

        valid =     $(form.catTitle).present ()
                &&  $(form.catDesc).present () ;
        break ;

    case 'modCat' :
        cmd   = ACT_BMCAT_MOD ;

        valid =     $(form.catId).present ()
                &&  $(form.catName).present ()
                &&  $(form.catDesc).present () ;
        break ;

    case 'delCat' :
        cmd   = ACT_BMCAT_DEL ;

        break ;

    default:
        break ;
    }

    if (valid)
    {
        var args = $(form).serialize (true) ;

        if (typeof beforeFormSubmit == 'function') {
            beforeFormSubmit () ;
        }

        doAction ('POST', cmd, args) ;

        if (typeof afterFormSubmit == 'function') {
            afterFormSubmit () ;
        }
    }
    else
    {
        errFormSubmit () ;
    }
}

/**
 *  Displays the result of the AJAX request.
 *  It essentially puts that received content into appropriate containers.
 */
function actionComplete (method, cmd, response)
{
    var container ;

    if (method == 'GET') {
        switch (cmd)
        {
        case ACT_TRACE :
            container = 'pgTrace' ;
            break ;

        case ACT_BMARK_LST :
            container = 'pgBookmarks' ;
            break ;

        case ACT_BMCAT_LST :
            container = 'pgCategories' ;
            break ;

        default :
            container = 'pgDialog' ;
            break ;
        }
    }
    else {
        container = 'pgMessage' ;
    }

    $(container).innerHTML = response ;

    showContainer (container) ;
}

//  ============================================================================
//  Menu actions
//  ============================================================================

/**
 *  Wraps the AJAX requests originating from the menu item.
 *  It basically, allows themes to do custom actions.
 *
 *  @param  string  URL where the request should be sent
 *  @param  string  Requested operation.
 */
function doMenuAction (op)
{
    var args = 'act=' + op ;

    if (typeof beforeMenuAction == 'function') {
        beforeMenuAction () ;
    }

    doAction ('GET', op, args) ;

    if (typeof afterMenuAction == 'function') {
        afterMenuAction () ;
    }
}


//  ============================================================================
//  Actions when the page is loaded
//  ============================================================================
Event.observe (
                window,
                'load',
                function ()
                {
                    if (typeof beforePageLoad == 'function') {
                        beforePageLoad () ;
                    }

                    doAction ('GET', ACT_BMCAT_LST, null) ;
                    doAction ('GET', ACT_BMARK_LST, null) ;

                    if (TRACE_ONLOAD) {
                        doAction ('GET', ACT_TRACE, null) ;
                    }

                    if (typeof afterPageLoad == 'function') {
                      afterPageLoad () ;
                    }
                }
            ) ;

