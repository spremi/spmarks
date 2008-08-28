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

?>

