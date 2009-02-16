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
<div class="close">
  <a href="#" onclick="hideContainer ('pgCategories'); return false;">X</a>
</div>

<h2>Categories</h2>

<ul>
  {foreach
    item  = cat
    from  = $arrCategories}
  <li>
  <a class="mod" style="display : none ;" href="#" onclick="doButton ('cat_mod', '{$cat.id}'); return false;">MOD</a>
  <a class="del" style="display : none ; "href="#" onclick="doButton ('cat_del', '{$cat.id}'); return false;">DEL</a>
  <a href="#" onclick="selCategory ('{$cat.id}'); return false;">{$cat.title}</a>
  <p class="desc">{$cat.desc}</p>
  </li>
  {/foreach}
</ul>

