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
 *  Add/ Modify/ Delete a category
 *  ============================================================================
 *}
{if $action eq $smarty.const.ACT_BMCAT_ADD}
<h2>Add a category</h2>
{/if}
{if $action eq $smarty.const.ACT_BMCAT_MOD}
<h2>Modify a category</h2>
{/if}
{if $action eq $smarty.const.ACT_BMCAT_DEL}
<h2>Delete a category</h2>
{/if}

<form
{if $action eq $smarty.const.ACT_BMCAT_ADD}
  id      = "addCat"
{/if}
{if $action eq $smarty.const.ACT_BMCAT_MOD}
  id      = "modCat"
{/if}
{if $action eq $smarty.const.ACT_BMCAT_DEL}
  id      = "delCat"
{/if}
  action  = ""
  method  = "post">

  <input type="hidden" name="form" value="1" />
  <input type="hidden" name="act" value="{$action}" />
{if $action eq $smarty.const.ACT_BMCAT_MOD}
  <input type="hidden" name="{$smarty.const.ARG_BMCAT_ID}" value="{$selCategory.id}" />
{/if}

  <table>
    <tr>
      <td class="label">Name</td>
      <td class="value">
      <textarea name="catTitle" cols="50" rows="2">{strip}
{if $action eq $smarty.const.ACT_BMCAT_MOD}
{$selCategory.title}
{/if}
      {/strip}</textarea>
      </td>
    </tr>
    <tr>
      <td class="label">Description</td>
      <td class="value">
      <textarea name="catDesc" cols="50" rows="4">{strip}
{if $action eq $smarty.const.ACT_BMCAT_MOD}
{$selCategory.desc}
{/if}
      {/strip}</textarea>
      </td>
    </tr>
    <tr>
      <td class="label">Order</td>
      <td class="value">
      <input name="catOrder" value="{strip}
{if $action eq $smarty.const.ACT_BMCAT_MOD}
{$selCategory.order}
{/if}
{/strip}" />
      </td>
    </tr>
  </table>
</form>

<div class="button">
{if $action eq $smarty.const.ACT_BMCAT_ADD}
<a href="#" onclick="doForm('addCat'); return false;">ADD</a>
{/if}
{if $action eq $smarty.const.ACT_BMCAT_MOD}
<a href="#" onclick="doForm('modCat'); return false;">MODIFY</a>
{/if}
{if $action eq $smarty.const.ACT_BMCAT_DEL}
<a href="#" onclick="doForm('delCat'); return false;">DELETE</a>
{/if}
<a href="#" onclick="hideDialog (); return false;">CANCEL</a>
</div>

