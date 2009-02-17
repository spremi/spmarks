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


//  ============================================================================
//  Prevent direct access
//  ============================================================================
defined ('__SP__MARKS__') or die (
    '<h1>NO ENTRY</h1>' .
    '<p>You have tried to access restricted area.</p>'
    ) ;


/**
 *  This class encapsulates the overall application.
 *
 *  @package    spMARKS
 *  @author     Sanjeev Premi
 *  @version    1.0
 */
class CSpApplication
{
    /**
     *  Configuration information
     */
    private $_cfg = null ;

    /**
     *  Database object
     */
    private $_db = null ;

    /**
     *  Theme
     */
    private $_theme = null ;

    /**
     *  Current action (thru GET/POST)
     */
    private $_action = "" ;

    /**
     *  Result of AJAX command - success / failure.
     */
    private $_ajaxResult = null ;

    /**
     *  Verbose message in response to AJAX request
     */
    private $_ajaxMessage = null ;

    /**
     *  Trace object
     */
    private $_trace = null ;


    /**
     * Constructor
     */
    function CSpApplication ()
    {
    }

    /**
     * Initialize trace object.
     */
    private function _initTrace ()
    {
        if (defined ('__SP_TRACE')) {
            $this->_trace = CSpTrace::getInstance () ;
        }
    }

    /**
     * Initialize configuration object.
     */
    private function _initConfig ()
    {
        $retval = true ;

        $this->addTrace (__FUNCTION__) ;

        $this->_cfg = CSpConfig::getInstance () ;

        if (is_null ($this->_cfg)) {
            $retval = false ;

            $this->addTrace ('ERR: Unable to access configuration object.') ;
        }
        else {
            $retval = $this->_cfg->load () ;

            if ($retval == false) {
                $this->addTrace ('ERR: Unable to load configuration.') ;
            }
        }

        return $retval ;
    }

    /**
     * Initialize theme.
     */
    private function _initTheme ()
    {
        $retval = true ;

        $this->addTrace (__FUNCTION__) ;

        $this->_theme = CSpTheme::getInstance () ;

        if (is_null ($this->_theme)) {
            $retval = false ;

            $this->addTrace ('ERR: Unable to create theme object.') ;
        }
        else {
            $retval = $this->_theme->init (__SP_USE_THEME) ;

            if ($retval == false) {
                $this->addTrace ('ERR: Unable to initialize theme.') ;
            }
        }

        return $retval ;
    }

    /**
     * Initialize Smarty template engine.
     */
    private function _initSmarty ()
    {
        $retval = true ;

        $this->addTrace (__FUNCTION__) ;

        $this->_theme->assignVar  ('trace', $this->_trace) ;
        $this->_theme->assignVar  ('cfg',   $this->_cfg) ;
        $this->_theme->assignVar  ('theme', $this->_theme) ;

        $this->_theme->assignVar  ('action', $this->_action) ;

        $this->_theme->assignVar  ('arrCategories', $GLOBALS ['ArrCategories']) ;
        $this->_theme->assignVar  ('arrBookmarks',  $GLOBALS ['ArrBookmarks']) ;

        $this->_theme->assignVar  ('curCategory',   $GLOBALS ['CurCategory']) ;

        $this->_theme->assignVar  ('selCategory',   $GLOBALS ['SelCategory']) ;
        $this->_theme->assignVar  ('selBookmark',   $GLOBALS ['SelBookmark']) ;

        /*
         *  AJAX variables
         */
        $this->_theme->assignVar  ('ajaxResult',  $this->_ajaxResult) ;
        $this->_theme->assignVar  ('ajaxMessage', $this->_ajaxMessage) ;

        return $retval ;
    }

    /**
     * Initialize database.
     */
    private function _initDatabase ()
    {
        $retval = true ;

        $this->addTrace (__FUNCTION__) ;

        $this->_db =& new CSpDatabase () ;

        if (is_null ($this->_db)) {
            $retval = false ;

            $this->addTrace ('ERR: Unable to create database object.') ;
        }
        else {
            $retval = $this->_db->init (
                                   $this->_cfg->getDbUser (),
                                   $this->_cfg->getDbPass (),
                                   $this->_cfg->getDbHost (),
                                   $this->_cfg->getDbName ()) ;

            if ($retval == false) {
                $this->addTrace ('ERR: Unable to initialize database.') ;
            }
        }

        return $retval ;
    }

