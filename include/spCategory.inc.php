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
    if (isset ($_GET [ARG_BMCAT_ID])) {
        $GLOBALS [ARG_BMCAT_ID] = urldecode ($_GET [ARG_BMCAT_ID]) ;
    }
}

/*
 *  Read additional POST arguments (if any)
 *  Also, set defaults as necessary.
 */
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
    if (isset ($_POST [ARG_BMCAT_ID])) {
        $GLOBALS [ARG_BMCAT_ID] = urldecode ($_POST [ARG_BMCAT_ID]) ;
    }

    if (isset ($_POST [ARG_BMCAT_TITLE])) {
        $GLOBALS [ARG_BMCAT_TITLE] = urldecode ($_POST [ARG_BMCAT_TITLE]) ;
    }

    if (isset ($_POST [ARG_BMCAT_DESC])) {
        $GLOBALS [ARG_BMCAT_DESC] = urldecode ($_POST [ARG_BMCAT_DESC]) ;
    }

    if (isset ($_POST [ARG_BMCAT_ORDER])) {
        $GLOBALS [ARG_BMCAT_ORDER] = urldecode ($_POST [ARG_BMCAT_ORDER]) ;
    }
    else {
        $GLOBALS [ARG_BMCAT_ORDER] = "0" ;
    }
}


/**
 *  Get a specific category from database. Modifies $GLOBALS ['SelCategory'].
 */
function getCategory (&$db, $argId)
{
    $ret = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

    $str  = "SELECT * FROM `categories` " ;
    $str .= "WHERE `id`='" . $argId . "'" ;

    $GLOBALS ['Trace']->Add ("SQL: " . $str) ;

    $ret = $db->query ($str) ;
    if ($ret == true) {
        while ($row = $db->nextRow ()) {
            $GLOBALS ['SelCategory'] = array (
                                            "id"    => $row->id,
                                            "title" => $row->title,
                                            "desc"  => $row->desc,
                                            "order" => $row->order);
        }

        $db->flush () ;
    }
    else {
        $GLOBALS ['Trace']->Add ("Unable to get list of categories from database") ;
    }

    return $ret ;
}


/**
 *  Get list of categories from the database
 */
function listCategories (&$db)
{
    $ret = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

    $str = "SELECT * FROM `categories` ORDER BY `id` ASC" ;

    $ret = $db->query ($str) ;

    if ($ret == true) {
        $GLOBALS ['ArrCategories'] = array () ;

        while ($row = $db->nextRow ()) {
            $GLOBALS ['ArrCategories'][] = array (
                                                "id"    => $row->id,
                                                "title" => $row->title,
                                                "desc"  => $row->desc,
                                                "order" => $row->order);
        }

        $db->flush () ;
    }
    else {
        $GLOBALS ['Trace']->Add ("Unable to get list of categories from database") ;
    }

    return $ret ;
}

/**
 *  Edit (add/ modify/ delete) a category
 */
function editCategory (&$db, $op)
{
    $ret = true ;

    $GLOBALS ['Trace']->Add (__FUNCTION__) ;

    switch ($op)
    {
    case ACT_BMCAT_ADD :
        $query  = "INSERT INTO `categories` (`title` , `desc` , `order` )" ;
        $query .= "VALUES (" ;
        $query .= "'" . $db->escapeStr ($GLOBALS [ARG_BMCAT_TITLE]) . "', " ;
        $query .= "'" . $db->escapeStr ($GLOBALS [ARG_BMCAT_DESC])  . "', " ;
        $query .= "'" . $db->escapeStr ($GLOBALS [ARG_BMCAT_ORDER]) . "');" ;
        break ;

    case ACT_BMCAT_MOD :
        $query  = "UPDATE `categories` " ;
        $query .= "SET " ;
        $query .= "`title`='" . $db->escapeStr ($GLOBALS [ARG_BMCAT_TITLE]) . "', " ;
        $query .= "`desc`='"  . $db->escapeStr ($GLOBALS [ARG_BMCAT_DESC])  . "', " ;
        $query .= "`order`='" . $db->escapeStr ($GLOBALS [ARG_BMCAT_ORDER]) . "' " ;
        $query .= "WHERE " ;
        $query .= "`id`='"  . $db->escapeStr ($GLOBALS [ARG_BMCAT_ID]) . "'" ;
        break ;

    case ACT_BMCAT_DEL :
        break ;

    default :
        break ;
    }

    $GLOBALS ['Trace']->Add ("SQL: " . $query) ;

    $ret = $db->query ($query) ;

    return $ret ;
}
?>

