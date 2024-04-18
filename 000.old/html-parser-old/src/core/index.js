/** @format */

const attribute = /^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/; // 属性
const dynamicArgAttribute = /^\s*((?:v-[\w-]+:|@|:|#)\[[^=]+?\][^\s"'<>\/=]*)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
const ncname = "[a-zA-Z_][\\-\\.0-9_a-zA-Z]*"; // 标签名称
const qnameCapture = "((?:" + ncname + "\\:)?" + ncname + ")"; // <span:xx>
const startTagOpen = new RegExp("^<" + qnameCapture); // 标签开头的正则，捕获的内容是标签名
const startTagClose = /^\s*(\/?)>/; // 匹配标签结束的 >
const endTag = new RegExp("^<\\/" + qnameCapture + "[^>]*>"); // 匹配标签结尾的 </div>
const doctype = /^<!DOCTYPE [^>]+>/i;
const comment = /^<!\--/;
const conditionalComment = /^<!\[/;

function htmlParser() {
  return {};
}

function vnode(tag, data, children, text) {
  return {
    tagName,
    data,
    children,
    text,
  };
}
