{*  ============================================================================
 *  spMARKS
 *
 *  A Web 2.0 Bookmark Management System
 *  ============================================================================
 *  The MIT License
 *
 *  Copyright (c) 2008 Sanjeev Premi <spremi@ymail.com>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to
 *  deal in the Software without restriction, including without limitation the
 *  rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 *  sell copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 *  FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 *  IN THE SOFTWARE.
 *  ============================================================================
 *}
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    xmlns    = "http://www.w3.org/1999/xhtml"
    xml:lang = "{$cfg->getLanguage()}"
    lang     = "{$cfg->getLanguage()}">
<head>
{*  ============================================================================
 *  Meta information
 *  ============================================================================
 *}
{foreach
  from  = $cfg->getMetaInfo()
  item  = m}
<meta {$m} />
{/foreach}

{*  ============================================================================
 *  Title
 *  ============================================================================
 *}
<title>{$cfg->getTitle()}</title>

{*  ============================================================================
 *  Base
 *  ============================================================================
 *}
<base
    href = "{$cfg->getBaseUrl()}" />

{*  ============================================================================
 *  Stylesheet(s)
 *  ============================================================================
 *}
{foreach
  from  = $theme->getStyleSheets()
  item  = ss}
<link
    rel     = "stylesheet"
    type    = "text/css"
    href    = "{$theme->getDir()}/{$ss}" />

{/foreach}

{*  ============================================================================
 *  Javascript(s)
 *  ============================================================================
 *}
{if count ($theme->getJsExtern())}
<!-- External -->
  {foreach
    from  = $theme->getJsExtern()
    item  = js}
<script
    type    = "text/javascript"
    src     = "{$js}">
</script>
  {/foreach}
{/if}

{if count ($theme->getJsLocal())}
<!-- Local -->
  {foreach
    from  = $theme->getJsLocal()
    item  = js}
<script
    type    = "text/javascript"
    src     = "./scripts/{$js}">
</script>
  {/foreach}
{/if}

<!-- Application -->
<script
    type    = "text/javascript"
    src     = "script/spAjax.js">
</script>

{if count ($theme->getJsTheme())}
<!-- Theme -->
  {foreach
    from  = $theme->getJsTheme()
    item  = js}
<script
    type    = "text/javascript"
    src     = "{$theme->getDir()}/scripts/{$js}">
</script>
  {/foreach}
{/if}


{*  ============================================================================
 *  Fix PNG transparency issue.
 *  (Source: http://homepage.ntlworld.com/bobosola/pngtest.htm)
 *  ============================================================================
 *}
{if $browser eq "ie"}
<!--[if lt IE 7.]>
<script
    defer
    type    = "text/javascript"
    src     = "{$theme->getDir()}/pngfix.js">
</script>
<![endif]-->
{/if}
</head>

<body>
{*  ============================================================================
 *  Page header
 *  ============================================================================
 *}
<div id="pgHead">
{include
  file  = "pgHeader.tpl"}
</div>

{*  ============================================================================
 *  Menu
 *  ============================================================================
 *}
{include
  file  = "pgMenu.tpl"}

{*  ============================================================================
 *  Placeholder for categories
 *  ============================================================================
 *}
<div id="pgCategories" style="display : none ;">
</div>
 
{*  ============================================================================
 *  Page body
 *  ============================================================================
 *}

<div id="pgBookmarks">
Fetching bookmarks. Please wait...
</div>

{*  ============================================================================
 *  Placeholder for dialog boxes
 *  ============================================================================
 *}
<div id="pgDialog" style="display : none ;">
</div>

<div id="pgMessage" style="display : none ;">
</div>

{*  ============================================================================
 *  Page footer
 *  ============================================================================
 *}
<div id="pgFoot">
{include
  file  = "pgFooter.tpl"}
</div>

{*  ============================================================================
 *  Placeholder for trace
 *  ============================================================================
 *}
<div id="pgTrace" style="display : none ;">
</div>

{*  ============================================================================
 *  About
 *  ============================================================================
 *}
<div id="pgAbout" style="display : none ;">
{include
  file  = "dlgAbout.tpl"}
</div>

</body>
</html>