    /**
     * Initialize all necessary members. Also set the 'invariant' flag.
     */
    function init ()
    {
        $retval = true ;

        $this->_initTrace () ;

        $retval = $this->_initConfig () ;

        if ($retval == true) {
            $retval = $this->_initTheme () ;
        }

        if ($retval) {
            $retval = $this->_initSmarty () ;
        }

        if ($retval) {
            $retval = $this->_initDatabase () ;
        }

        return $retval ;
    }

    /**
     *  Perform necessary cleanup
     */
    function close ()
    {
        $this->_db->close () ;
    }

    /*
     *  Act on the requested operation
     */
    function act ($act, $post)
    {
        $this->addTrace (__FUNCTION__) ;

        $this->_action = $act ;

        switch ($act)
        {
        case ACT_TRACE :
            $this->addTrace ('Send application trace.') ;

            if ($this->_trace != null) {
                $this->_theme->render ('pgTrace.tpl')  ;

                $this->_trace->flush () ;
            }
            break ;

        case ACT_BMARK_LST :
            $this->_listBookmarks () ;
            break ;

        case ACT_BMARK_ADD :
        case ACT_BMARK_MOD :
        case ACT_BMARK_DEL :
            $this->_editBookmark ($post) ;
            break ;

        case ACT_BMCAT_LST :
            $this->_listCategories () ;
            break ;

        case ACT_BMCAT_ADD :
        case ACT_BMCAT_MOD :
        case ACT_BMCAT_DEL :
            $this->_editCategory ($post) ;
            break ;

        default :
            $this->_theme->render ('pgMain.tpl')  ;
            break ;
        }

        if ($post) {
            if ($this->_ajaxResult === true)
            {
                $this->_ajaxMessage = $GLOBALS ['MsgSuccess'][$this->_action] ;
            }
            else
            {
                $this->_ajaxMessage = $GLOBALS ['MsgFailure'][$this->_action] ;
            }

            $this->_theme->render ('dlgResult.tpl')  ;
        }
    }

    /*
     *  Add trace string
     */
    function addTrace ($str)
    {
        if ((defined ('__SP_TRACE')) &&  ($this->_trace != null)) {
            $this->_trace->add ('CSpApplication::' . $str) ;
        }
    }

    /*
     *  List bookmarks
     */
    function _listBookmarks ()
    {
        require_once ('./include/spCategory.inc.php') ;
        require_once ('./include/spBookmark.inc.php') ;

        if (isset ($_GET [ARG_BMARK_CAT])) {
            $GLOBALS ['CurCategory'] = $_GET [ARG_BMARK_CAT] ;
        }

        getCategory ($this->_db, $GLOBALS ['CurCategory']) ;


        $result = listBookmarks ($this->_db) ;

        $this->_theme->render ('lstBm.tpl')  ;
    }

    /*
     *  List categories
     */
    function _listCategories ()
    {
        require_once ('./include/spCategory.inc.php') ;

        listCategories ($this->_db) ;

        $this->_theme->render ('lstCat.tpl')  ;
    }

    /*
     *   Edit (add/modify/delete) a bookmark
     */
    function _editBookmark ($post)
    {
        $retval = true ;

        require_once ('./include/spCategory.inc.php') ;
        require_once ('./include/spBookmark.inc.php') ;

        if ($post) {
            $this->_ajaxResult = editBookmark ($this->_db, $this->_action) ;
        }
        else {
            listCategories ($this->_db) ;
	    if ($this->_action !== ACT_BMARK_ADD) {
                getBookmark ($this->_db, $GLOBALS [ARG_BMARK_ID]) ;
            }

            $this->_theme->render ('dlgBmEdit.tpl')  ;
        }
    }

    /*
     *  Edit (add/modify/delete) a category
     */
    function _editCategory ($post)
    {
        $retval = true ;

        require_once ('./include/spCategory.inc.php') ;

        if ($post) {
            $this->_ajaxResult = editCategory ($this->_db, $this->_action) ;
        }
        else {
	    if ($this->_action !== ACT_BMCAT_ADD) {
                getCategory ($this->_db, $GLOBALS [ARG_BMCAT_ID]) ;

            }

            $this->_theme->render ('dlgCatEdit.tpl')  ;
        }
    }
}
?>

