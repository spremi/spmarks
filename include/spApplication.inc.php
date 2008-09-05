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

        $this->_theme->assignVar  ('arrCategories', $GLOBALS ['arrCategories']) ;
        $this->_theme->assignVar  ('arrBookmarks',  $GLOBALS ['arrBookmarks']) ;

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

        switch ($act)
        {
        case ACT_TRACE :
            if ($this->trace != null) {
                $this->trace->flush () ;
            }
            break ;

        case ACT_BMARK_LST :
            break ;

        case ACT_BMARK_ADD :
            break ;

        case ACT_BMARK_MOD :
            break ;

        case ACT_BMARK_DEL :
            break ;

        case ACT_BMCAT_LST :
            break ;

        case ACT_BMCAT_ADD :
            break ;

        case ACT_BMCAT_MOD :
            break ;

        case ACT_BMCAT_DEL :
            break ;

        default :
            break ;
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
}
?>

