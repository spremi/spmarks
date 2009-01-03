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

{*  ============================================================================
 *  Add/ Modify/ Delete a bookmark
 *  ============================================================================
 *}
{if $action eq $smarty.const.ACT_BMARK_ADD}
<h2>Add a bookmark</h2>
{/if}
{if $action eq $smarty.const.ACT_BMARK_MOD}
<h2>Modify a bookmark</h2>
{/if}
{if $action eq $smarty.const.ACT_BMARK_DEL}
<h2>Delete a bookmark</h2>
{/if}

<form
{if $action eq $smarty.const.ACT_BMARK_ADD}
  id      = "addBm"
{/if}
{if $action eq $smarty.const.ACT_BMARK_MOD}
  id      = "modBm"
{/if}
{if $action eq $smarty.const.ACT_BMARK_DEL}
  id      = "delBm"
{/if}
  action  = "#"
  method  = "post">

  <input type="hidden" name="form" value="1" />
  <input type="hidden" name="act" value="{$action}" />
{if $action eq $smarty.const.ACT_BMARK_MOD}
  <input type="hidden" name="{$smarty.const.ARG_BMARK_ID}" value="{$selBookmark.id}" />
{/if}

  <table>
    <tr>
      <td class="label">Category</td>
      {$cat.title}
      <td class="value">
        <select name="bmCat">
        {foreach
          item  = cat
          from  = $arrCategories}
          <option label="{$cat.title}" value="{$cat.id}"{strip}
{if $cat.id eq $selBookmark.catId}
          selected="selected"
{/if}
          {/strip}>{$cat.title}</option>
          {/foreach}
        </select>
      </td>
    </tr>
    <tr>
      <td class="label">Title</td>
      <td class="value">
      <textarea name="bmTitle" cols="50" rows="2">{strip}
{if $action eq $smarty.const.ACT_BMARK_MOD}
{$selBookmark.title}
{/if}
      {/strip}</textarea>
      </td>
    </tr>
    <tr>
      <td class="label">Description</td>
      <td class="value">
      <textarea name="bmDesc" cols="50" rows="4">{strip}
{if $action eq $smarty.const.ACT_BMARK_MOD}
{$selBookmark.desc}
{/if}
      {/strip}</textarea>
      </td>
    </tr>
    <tr>
      <td class="label">URL</td>
      <td class="value">
      <textarea name="bmUrl" cols="50" rows="2">{strip}
{if $action eq $smarty.const.ACT_BMARK_MOD}
{$selBookmark.link}
{/if}
      {/strip}</textarea>
      </td>
    </tr>
  </table>
</form>

<div class="button">
{if $action eq $smarty.const.ACT_BMARK_ADD}
<a href="#" onclick="doForm('addBm'); return false;">ADD</a>
{/if}
{if $action eq $smarty.const.ACT_BMARK_MOD}
<a href="#" onclick="doForm('modBm'); return false;">MODIFY</a>
{/if}
{if $action eq $smarty.const.ACT_BMARK_DEL}
<a href="#" onclick="doForm('delBm'); return false;">DELETE</a>
{/if}
<a href="#" onclick="hideDialog (); return false;">CANCEL</a>
</div>

