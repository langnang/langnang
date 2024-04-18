   <div class="book-summary">
     <div class="book-search">
       <input type="text" placeholder="Type to search" class="form-control" />
     </div>
     <ul class="summary">
       <li>
         <a href="javascript:if(confirm('http://www.duxcms.com/  \n\nThis file was not retrieved by Teleport Pro, because it is addressed on a domain or path outside the boundaries set for its Starting Address.  \n\nDo you want to open it from the server?'))window.location='http://www.duxcms.com/'" tppabs="http://www.duxcms.com/" target="blank" class="custom-link">DuxCms官网</a>
       </li>
       <li class="divider"></li>
       <li class="chapter active" data-level="0" data-path="index.html">
         <a href="index.html" tppabs="http://doc.duxcms.com/index.html">
           <i class="fa fa-check"></i> {{$menu['title']}}
         </a>
       </li>
       @foreach ($menu['children'] as $item)
       <li class="chapter" data-level="1" data-path="function.html">
         <a href="function.html" tppabs="http://doc.duxcms.com/function.html">
           <i class="fa fa-check"></i> <b>{{$loop->index + 1}}.</b> {{$item['title']}}
         </a>
         @if (isset($item['children']) && count($item['children']) > 0)
         <ul class="articles">
           @foreach ($item['children'] as $sub)
           <li class="chapter " data-level="3.1" data-path="tplbase/structure.html">
             <a href="{{$sub.slug}}" tppabs="http://doc.duxcms.com/tplbase/structure.html">
               <i class="fa fa-check"></i> <b>{{$loop->parent->index + 1}}.{{$loop->index + 1}}.</b> {{$sub['title']}}
             </a>
           </li>
           @endforeach
         </ul>
         @endif
       </li>
       @endforeach
       <li class="chapter " data-level="1" data-path="function.html">
         <a href="function.html" tppabs="http://doc.duxcms.com/function.html">
           <i class="fa fa-check"></i> <b>1.</b> 安装与环境
         </a>
       </li>
       <li class="chapter " data-level="2" data-path="copyright.html">
         <a href="copyright.html" tppabs="http://doc.duxcms.com/copyright.html">
           <i class="fa fa-check"></i> <b>2.</b> 版权协议
         </a>
       </li>
       <li class="chapter " data-level="3" data-path="tplbase/info.html">
         <a href="info.html" tppabs="http://doc.duxcms.com/tplbase/info.html">
           <i class="fa fa-check"></i> <b>3.</b> 模板基础
         </a>
         <ul class="articles">
           <li class="chapter " data-level="3.1" data-path="tplbase/structure.html">
             <a href="structure.html" tppabs="http://doc.duxcms.com/tplbase/structure.html">
               <i class="fa fa-check"></i> <b>3.1.</b> 目录与结构说明
             </a>
           </li>
           <li class="chapter " data-level="3.2" data-path="tplbase/base.html">
             <a href="base.html" tppabs="http://doc.duxcms.com/tplbase/base.html">
               <i class="fa fa-check"></i> <b>3.2.</b> 基础标签格式
             </a>
           </li>
           <li class="chapter " data-level="3.3" data-path="tplbase/system.html">
             <a href="system.html" tppabs="http://doc.duxcms.com/tplbase/system.html">
               <i class="fa fa-check"></i> <b>3.3.</b> 系统信息调用
             </a>
           </li>
           <li class="chapter " data-level="3.4" data-path="tplbase/logic.html">
             <a href="logic.html" tppabs="http://doc.duxcms.com/tplbase/logic.html">
               <i class="fa fa-check"></i> <b>3.4.</b> 判断与循环
             </a>
           </li>
           <li class="chapter " data-level="3.5" data-path="tplbase/function.html">
             <a href="function-1.html" tppabs="http://doc.duxcms.com/tplbase/function.html">
               <i class="fa fa-check"></i> <b>3.5.</b> 数据函数处理
             </a>
           </li>
           <li class="chapter " data-level="3.6" data-path="tplbase/include.html">
             <a href="include.html" tppabs="http://doc.duxcms.com/tplbase/include.html">
               <i class="fa fa-check"></i> <b>3.6.</b> 模板引入
             </a>
           </li>
         </ul>
       </li>
       <li class="chapter " data-level="4" data-path="tplcom/info.html">
         <a href="info-1.html" tppabs="http://doc.duxcms.com/tplcom/info.html">
           <i class="fa fa-check"></i> <b>4.</b> 通用页面标签
         </a>
         <ul class="articles">
           <li class="chapter " data-level="4.1" data-path="tplcom/contentlist.html">
             <a href="contentlist.html" tppabs="http://doc.duxcms.com/tplcom/contentlist.html">
               <i class="fa fa-check"></i> <b>4.1.</b> 栏目列表
             </a>
           </li>
           <li class="chapter " data-level="4.2" data-path="tplcom/content.html">
             <a href="content.html" tppabs="http://doc.duxcms.com/tplcom/content.html">
               <i class="fa fa-check"></i> <b>4.2.</b> 内容列表
             </a>
           </li>
           <li class="chapter " data-level="4.3" data-path="tplcom/articlelist.html">
             <a href="articlelist.html" tppabs="http://doc.duxcms.com/tplcom/articlelist.html">
               <i class="fa fa-check"></i> <b>4.3.</b> 文章栏目、内容调用
             </a>
           </li>
           <li class="chapter " data-level="4.4" data-path="tplcom/taglist.html">
             <a href="taglist.html" tppabs="http://doc.duxcms.com/tplcom/taglist.html">
               <i class="fa fa-check"></i> <b>4.4.</b> TAG列表
             </a>
           </li>
           <li class="chapter " data-level="4.5" data-path="tplcom/form.html">
             <a href="form.html" tppabs="http://doc.duxcms.com/tplcom/form.html">
               <i class="fa fa-check"></i> <b>4.5.</b> 表单内容列表
             </a>
           </li>
         </ul>
       </li>
       <li class="chapter " data-level="5" data-path="tplpage/info.html">
         <a href="info-2.html" tppabs="http://doc.duxcms.com/tplpage/info.html">
           <i class="fa fa-check"></i> <b>5.</b> 专属页面标签
         </a>
         <ul class="articles">
           <li class="chapter " data-level="5.1" data-path="tplpage/articlelist.html">
             <a href="articlelist-1.html" tppabs="http://doc.duxcms.com/tplpage/articlelist.html">
               <i class="fa fa-check"></i> <b>5.1.</b> 文章栏目
             </a>
           </li>
           <li class="chapter " data-level="5.2" data-path="tplpage/article.html">
             <a href="article.html" tppabs="http://doc.duxcms.com/tplpage/article.html">
               <i class="fa fa-check"></i> <b>5.2.</b> 文章内容
             </a>
           </li>
           <li class="chapter " data-level="5.3" data-path="tplpage/page.html">
             <a href="page.html" tppabs="http://doc.duxcms.com/tplpage/page.html">
               <i class="fa fa-check"></i> <b>5.3.</b> 单页面
             </a>
           </li>
           <li class="chapter " data-level="5.4" data-path="tplpage/search.html">
             <a href="search.html" tppabs="http://doc.duxcms.com/tplpage/search.html">
               <i class="fa fa-check"></i> <b>5.4.</b> 搜索结果
             </a>
           </li>
           <li class="chapter " data-level="5.5" data-path="tplpage/taglist.html">
             <a href="taglist-1.html" tppabs="http://doc.duxcms.com/tplpage/taglist.html">
               <i class="fa fa-check"></i> <b>5.5.</b> TAG列表
             </a>
           </li>
           <li class="chapter " data-level="5.6" data-path="tplpage/tagcontent.html">
             <a href="tagcontent.html" tppabs="http://doc.duxcms.com/tplpage/tagcontent.html">
               <i class="fa fa-check"></i> <b>5.6.</b> TAG内容列表
             </a>
           </li>
           <li class="chapter " data-level="5.7" data-path="tplpage/formlist.html">
             <a href="formlist.html" tppabs="http://doc.duxcms.com/tplpage/formlist.html">
               <i class="fa fa-check"></i> <b>5.7.</b> 表单列表
             </a>
           </li>
           <li class="chapter " data-level="5.8" data-path="tplpage/form.html">
             <a href="form-1.html" tppabs="http://doc.duxcms.com/tplpage/form.html">
               <i class="fa fa-check"></i> <b>5.8.</b> 表单内容
             </a>
           </li>
         </ul>
       </li>
       <li class="chapter " data-level="6" data-path="tplother/info.html">
         <a href="info-3.html" tppabs="http://doc.duxcms.com/tplother/info.html">
           <i class="fa fa-check"></i> <b>6.</b> 其他模板功能
         </a>
         <ul class="articles">
           <li class="chapter " data-level="6.1" data-path="tplother/bread.html">
             <a href="bread.html" tppabs="http://doc.duxcms.com/tplother/bread.html">
               <i class="fa fa-check"></i> <b>6.1.</b> 位置导航
             </a>
           </li>
           <li class="chapter " data-level="6.2" data-path="tplother/link.html">
             <a href="link.html" tppabs="http://doc.duxcms.com/tplother/link.html">
               <i class="fa fa-check"></i> <b>6.2.</b> 链接标签
             </a>
           </li>
           <li class="chapter " data-level="6.3" data-path="tplother/fragment.html">
             <a href="fragment.html" tppabs="http://doc.duxcms.com/tplother/fragment.html">
               <i class="fa fa-check"></i> <b>6.3.</b> 碎片调用
             </a>
           </li>
           <li class="chapter " data-level="6.4" data-path="tplother/search.html">
             <a href="search-1.html" tppabs="http://doc.duxcms.com/tplother/search.html">
               <i class="fa fa-check"></i> <b>6.4.</b> 搜索框调用
             </a>
           </li>
           <li class="chapter " data-level="6.5" data-path="tplother/form.html">
             <a href="form-2.html" tppabs="http://doc.duxcms.com/tplother/form.html">
               <i class="fa fa-check"></i> <b>6.5.</b> 表单提交
             </a>
           </li>
           <li class="chapter " data-level="6.6" data-path="tplother/expend.html">
             <a href="expend.html" tppabs="http://doc.duxcms.com/tplother/expend.html">
               <i class="fa fa-check"></i> <b>6.6.</b> 扩展字段使用
             </a>
           </li>
         </ul>
       </li>
       <li class="chapter " data-level="7" data-path="tplext/info.html">
         <a href="info-4.html" tppabs="http://doc.duxcms.com/tplext/info.html">
           <i class="fa fa-check"></i> <b>7.</b> 扩展模块
         </a>
       </li>
       <li class="divider"></li>
       <li>
         <a href="javascript:if(confirm('http://git.oschina.net/duxcms/DuxCms-2.0  \n\nThis file was not retrieved by Teleport Pro, because it is addressed on a domain or path outside the boundaries set for its Starting Address.  \n\nDo you want to open it from the server?'))window.location='http://git.oschina.net/duxcms/DuxCms-2.0'" tppabs="http://git.oschina.net/duxcms/DuxCms-2.0" target="_blank" class="custom-link">DuxCms GIT</a>
       </li>
     </ul>
   </div>
