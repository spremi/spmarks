i{*  ============================================================================
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

{*  ============================================================================
 *  Static menu
 *  ============================================================================
 *}
<div id="pgMenu"">
  {strip}
  <a href="#" onclick="menuToggle('menuBm'); return false;">
  Bookmarks
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuToggle('menuCat'); return false;">
  Categories
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuToggle('menuUser'); return false;">
  Users
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuToggle('menuFilter'); return false;">
  Filters
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuToggle('menuHelp'); return false;">
  Help
  </a>
  {/strip}
</div>

{*  ============================================================================
 *  Menu : Bookmarks
 *  ============================================================================
 *}
<div id="menuBm" class="menuBox" style="display : none ;">
  <h2>Bookmarks</h2>
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_BMARK_LST}'); return false;">
  List (default)
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_BMARK_ADD}'); return false;">
  Add
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="return false;"> <!-- TBD -->
  Modify
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="return false;"> <!-- TBD -->
  Delete
  </a>
  {/strip}
</div>

<div id="menuCat" class="menuBox" style="display : none ;">
  <h2>Categories</h2>
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_BMCAT_LST}'); return false;">
  List
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_BMCAT_ADD}'); return false;">
  Add
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_BMCAT_MOD}'); return false;">
  Modify
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_BMCAT_DEL}'); return false;">
  Delete
  </a>
  {/strip}
</div>

<div id="menuUser" class="menuBox" style="display : none ;">
  <h2>Users</h2>
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_USER_LST}'); return false;">
  List
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_USER_ADD}'); return false;">
  Add
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_USER_MOD}'); return false;">
  Modify
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="menuAction ('{$smarty.const.ACT_USER_DEL}'); return false;">
  Delete
  </a>
  {/strip}
</div>

<div id="menuFilter" class="menuBox" style="display : none ;">
  <h2>Filters</h2>
  {strip}
  <a href="#" onclick="toggleDescription ('bm'); return false;">
  Toggle Bookmark Desc
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="toggleDescription ('cat'); return false;">
  Toggle Category Desc
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="return false;"> <!-- TBD -->
  Sort by title
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="return false;"> <!-- TBD -->
  Sort by order
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="return false;"> <!-- TBD -->
  Sort by visits
  </a>
  {/strip}
</div>

<div id="menuHelp" class="menuBox" style="display : none ;">
  <h2>Help</h2>
  {strip}
  <a href="#" onclick="toggleTrace (); return false;">
  Toggle Trace
  </a>
  {/strip}
  {strip}
  <a href="#" onclick="showContainer ('pgAbout'); return false;">
  About
  </a>
  {/strip}
</div>

