i<?php
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
 *  This class provides trace capabilities for the application.
 *  (The implementation follows the Singleton Pattern.)
 *  TBD: Link the implementation with definition of __SP_TRACE.
 *
 *  @package    spMARKS
 *  @author     Sanjeev Premi
 *  @version    1.0
 */
class CSpTrace
{
    /**
     *  Instance variable
     */
    private static $_instance = null ;

    /**
     *  Count of the log statements.
     */
    private static $_count = 0 ;

    /**
     *  Threshold to maintain trace history.
     *  TBD: Not yet implemented.
     */
    private static $_threshold = 0 ;

    /**
     *  An array that stores the trace statements until it is flushed.
     */
    private static $_cache = array () ;


    /*
     *  Restrict direct instantiation.
     *  Restore the object state from the session.
     */
    private function __construct ()
    {
        if (isset ($_SESSION ['TRACE']))
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

    /**
     *  Create an instance of this class
     */
    static public function getInstance ()
    {
        if (is_null (self::$_instance)) {
            self::$_instance = new self () ;
        }

        return self::$_instance ;
    }

    /**
     *  Add string to the trace cache
     */
    static function add ($str)
    {
        // print "... [" . self::$_count . "] " . $str . "<br />" ;

        self::$_cache[] = $str ;
        self::$_count++ ;
    }

    /**
     *  Returns count of trace statements in the cache
     */
    public function count ()
    {
        $num = self::$_count ;

        return $num ;
    }

    /**
     *  Export contents of trace cache
     */
    static function export ()
    {
        $arr = self::$_cache ;

        return $arr ;
    }

    /**
     *  Flush the trace cache
     */
    static function flush ()
    {
        self::$_cache = array () ;
        self::$_count = 0 ;
    }

    /**
     *  Save the state of this singleton object in session variables.
     */
    private static function _saveSession ()
    {
        if (empty ($_SESSION ['TRACE']))
        {
            $_SESSION ['TRACE'] = true ;

            $_SESSION [__CLASS__ . '_count'] = self::$_count ;
            $_SESSION [__CLASS__ . '_cache'] = self::$_cache ;
        }
    }

    /**
     *  Restore the state of this singleton object from session variables.
     */
    private static function _loadSession ()
    {
        self::$_count = $_SESSION [__CLASS__ . '_count'] ;
        self::$_cache = $_SESSION [__CLASS__ . '_cache'] ;

        /*
         *  Clear session variables to ensure that this function is
         *  not called again.
         */
        unset ($_SESSION [__CLASS__ . '_count']) ;
        unset ($_SESSION [__CLASS__ . '_cache']) ;

        unset ($_SESSION ['TRACE']) ;

        /*
         *  Add divider between sessions
         */
        self::$_cache [] = "::::::::::::::::::::::::::::::::::::::::" ;
    }
}

?>

