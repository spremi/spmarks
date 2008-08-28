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
 *  This class implements the look-and-feel of the application.
 *  The themes are based on Smarty templates.
 *  (The implementation follows the Singleton Pattern.)
 *
 *  @package    spMARKS
 *  @author     Sanjeev Premi
 *  @version    1.0
 */
class CSpTheme
{
    /**
     *  Instance variable
     */
    private static $_instance = null ;

    /**
     *  Name
     */
    private $_name = null ;

    /**
     *  Directory
     */
    private $_dir = null ;

    /**
     *  Stylesheet(s) used
     */
    private $_styleSheets = array () ;

    /**
     *  External Javascript(s) used.
     *  This allows users to use javascripts already deployed on their websites
     *  without requiring explicit copy e.g. prototype.js and scriptaculous.
     */
    private $_jsExtern = array () ;

    /**
     *  Local Javascript(s) used
     *  These javascripts are contained in the theme.
     */
    private $_jsLocal = array () ;

    /**
     *  Instance of the smarty template system.
     */
    private $_tpl = null ;

    /**
     *  Trace object
     */
    private $_trace = null ;

    /**
     *  User's browser
     */
    private $_browser = null ;

    /*
     *  Restrict instantiation
     */
    private function __construct ()
    {
    }

    /*
     *  Restrict object cloning
     */
    protected function __clone ()
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
     *  Actual initilization of theme object
     */
    public function init ($theme)
    {
        $retval = true ;

        /*
         *  Initialize trace object
         */
        if (defined ('__SP_TRACE')) {
            $this->trace = CSpTrace::getInstance () ;
        }

        $this->addTrace (__FUNCTION__) ;

        /*
         *  Detect the browser type
         */
        if (strpos ($_SERVER["HTTP_USER_AGENT"], 'Mozilla') == true) {
            $this->_browser = BROWSER_FIREFOX ;
        }
        else if (strpos ($_SERVER["HTTP_USER_AGENT"], 'MSIE') == true) {
            $this->_browser = BROWSER_IE ;
        }
        else if (strpos ($_SERVER["HTTP_USER_AGENT"], 'Opera') == true) {
            $this->_browser = BROWSER_OPERA ;
        }
        else {
            $this->_browser = BROWSER_OTHER ;
        }

        /*
         *  Load information from specified theme
         */
        $this->addTrace ('Load information from the theme.') ;
        
        if (is_dir ('./themes/' . $theme)) {
            if (is_file ('./themes/' . $theme . '/theme.inc.php')) {
                require_once ('./themes/' . $theme . '/theme.inc.php') ;
            }
            else {
                $retval = false ;

                $this->addTrace ('Theme - ' . $theme .
                                 ' - does not publish necessary interface.') ;
            }
        }
        else {
            $retval = false ;

            $this->addTrace ('Theme - ' . $theme . ' - does not exist.') ;
        }

        /*
         *  Initialize Smarty template engine
         */
        $this->addTrace ('Create Smarty object.') ;

        $this->_tpl =& new Smarty () ;

        if (is_null ($this->_tpl)) {
            $retval = false ;

            $this->addTrace ('ERR: Unable to create a Smarty object.') ;
        }
        else {
            $this->_tpl->template_dir = $this->_dir . '/templates' ;
            $this->_tpl->compile_dir  = $this->_dir . '/templates_c' ;
            $this->_tpl->config_dir   = $this->_dir . '/configs' ;
            $this->_tpl->cache_dir    = $this->_dir . '/cache' ;
        }

        return $retval ;
    }

    /**
     *  Get name of the theme
     */
    function getName ()
    {
        return $this->_name ;
    }

    /**
     *  Set name of the theme
     */
    function setName ($arg)
    {
        $this->_name = $arg ;
    }

    /**
     *  Get relative path to theme directory
     */
    function getDir ()
    {
        return $this->_dir ;
    }

    /**
     *  Set relative path to theme directory
     */
    function setDir ($arg)
    {
        $this->_dir = './themes/' . $arg  . '/' ;
    }

    /**
     *  Get the stylesheets used
     */
    function getStyleSheets ()
    {
        return $this->_styleSheets ;
    }

    /**
     *  Set the stylesheets used
     */
    function setStyleSheets ($arg)
    {
        $this->_styleSheets = $arg ;
    }

    /**
     *  Get external java scripts used
     */
    function getJsExtern ()
    {
        return $this->_jsExtern ;
    }

    /**
     *  Set external java scripts used
     */
    function setJsExtern ($arg)
    {
        $this->_jsExtern = $arg ;
    }

    /**
     *  Get local java scripts used
     */
    function getJsLocal ()
    {
        return $this->_jsLocal ;
    }

    /**
     *  Set local java scripts used
     */
    function setJsLocal ($arg)
    {
        $this->_jsLocal = $arg ;
    }

    /**
     *  Set the trace object
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
        if ($this->_trace != null)  {
            $this->_trace->add ("CSpTheme::" . $str) ;
        }
    }

    /**
     *  Assign (only by reference) PHP variables to Smarty template engine.
     */
    function assignVar ($tag, &$obj)
    {
        $this->_tpl->assign_by_ref ($tag, $obj) ;
    }

    /**
     *  Render the smarty template
     */
    function render ($template)
    {
        $this->addTrace (__FUNCTION__) ;

        $this->_tpl->display ($template) ;
    }
}

?>

