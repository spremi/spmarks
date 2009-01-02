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


//  ============================================================================
//  Define constants
//  ============================================================================

/**#@+
 *  Intallation steps
 */
define ('STEP_0',   '0') ;      // Welcome screen
define ('STEP_1',   '1') ;      // Basic Install information
define ('STEP_2',   '2') ;      // Database information
define ('STEP_3',   '3') ;      // Verify database access
define ('STEP_4',   '4') ;      // Populate database
define ('STEP_5',   '5') ;      // Done!
/**#@-*/


define ('ARG_STEP',         'step') ;

define ('ARG_DIR_APP',      'dirApp'   ) ;
define ('ARG_DIR_SMARTY',   'dirSmarty') ;
define ('ARG_USE_THEME',    'useTheme' ) ;

define ('ARG_DB_HOST',      'dbHost') ;
define ('ARG_DB_NAME',      'dbName') ;
define ('ARG_DB_USER',      'dbUser') ;
define ('ARG_DB_PASS',      'dbPass') ;
define ('ARG_DB_PORT',      'dbPort') ;

define ('ARG_RESULT',       'result') ;
define ('ARG_MESSAGE',      'message') ;

//  ============================================================================
//  Define globals
//  ============================================================================
$GLOBALS ['DirApp']     = null ;
$GLOBALS ['DirSmarty']  = null ;
$GLOBALS ['UseTheme']   = null ;

$GLOBALS ['DbHost']     = null ;
$GLOBALS ['DbName']     = null ;
$GLOBALS ['DbUser']     = null ;
$GLOBALS ['DbPass']     = null ;
$GLOBALS ['DbPort']     = null ;

$GLOBALS ['Text']       = "" ;

$GLOBALS ['Step']       = STEP_0 ;
$GLOBALS ['Result']     = SUCCESS ;
$GLOBALS ['Message']    = "" ;

//  ============================================================================
//  Begin
//  ============================================================================
session_start ();

/*
 *  Read POST arguments (if any)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST [ARG_STEP])) {
        $GLOBALS ['Step'] = $_POST [ARG_STEP] ;
    }

    switch ($GLOBALS ['Step']) {
    case STEP_1:
        if (isset($_POST [ARG_DIR_APP])) {
            $GLOBALS ['DirApp'] = urldecode ($_POST [ARG_DIR_APP]) ;
        }

        if (isset($_POST [ARG_DIR_SMARTY])) {
            $GLOBALS ['DirSmarty'] = urldecode ($_POST [ARG_DIR_SMARTY]) ;
        }

        if (isset($_POST [ARG_USE_THEME])) {
            $GLOBALS ['UseTheme'] = urldecode ($_POST [ARG_USE_THEME]) ;
        }
        break ;

    case STEP_2:
        if (isset($_POST [ARG_DB_HOST])) {
            $GLOBALS ['DbHost'] = urldecode ($_POST [ARG_DB_HOST]) ;
        }

        if (isset($_POST [ARG_DB_NAME])) {
            $GLOBALS ['DbName'] = urldecode ($_POST [ARG_DB_NAME]) ;
        }

        if (isset($_POST [ARG_DB_USER])) {
            $GLOBALS ['DbUser'] = urldecode ($_POST [ARG_DB_USER]) ;
        }

        if (isset($_POST [ARG_DB_PASS])) {
            $GLOBALS ['DbPass'] = urldecode ($_POST [ARG_DB_PASS]) ;
        }

        if (isset($_POST [ARG_DB_PORT])) {
            $GLOBALS ['DirApp'] = urldecode ($_POST [ARG_DB_PORT]) ;
        }
        break ;

    case STEP_3:
    case STEP_4:
        if (isset($_POST [ARG_RESULT])) {
            $GLOBALS ['Result'] = urldecode ($_POST [ARG_RESULT]) ;
        }

        if (isset($_POST [ARG_MESSAGE])) {
            $GLOBALS ['Message'] = urldecode ($_POST [ARG_MESSAGE]) ;
        }
        break ;

    case STEP_5:
        break ;
    }

}
?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    xmlns    = "http://www.w3.org/1999/xhtml"
    xml:lang = "en"
    lang     = "en">

<title>spMARKS Installation</title>

<base
    href = "index.html" />
    
<link
    rel     = "stylesheet"
    type    = "text/css"
    href    = "install.css" />
</head>

<body>
<h1>spMarks Installation</h1>
<h2>Step <?php echo $GLOBALS ['Step'] ; ?></h2>
<form method="post" action="index.php" >
<?php
$NextStep = STEP_0 ;

/*
 *  Step 0 : Welcome Screen
 */
if ($GLOBALS ['Step'] == STEP_0) {
    $NextStep = STEP_1 ;

?>
<h3>Welcome</h3>


<?php
}

/*
 *  Step 1 : Get basic install information
 */
elseif ($GLOBALS ['Step'] == STEP_1) {
    $NextStep = STEP_2 ;
?>
<h3>Basic Information</h3>

<?php
}

/*
 *  Step 2 : Get database information
 */
elseif ($GLOBALS ['Step'] == STEP_2) {
    $NextStep = STEP_3 ;
?>
<h3>Database Information</h3>


<?php
}

/*
 *  Step 3 : Verify database access
 */
elseif ($GLOBALS ['Step'] == STEP_3) {
    $NextStep = STEP_4 ;
?>
<h3>Verify Database access</h3>


<?php
}

/*
 *  Step 4 : Populate database
 */
elseif ($GLOBALS ['Step'] == STEP_4) {
    $NextStep = STEP_5 ;
?>
<h3>Populate Database</h3>


<?php
}

/*
 *  Step 5 : Done
 */
elseif ($GLOBALS ['Step'] == STEP_5) {
    $NextStep = STEP_0 ;
?>
<h3>Done</h3>


<?php

    session_destroy () ;
}
?>

<input type="hidden" name="<?php echo ARG_STEP ; ?>" value="<?php echo $NextStep ; ?>" />
<input type="submit" name="Submit" value="Next" />
</form>

</body>
</html>

<?php
//  ============================================================================
//  End
//  ============================================================================
exit (0) ;
?>

