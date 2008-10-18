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

/**
 *  About the application
 */
define ('__APP_NAME',       'spMARKS') ;
define ('__APP_VERSION',    '0.80.00') ;

/**
 *  About the author
 */
define ('__AUTHOR_NAME',    'Sanjeev Premi') ;
define ('__AUTHOR_EMAIL',   'spremi@ymail.com') ;

/**
 *  Indicates successful completion of an operation.
 */
define ('SUCCESS', true) ;

/**
 *  Indicates unsuccessful completion of an operation.
 */
define ('FAILURE', false) ;

/**
 *  Trace flag. Set to true to enable trace.
 */
define ('__SP_TRACE', true) ;

/**
 *  Various browsers
 */
define ('BROWSER_FIREFOX',  'firefox') ;
define ('BROWSER_IE',       'ie') ;
define ('BROWSER_OPERA',    'opera') ;
define ('BROWSER_OTHER',    'other') ;

/**
 *  Various actions
 */
define ('ACT_NONE',         '') ;

define ('ACT_TRACE',        'trace') ;

define ('ACT_BMARK_LST',    'bm_lst') ;
define ('ACT_BMARK_ADD',    'bm_add') ;
define ('ACT_BMARK_MOD',    'bm_mod') ;
define ('ACT_BMARK_DEL',    'bm_del') ;

define ('ACT_BMCAT_LST',    'cat_lst') ;
define ('ACT_BMCAT_ADD',    'cat_add') ;
define ('ACT_BMCAT_MOD',    'cat_mod') ;
define ('ACT_BMCAT_DEL',    'cat_del') ;

define ('ACT_USER_LST',     'usr_lst') ;
define ('ACT_USER_ADD',     'usr_add') ;
define ('ACT_USER_MOD',     'usr_mod') ;
define ('ACT_USER_DEL',     'usr_del') ;

/**
 *  Sort order
 */
define ('ARG_SORT',         'sort') ;
define ('ARG_SORT_ASC',     'asc') ;
define ('ARG_SORT_DES',     'des') ;

/**
 *  Sort keys
 */
define ('ARG_KEY',          'key') ;
define ('KEY_ID',           'id') ;
define ('KEY_NAME',         'name') ;
define ('KEY_DATE',         'date') ;
define ('KEY_VISITS',       'visits') ;

/**
 *  Other GET/POST variables
 */
define ('ARG_BMARK_ID',     'bmId') ;
define ('ARG_BMARK_CAT',    'bmCat') ;
define ('ARG_BMARK_TITLE',  'bmTitle') ;
define ('ARG_BMARK_URL',    'bmUrl') ;
define ('ARG_BMARK_DESC',   'bmDesc') ;
define ('ARG_BMARK_ORDER',  'bmOrder') ;
define ('ARG_BMARK_FAV',    'bmFav') ;

define ('ARG_BMCAT_ID',     'catId') ;
define ('ARG_BMCAT_TITLE',  'catTitle') ;
define ('ARG_BMCAT_DESC',   'catDesc') ;
define ('ARG_BMCAT_ORDER',  'catOrder') ;

/**
 *  Messages corresponding to successful execution.
 */
$GLOBALS ['MsgSuccess'] = array (
            ACT_BMARK_LST => 'Successfully listed the bookmarks.',
            ACT_BMARK_ADD => 'Successfully added new bookmark.',
            ACT_BMARK_MOD => 'Successfully updated the bookmark.',
            ACT_BMARK_DEL => 'Successfully deleted the bookmark.',

            ACT_BMCAT_LST => 'Successfully listed the categories.',
            ACT_BMCAT_ADD => 'Successfully added new category.',
            ACT_BMCAT_MOD => 'Successfully updated the category.',
            ACT_BMCAT_DEL => 'Successfully deleted the category.',

            ACT_USER_LST  => 'Successfully listed the users.',
            ACT_USER_ADD  => 'Successfully added new user.',
            ACT_USER_MOD  => 'Successfully updated the user.',
            ACT_USER_DEL  => 'Successfully deleted the user.',
    ) ;

/**
 *  Messages corresponding to unsuccessful execution.
 */
$GLOBALS ['MsgFailure'] = array (
            ACT_BMARK_LST => 'Unable to list the bookmarks.',
            ACT_BMARK_ADD => 'Unable to add new bookmark.',
            ACT_BMARK_MOD => 'Unable to update the bookmark.',
            ACT_BMARK_DEL => 'Unable to delete the bookmark.',

            ACT_BMCAT_LST => 'Unable to list the categories.',
            ACT_BMCAT_ADD => 'Unable to add new category.',
            ACT_BMCAT_MOD => 'Unable to update the category.',
            ACT_BMCAT_DEL => 'Unable to delete the category.',

            ACT_USER_LST  => 'Unable to list the users.',
            ACT_USER_ADD  => 'Unable to add new user.',
            ACT_USER_MOD  => 'Unable to update the user.',
            ACT_USER_DEL  => 'Unable to delete the user.',
    ) ;

?>

