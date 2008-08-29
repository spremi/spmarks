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

//  Do not start session until the user authentication is implemented.
//  $_SESSION variables seem to work as good as $GLOBALS.
//
//session_start ();

//  ----------------------------------------------------------------------------
//  Instantiate the trace object
//  ----------------------------------------------------------------------------
if ((defined ('__SP_TRACE')) && empty ($_SESSION ['TRACE'])) {
    $_SESSION ['TRACE'] = CSpTrace::getInstance () ;
}

CSpTrace::Add ('Begin') ;

//  ----------------------------------------------------------------------------
//  List of categories.
//  ----------------------------------------------------------------------------
if (empty ($_SESSION ['arrCategories'])) {
    $_SESSION ['arrCategories'] = array () ;
}

//  ----------------------------------------------------------------------------
//  Default category ID (Can be defined via configuration)
//  ----------------------------------------------------------------------------
if (empty ($_SESSION ['currCategory'])) {
    $_SESSION ['curCategory'] = 0 ;
}

//  ----------------------------------------------------------------------------
//  List of bookmarks
//  ----------------------------------------------------------------------------
if (empty ($_SESSION ['arrBookmarks'])) {
    $_SESSION ['arrBookmarks'] = array() ;
}

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
if (empty ($_SESSION ['App'])) {
    $_SESSION ['App'] =& new CSpApplication ;

    $_SESSION ['App']->init () ;
}

//  ----------------------------------------------------------------------------
//  Determine the requested action.
//  ----------------------------------------------------------------------------
$choiceAction = '' ;
$choicePost   = false ;

CSpTrace::Add ('Process') ;

if (isset ($_GET ['act'])) {
    $choiceAction = $_GET ['act'] ;

    CSpTrace::Add ('Action : ' . $choiceAction) ;
}
else {
    $choiceAction = ACT_BMARK_LST ;

    CSpTrace::Add ('Action not specified. Use default.') ;
}

if (isset($_POST ['form'])) {
    $choicePost = true ;
}

//  ----------------------------------------------------------------------------
//  Perform desired action
//  ----------------------------------------------------------------------------
$_SESSION ['App']->act ($choiceAction, $choicePost) ;

//  ============================================================================
//  End
//  ============================================================================
$_SESSION ['App']->close () ;

CSpTrace::Add ('Done') ;
?>

