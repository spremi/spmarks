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

//  IMPORTANT
//
//  Since this is default theme, empty functiona are being provided for many
//  hooks to be used as a template for cutom themes. If a specific hook is not
//  necessary for your theme, it need not be implemented.


//  ----------------------------------------------------------------------------
//  CORE FUNCTIONS
//  ----------------------------------------------------------------------------

/**
 *  Update the contents of container and make it visible.
 *
 */
function showContainer (c, str)
{
    $(c).update (str) ;

    Effect.Appear (c) ;
}

//  ----------------------------------------------------------------------------
//  MENU
//  ----------------------------------------------------------------------------

/**
 *  Currently active menu
 */
var curMenu = null ;

/**
 *  Shows specified visible menu.
 *  - Sets global variable 'curMenu'.
 **/
function showMenu (id)
{
    curMenu = id ;
    Effect.Appear (curMenu) ;
}

/**
 *  Hides currently visible menu.
 *  - Resets global variable 'curMenu'.
 */
function hideMenu ()
{
    if (curMenu != null)
    {
        Effect.Fade (curMenu) ;

        curMenu = null ;
    }
}

/**
 *  Toggles visibility of the menu
 */
function doMenuToggle (id)
{
    /*
     *  Ideally, one of these function should be used; but despite queueing,
     *  the longer menus leave trace on the screen.
     *  Effect.toggle (id, 'appear', {duration: '1.0'}) ;
     *  Effect.toggle (id, 'appear', {queue: 'end', duration: '1.0'}) ;
     */
    if (id == curMenu)
    {
        hideMenu () ;
    }
    else
    {
        hideMenu () ;
        showMenu (id) ;
    }
}


/**
 *  Hook called before action corresponding to chosen menu/ menuitem is started.
 *  E.g. it can be used to hide the menu currently displayed, change the cursor
 *  to 'busy'
 */
function beforeMenuAction ()
{
    hideMenu () ;
}


/**
 *  Hook called after action corresponding to chosen menu/ menuitem is done.
 *  E.g. it can be used to change the cursor back to 'normal'.
 */
function afterMenuAction ()
{
}


//  ----------------------------------------------------------------------------
//  DESCRIPTION
//  ----------------------------------------------------------------------------

/**
 *  Toggles visibility of the textual description of specified elements
 */
function doDescToggle (arr)
{
    for (var i = 0 ; i < arr.length ; i++)
    {
        Effect.toggle (arr [i], 'blind', {queue: 'end', duration: '0.2' }) ;
    }
}

/**
 *  Visual hook called before toggling the text description.
 */
function beforeDescToggle ()
{
    hideMenu () ;
}


/**
 *  Visual hook called after toggling the text description.
 */
function afterDescToggle ()
{
}


//  ----------------------------------------------------------------------------
//  TRACE
//  ----------------------------------------------------------------------------

/**
 *  Toggles visibility of the trace container
 */
function doTraceToggle ()
{
    Effect.toggle ('pgTrace', 'appear', {queue: 'end', duration: '0.5' }) ;
}


/**
 *  Visual hook called before toggling the trace container.
 */
function beforeTraceToggle ()
{
}


/**
 *  Visual hook called after toggling the trace container.
 */
function afterTraceToggle ()
{
}


//  ----------------------------------------------------------------------------
//  FORM
//  ----------------------------------------------------------------------------

/**
 *  Visual hook called before submitting the form.
 */
function beforeFormSubmit ()
{
    Effect.fade ('pgDialog') ;
}


/**
 *  Visual hook called after submitting the form.
 */
function afterFormSubmit ()
{
}

/**
 *  Visual hook called if the form is not completely filled.
 */
function errFormSubmit ()
{
    showMessage ('Insufficient data. Please fill out all the fields.', 2) ;
}


//  ----------------------------------------------------------------------------
//  MESSAGE PANEL
//  ----------------------------------------------------------------------------

/**
 *  Show message panel for specific duration (in secs).
 *
 */
function showMessage (msg, dur)
{
    $('pgMessage').update (str) ;

    Effect.Appear ('pgMessage') ;

    setTimeout ("hideMessage ()", (dur * 1000)) ;
}

/**
 *  Hide message panel
 *
 */
function hideMessage ()
{
    Effect.fade ('pgMessage') ;
}

