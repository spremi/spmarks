<?php
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


header ("Content-type: text/html") ;
header ("Expires: Sat, 01 Jan 2000 05:00:00 GMT") ;
header ("Last-Modified: " . gmdate ('D, d M Y H:i:s') . " GMT") ;
header ("Cache-Control: no-store, no-cache, must-revalidate") ;
header ("Cache-Control: post-check=0, pre-check=0", false) ;
header ("Pragma: no-cache") ;


define ('__SP__MARKS__',    1) ;

//  ============================================================================
//  Is this is a 'working' installation?
//  ============================================================================
if (file_exists ('./config.inc.php')) {
    require_once ('./config.inc.php') ;
}
else {
    require_once ('./include/spInstall.inc.php') ;
    exit () ;
}

//  ============================================================================
//  Include required packages
//  ============================================================================
require_once ('./include/spConstants.inc.php') ;
require_once ('./include/spTrace.inc.php') ;
require_once ('./include/spConfig.inc.php') ;
require_once ('./include/spTheme.inc.php') ;
require_once ('./include/spDatabase.inc.php') ;
require_once ('./include/spApplication.inc.php') ;

require_once (SMARTY_LIBS . 'Smarty.class.php') ;


//  ============================================================================
//  Begin
//  ============================================================================

session_start ();

//  ----------------------------------------------------------------------------
//  Initialize Globals
//  ----------------------------------------------------------------------------
$GLOBALS ['Trace'] = null ;
$GLOBALS ['App']   = null ;

$GLOBALS ['arrCategories']  = array () ;
$GLOBALS ['CurCategory']    = 0 ;
$GLOBALS ['ArrBookmarks']   = array () ;

//  ----------------------------------------------------------------------------
//  Instantiate the trace object
//  ----------------------------------------------------------------------------
$GLOBALS ['Trace'] = CSpTrace::getInstance () ;

$GLOBALS ['Trace']->Add ('Begin [' . date ('M d, Y h:i:s A') . ']') ;

//  ----------------------------------------------------------------------------
//  Default category ID (Can be defined via configuration)
//  ----------------------------------------------------------------------------
$GLOBALS ['Trace']->Add ('Initialize curCategory') ;
$GLOBALS ['CurCategory'] = 0 ;

//  ----------------------------------------------------------------------------
//  Initialize theme
//  ----------------------------------------------------------------------------
if (defined ('__SP_USE_THEME')) {
    $UseTheme = __SP_USE_THEME ;
}
else {
    define ('__SP_USE_THEME', 'default') ;
}

//  ----------------------------------------------------------------------------
//  Create new application object
//  ----------------------------------------------------------------------------
$GLOBALS ['Trace']->Add ('Create application object') ;

$GLOBALS ['App'] =& new CSpApplication () ;

$GLOBALS ['App']->init () ;
$GLOBALS ['App']->openDB () ;

//  ----------------------------------------------------------------------------
//  Determine the requested action.
//  ----------------------------------------------------------------------------
$choiceAction = '' ;
$choicePost   = false ;

$GLOBALS ['Trace']->Add ('Process') ;

if (isset ($_GET ['act'])) {
    $choiceAction = $_GET ['act'] ;

    $GLOBALS ['Trace']->Add ('Action : ' . $choiceAction) ;
}
else {
    $GLOBALS ['Trace']->Add ('No action specified.') ;
}

if (isset($_POST ['form'])) {
    $choicePost = true ;
}

//  ----------------------------------------------------------------------------
//  Perform desired action
//  ----------------------------------------------------------------------------
$GLOBALS ['App']->act ($choiceAction, $choicePost) ;

//  ============================================================================
//  End
//  ============================================================================
$GLOBALS ['App']->closeDB () ;

$GLOBALS ['Trace']->Add ('End') ;
?>

