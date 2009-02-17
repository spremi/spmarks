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
 *  Get a specific bookmark from database. Modifies $GLOBALS ['SelBookmark'].
 */
function getBookmark (&$db, $argId)
{
    $ret = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

    $str  = "SELECT * FROM `bmark` " ;
    $str .= "WHERE `id`='" . $argId . "'" ;

    $GLOBALS ['Trace']->Add ("SQL: " . $str) ;

    $ret = $db->query ($str) ;
    if ($ret == true) {
        while ($row = $db->nextRow ()) {
            $GLOBALS ['SelBookmark'] = array (
                                            "id"    => $row->id,
                                            "catId" => $row->category,
                                            "title" => $row->title,
                                            "link"  => $row->url,
                                            "desc"  => $row->desc);
        }

        $db->flush () ;
    }
    else {
        $GLOBALS ['Trace']->Add ("Unable to get list of bookmarks from database") ;
    }

    return $ret ;
}


/**
 *  Get list of bookmarks from the database
 */
function listBookmarks (&$db)
{
    $ret = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

    /*
     *  Create SQL query
     */
    $str = "SELECT * FROM `bmark` " ;

    if (isset ($GLOBALS [ARG_BMARK_CAT])) {
        $str .= "WHERE `category`='" . $GLOBALS [ARG_BMARK_CAT] . "' " ;
    }

    $str .= "ORDER BY '" . $GLOBALS [ARG_KEY] . "' " . $GLOBALS [ARG_SORT] ;

    $GLOBALS ['Trace']->Add ("SQL: " . $str) ;

    /*
     *  Execute the query
     */
    $ret = $db->query ($str) ;
    if ($ret == true) {
        while ($row = $db->nextRow ()) {
            $GLOBALS ['ArrBookmarks'][] = array ("id"    => $row->id,
                                                 "catId" => $row->category,
                                                 "title" => $row->title,
                                                 "link"  => $row->url,
                                                 "desc"  => $row->desc);
        }

        $db->flush () ;
    }
    else {
        $GLOBALS ['Trace']->Add ("Unable to get list of bookmarks from database") ;
    }

    return $ret ;
}

/**
 *  Edit (add/ modify/ delete) a bookmark
 */
function editBookmark (&$db, $op)
{
    $ret = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

    switch ($op)
    {
    case ACT_BMARK_ADD :
        $query  = "INSERT INTO `bmark` (`category` , `title` , `url`, `desc` )" ;
        $query .= "VALUES (" ;
        $query .= "'" . $db->escapeStr ($GLOBALS [ARG_BMARK_CAT])    . "', " ;
        $query .= "'" . $db->escapeStr ($GLOBALS [ARG_BMARK_TITLE])  . "', " ;
        $query .= "'" . $db->escapeStr ($GLOBALS [ARG_BMARK_URL])    . "', " ;
        $query .= "'" . $db->escapeStr ($GLOBALS [ARG_BMARK_DESC])   . "');" ;
        break ;

    case ACT_BMARK_MOD :
        $query  = "UPDATE `bmark` " ;
        $query .= "SET " ;
        $query .= "`category`='" . $db->escapeStr ($GLOBALS [ARG_BMARK_CAT])   . "', " ;
        $query .= "`title`='"    . $db->escapeStr ($GLOBALS [ARG_BMARK_TITLE]) . "', " ;
        $query .= "`url`='"      . $db->escapeStr ($GLOBALS [ARG_BMARK_URL])   . "', " ;
        $query .= "`desc`='"     . $db->escapeStr ($GLOBALS [ARG_BMARK_DESC])  . "' " ;
        $query .= "WHERE " ;
        $query .= "`id`='"       . $db->escapeStr ($GLOBALS [ARG_BMARK_ID])    . "'" ;
        break ;

    case ACT_BMARK_DEL :
        break ;

    default :
        break ;
    }

    $GLOBALS ['Trace']->Add ("SQL: " . $query) ;

    $ret = $db->query ($query) ;

    return $ret ;
}
?>

