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
 *  This class Stores application configuration.
 *  (The implementation follows the Singleton Pattern.)
 *
 *  @package    spMARKS
 *  @author     Sanjeev Premi
 *  @version    1.0
 */
class CSpConfig
{
    /*
     *  Instance variable
     */
    private static $_instance = null ;

    /*
     *  Trace object
     */
    private static $_trace = null ;

    /*
     *  Threshold for trace history.
     *  Number of page reloads for which the 'trace' information should be
     *  maintained.
     */
    private static $_history = 0 ;

    /*
     *  Title
     */
    private static $_title = null ;

    /*
     *  Meta Information
     */
    private static $_metaInfo = null ;

    /*
     *  Base URL
     */
    private static $_baseUrl = "" ;

    /*
     *  Language
     */
    private static $_language = null ;

    /*
     *  Theme
     */
    private static $_theme = null ;

    /*
     *  Database Information
     */
    private static $_DbName = "" ;
    private static $_DbHost = "" ;
    private static $_DbUser = "" ;
    private static $_DbPass = "" ;

    /*
     *  Restrict direct instantiation.
     *  Restore the object state from the session.
     */
    private function __construct()
    {
        if (isset ($_SESSION ['CONFIG']))
        {
            self::_loadSession () ;
        }
    }

    /*
     *  Save members in session variables before destruction.
     */
    public function __destruct ()
    {
        self::_saveSession () ;
    }

    /*
     *  Restrict object cloning
     */
    private function __clone ()
    {
    }

    public static function getInstance ()
    {
        if (is_null (self::$_instance))
        {
            self::$_instance = new self () ;
        }

        return self::$_instance ;
    }

    /**
     *  Set the CONFIG object
     */
    function setTrace (&$obj)
    {
        $this->_trace = $obj ;
    }

    /*
     *  Add a trace string
     */
    function addTrace ($str)
    {
        if ((defined ('__SP_TRACE')) &&  ($this->_trace != null)) {
            $this->_trace->add ("CSpConfig::" . $str) ;
        }
    }

    /*
     *  Get language
     */
    function getLanguage ()
    {
        return $this->_language ;
    }

    /*
     *  Get title
     */
    function getTitle ()
    {
        return $this->_title ;
    }

    /*
     *  Get theme
     */
    function getTheme ()
    {
        return $this->_theme ;
    }

    /*
     *  Get the stylesheets used
     */
    function getmetaInfo ()
    {
        return $this->_metaInfo ;
    }

    /*
     *  Get the base URL for application
     */
    function getBaseUrl ()
    {
        return $this->_baseUrl ;
    }

    /**
     *  Get database name.
     */
    function getDbName ()
    {
        return $this->_DbName ;
    }

    /**
     *  Get database host.
     */
    function getDbHost ()
    {
        return $this->_DbHost ;
    }

    /**
     *  Get database user.
     */
    function getDbUser ()
    {
        return $this->_DbUser ;
    }

    /**
     *  Get database user's password.
     */
    function getDbPass ()
    {
        return $this->_DbPass ;
    }

    function load ()
    {
        /*
         * TBD: These values should be read from the configuration file.
         *      This hard coding is okay for initial versions.
         */
        $this->_title    = 'BookMARKS' ;
        $this->_theme    = 'default' ;
        $this->_language = 'en' ;
        $this->_baseUrl  = 'http://localhost/test/bmark/' ;

        $this->_metaInfo = array (
                            'HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8"',
                            ) ;

        $this->_DbName   = "bookmarks" ;
        $this->_DbHost   = "localhost" ;
        $this->_DbUser   = "test" ;
        $this->_DbPass   = "testuser" ;

        return true ;
    }

    /**
     *  Save the state of this singleton object in session variables.
     *  TBD: The database password should not be stored in the session.
     *       For initial implementation it is okay. But should be changed
     *       before the application goes beta.
     */
    private static function _saveSession ()
    {
        if (empty ($_SESSION ['CONFIG']))
        {
            $_SESSION ['CONFIG'] = true ;

            $_SESSION [__CLASS__ . '_title']    = self::$_title ;
            $_SESSION [__CLASS__ . '_theme']    = self::$_theme ;
            $_SESSION [__CLASS__ . '_language'] = self::$_language ;
            $_SESSION [__CLASS__ . '_history']  = self::$_history ;

            $_SESSION [__CLASS__ . '_baseUrl']  = self::$_baseUrl ;

            $_SESSION [__CLASS__ . '_metaInfo'] = serialize (self::$_metaInfo) ;

            $_SESSION [__CLASS__ . '_DbName']   = self::$_DbName ;
            $_SESSION [__CLASS__ . '_DbHost']   = self::$_DbHost ;
            $_SESSION [__CLASS__ . '_DbUser']   = self::$_DbUser ;
            $_SESSION [__CLASS__ . '_DbPass']   = self::$_DbPass ;
        }
    }

    /**
     *  Restore the state of this singleton object from session variables.
     */
    private static function _loadSession ()
    {
        self::$_title       = $_SESSION [__CLASS__ . '_title'] ;
        self::$_theme       = $_SESSION [__CLASS__ . '_theme'] ;
        self::$_language    = $_SESSION [__CLASS__ . '_language'] ;
        self::$_history     = $_SESSION [__CLASS__ . '_history'] ;

        self::$_baseUrl     = $_SESSION [__CLASS__ . '_baseUrl'] ;

        self::$_metaInfo    = unserialize ($_SESSION [__CLASS__ . '_metaInfo']) ;

        self::$_DbName      = $_SESSION [__CLASS__ . '_DbName'] ;
        self::$_DbHost      = $_SESSION [__CLASS__ . '_DbHost'] ;
        self::$_DbUser      = $_SESSION [__CLASS__ . '_DbUser'] ;
        self::$_DbPass      = $_SESSION [__CLASS__ . '_DbPass'] ;

        /*
         *  Clear session variables to ensure that this function is
         *  not called again.
         */
        unset ($_SESSION [__CLASS__ . '_title']) ;
        unset ($_SESSION [__CLASS__ . '_theme']) ;
        unset ($_SESSION [__CLASS__ . '_language']) ;
        unset ($_SESSION [__CLASS__ . '_history']) ;

        unset ($_SESSION [__CLASS__ . '_baseUrl']) ;

        unset ($_SESSION [__CLASS__ . '_metaInfo']) ;

        unset ($_SESSION [__CLASS__ . '_DbName']) ;
        unset ($_SESSION [__CLASS__ . '_DbHost']) ;
        unset ($_SESSION [__CLASS__ . '_DbUser']) ;
        unset ($_SESSION [__CLASS__ . '_DbPass']) ;

        unset ($_SESSION ['CONFIG']) ;
    }
}

?>

