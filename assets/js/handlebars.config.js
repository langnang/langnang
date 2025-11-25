(function () {
  "use strict";
  var template = Handlebars.compile("Handlebars <b>{{doesWhat}}</b>");
  // execute the compiled template and print the output to the console
  console.log(template({ doesWhat: "rocks!" }));




  Handlebars.registerHelper("bold", function (text) {
    var result = "<b>" + Handlebars.escapeExpression(text) + "</b>";
    return new Handlebars.SafeString(result);
  });
  /**
   * 自定义助手
   * 通过调用 Handlebars.registerHelper 方法，你可以从模板中的任何上下文中访问 Handlebars 助手代码。
   */
  Handlebars.registerHelper('loud', function (aString) {
    return aString.toUpperCase()
  })
  /**
   * 块助手代码
   * 代码块表达式使你可以自定义这样的助手代码：这个助手代码可以使用与当前上下文不同的上下文来调用模板。这些块助手代码在名称前 以 # 号标识，并且需要一个名称相同的结束模板 /。
   */
  Handlebars.registerHelper("list", function (items, options) {
    const itemsAsHtml = items.map(item => "<li>" + options.fn(item) + "</li>");
    return "<ul>\n" + itemsAsHtml.join("\n") + "\n</ul>";
  });
  /**
   * 代码片段
   * Handlebars 代码片段通过创建共享模板允许代码复用。你可以使用 registerPartial 方法：
   */
  Handlebars.registerPartial(
    "person",
    "{{person.name}} is {{person.age}} years old.\n"
  )
  /**
   * 
   * 
   */
  /**
   * 
   * 
   */

})()