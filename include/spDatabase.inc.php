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
 *  This class implements the database functions required by the application.
 *
 *  @package    spMARKS
 *  @author     Sanjeev Premi
 *  @version    1.0
 */
class CSpDatabase
{
    /*
     *  Name of the database
     */
    private $_dbName = "" ;

    /*
     *  Name of the host
     */
    private $_dbHost = "" ;

    /*
     *  Name of user with necessary privileges on the database
     */
    private $_dbUser = "" ;

    /*
     *  Password of the user
     */
    private $_dbPass = "" ;

    /*
     *  The MySQLi object
     */
    private $_dbObj = null ;

    /*
     *  The result object returned by previous MuSQLi query
     */
    private $_dbResult = null ;

    /*
     *  Number of rows impacted by previous MuSQLi query
     */
    private $_rowsImpacted = 0 ;

    /*
     *  Trace object
     */
    private $_trace = null ;


    function CSpDatabase ()
    {
    }

    /**
     *  Create the URL for database used.
     */
    function init ($user, $pass, $host, $dbase)
    {
        $retval = true ;

        /*
         *  Initialize trace object
         */
        if (defined ('__SP_TRACE')) {
            $this->_trace = CSpTrace::getInstance () ;
        }

        $this->addTrace (__FUNCTION__) ;

        $this->_dbHost = $host  ;
        $this->_dbUser = $user  ;
        $this->_dbPass = $pass  ;
        $this->_dbName = $dbase ;

        $this->_dbObj = new mysqli ($this->_dbHost,
                                    $this->_dbUser,
                                    $this->_dbPass,
                                    $this->_dbName) ;

        if (mysqli_connect_errno ()) {
            $this->addTrace ("[" . mysqli_connect_error () . "] " .
                             mysqli_connect_error ()) ;

            $retval = false ;
        }

        return $retval ;
    }

    /**
     *  Close the MySQLi connection.
     */
    function close ()
    {
        $this->_dbObj->close () ;
    }

    /**
     *  Execute MySQLi query.
     */
    function query ($sql)
    {
        $retval = true ;

        $this->addTrace (__FUNCTION__) ;

        $this->_dbResult = $this->_dbObj->query ($sql, MYSQLI_USE_RESULT) ;

        if (is_bool ($this->_dbResult)) {
            $retval = $this->_dbResult ;

            if ($retval === true)
                $this->addTrace ("Query returned success.") ;
            else {
                $this->addTrace ("Query returned failure.") ;
                $this->addTrace ("[" . $this->_dbObj->error . "]") ;
            }
        }
        elseif (is_object ($this->_dbResult)) {
            $this->addTrace ("Query returned an object.") ;
        }
        else {
            $retval = false ;

            $this->addTrace ("[" . $this->_dbObj->error . "]") ;
        }

        return $retval ;
    }

    /**
     *  Returns number of rows affected by previous query.
     */
    function getAffectedRows ()
    {
        $retval = -1 ;

        $this->addTrace (__FUNCTION__) ;

        if (is_object ($this->_dbResult)) {
            $retval = $this->_dbObj->affected_rows ;
        }

        return $retval ;
    }

    /**
     *  Return an row from saved result set.
     */
    function nextRow ()
    {
        $retval = false ;

        $this->addTrace (__FUNCTION__) ;

        if (is_object ($this->_dbResult)) {
            $retval = $this->_dbResult->fetch_object () ;
        }

        return $retval ;
    }

    /**
     *  Frees the saved result set.
     */
    function flush ()
    {
        if (is_object ($this->_dbResult)) {
            $this->_dbResult->close () ;
        }
    }

    /**
     *  Escapes the specified string.
     */
    function escapeStr ($s)
    {
        $retStr = $this->_dbObj->real_escape_string ($s) ;

        return $retStr ;
    }

    /**
     *  Checks if specified table exists in the database.
     */
    function tableExists ($table)
    {
        $found = false ;

        $this->addTrace (__FUNCTION__) ;

        $result = $this->query ("SHOW TABLES;") ;

        if ($result === true) {
            while (   ($found == false)
                   && ($arr = $this->_dbResult->fetch_array (MYSQLI_NUM))) {

                if ($arr [0] === $table)
                    $found = true ;
            }

            $this->flush () ;
        }

        return $found ;
    }

    /*
     *  Add a trace string
     */
    function addTrace ($str)
    {
        if ((defined ('__SP_TRACE')) &&  ($this->_trace != null)) {
            $this->_trace->add ("CSpDatabase::" . $str) ;
        }
    }
}

?>

