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


//
//  Prevent direct access
//
defined ('__SP__MARKS__') or die (
    '<h1>NO ENTRY</h1>' .
    '<p>You have tried to access restricted area.</p>'
    ) ;


/*
 *  Read additional GET arguments (if any)
 *  Also, set defaults as necessary.
 */
if ($_SERVER ['REQUEST_METHOD'] === 'GET') {
    if (isset ($_GET [ARG_BMARK_ID])) {
        $GLOBALS [ARG_BMARK_ID] = urldecode ($_GET [ARG_BMARK_ID]) ;
    }

    if (isset ($_GET [ARG_BMARK_CAT])) {
        $GLOBALS [ARG_BMARK_CAT] = urldecode ($_GET [ARG_BMARK_CAT]) ;
    }

    if (isset ($_GET [ARG_KEY])) {
        $GLOBALS [ARG_KEY] = urldecode ($_GET [ARG_KEY]) ;
    }
    else {
        // Default : Sort by ID
        $GLOBALS [ARG_KEY] = KEY_ID ;
    }

    if (isset ($_GET [ARG_SORT])) {
        $GLOBALS [ARG_SORT] = urldecode ($_GET [ARG_SORT]) ;
    }
    else {
        // Default : Sort ascending
        $GLOBALS [ARG_SORT] = ARG_SORT_ASC ;
    }
}


/*
 *  Read additional POST arguments (if any)
 *  Also, set defaults as necessary.
 */
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
    if (isset ($_POST [ARG_BMARK_ID])) {
        $GLOBALS [ARG_BMARK_ID] = urldecode ($_POST [ARG_BMARK_ID]) ;
    }

    if (isset ($_POST [ARG_BMARK_CAT])) {
        $GLOBALS [ARG_BMARK_CAT] = urldecode ($_POST [ARG_BMARK_CAT]) ;
    }

    if (isset ($_POST [ARG_BMARK_TITLE])) {
        $GLOBALS [ARG_BMARK_TITLE] = urldecode ($_POST [ARG_BMARK_TITLE]) ;
    }

    if (isset ($_POST [ARG_BMARK_URL])) {
        $GLOBALS [ARG_BMARK_URL] = urldecode ($_POST [ARG_BMARK_URL]) ;
    }

    if (isset ($_POST [ARG_BMARK_DESC])) {
        $GLOBALS [ARG_BMARK_DESC] = urldecode ($_POST [ARG_BMARK_DESC]) ;
    }

    if (isset ($_POST [ARG_KEY])) {
        $GLOBALS [ARG_KEY] = urldecode ($_POST [ARG_KEY]) ;
    }
    else {
        // Default : Sort by ID
        $GLOBALS [ARG_KEY] = KEY_ID ;
    }

    if (isset ($_POST [ARG_SORT])) {
        $GLOBALS [ARG_SORT] = urldecode ($_POST [ARG_SORT]) ;
    }
    else {
        // Default : Sort ascending
        $GLOBALS [ARG_SORT] = ARG_SORT_ASC ;
    }
}



/**
 *  Get list of bookmarks from the database
 */
function listBookmarks (&$db)
{
    $ret      = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

}

/**
 *  Edit (add/ modify/ delete) a bookmark
 */
function editBookmark (&$db, $op)
{
    $ret      = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

    return $ret ;
}
?>

