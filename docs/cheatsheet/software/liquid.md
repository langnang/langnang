---
title: Liquid
layout: cheatsheet
---


## Basics

简介
操作符
真值与假值
数据类型
Liquid 的各种分支
控制输出的空白符

## Tags

注释
控制流
迭代／循环
原始内容
变量

## Filters

### abs

返回一个数字的绝对值。

### append

将两个字符串拼接起来并返回拼接之后的值。

### at_least

将数字限制在最小值。

### at_most

将数字限制在最大值。

```ruby

{{ 4 | at_most: 5 }}

# 4

{{ 4 | at_most: 3 }}

# 3
```

### capitalize

将字符串首字母转为大写。

```ruby

{{ "title" | capitalize }}

# Title

{{ "my great title" | capitalize }}

# My great title
```

### ceil

将一个浮点数向上取整并返回一个最接近的整数。在 ceil 过滤器执行之前 Liquid 会先尝试将输入转换为数字格式。

```ruby
{{ 1.2 | ceil }}

# 2
{{ 2.0 | ceil }}

# 2
{{ 183.357 | ceil }}

# 184
以下实例所用输入是字符串：

{{ "3.5" | ceil }}

# 4
```

### compact

删除数组中的所有 nil 值。

例如，假定整个网站所有内容页面作为一个数组保存在 site.pages 变量中，其中某些页面被设置了 category 属性用于指定该页面的内容分类。如果我们利用 map 过滤器将所有页面的 category 属性保存到一个数组中，就会出现如果某个页面没有 category 属性，其在数组中的值就会是 nil。

```ruby
{% assign site_categories = site.pages | map: 'category' %}

{% for category in site_categories %}
  {{ category }}
{% endfor %}
#   business
  celebrities

  lifestyle
  sports

  technology
在创建 site_categories 数组时，通过使用 compact 过滤器我们可以删除此数组中的所有 nil 值。

{% assign site_categories = site.pages | map: 'category' | compact %}

{% for category in site_categories %}
  {{ category }}
{% endfor %}
#   business
  celebrities
  lifestyle
  sports
  technology
```

### concat

Concatenates (joins together) multiple arrays. The resulting array contains all the items from the input arrays.

```ruby
Input

{% assign fruits = "apples, oranges, peaches" | split: ", " %}
{% assign vegetables = "carrots, turnips, potatoes" | split: ", " %}

{% assign everything = fruits | concat: vegetables %}

{% for item in everything %}

- {{ item }}
{% endfor %}
Output

- apples
- oranges
- peaches
- carrots
- turnips
- potatoes
You can string together concat filters to join more than two arrays:

Input

{% assign furniture = "chairs, tables, shelves" | split: ", " %}

{% assign everything = fruits | concat: vegetables | concat: furniture %}

{% for item in everything %}

- {{ item }}
{% endfor %}
Output

- apples
- oranges
- peaches
- carrots
- turnips
- potatoes
- chairs
- tables
- shelves
```

### date

将时间戳（timestamp）转换为另一种日期格式。格式化语法与 strftime 一致。输入格式与 Ruby 中的 Time.parse 一致。

```ruby
{{ article.published_at | date: "%a, %b %d, %y" }}

# Fri, Jul 17, 15

{{ article.published_at | date: "%Y" }}

# 2015

date 能够作用于包含良好格式化的日期字符串：

{{ "March 14, 2016" | date: "%b %d, %y" }}

# Mar 14, 16

将 "now" (或 "today") 单词传入 date 过滤器可以获取当前时间：

This page was last updated at {{ "now" | date: "%Y-%m-%d %H:%M" }}.

# This page was last updated at 2020-05-01 14:41
```

注意，上述实例输出的日期是最后一次生成当前页面的时间，并不是页面呈现给用户的时间。

### default

指定一个默认值，以防预期的值不存在。如果左侧的值为 nil、false 或空，default 将输出此默认值。

如下实例中，product_price 并未被定义，因此将输出默认值。

```ruby
{{ product_price | default: 2.99 }}

# 2.99

如下实例中，product_price 已被定义，不再输出默认值。

{% assign product_price = 4.99 %}
{{ product_price | default: 2.99 }}

# 4.99

如下实例中，product_price 的值为空，因此将输出默认值。

{% assign product_price = "" %}
{{ product_price | default: 2.99 }}

# 2.99
```

### divided_by

将两个数相除。

如果除数（divisor）为整数，则将相除之后得到的结果向下取整得到最接近的整数（也就是对应 floor 的功能）。

```ruby
{{ 16 | divided_by: 4 }}

# 4

{{ 5 | divided_by: 3 }}

# 1

控制舍入
divided_by 返回的结果于除数是同一数据类型的，也就是说，如果除数是整数，返回的结果也是整数；如果除数是浮点数（带有小数），返回的结果也是浮点数。

如下实例，除数为整数：

{{ 20 | divided_by: 7 }}

# 2

除数为浮点数：

{{ 20 | divided_by: 7.0 }}

# 2.857142857142857

改变变量的类型
某些情况你需要将除数设置为一个变量，这种情况下你无法简单的给这个变量添加 .0 将其转变为浮点数。这时，你可以通过 times 过滤器将其转变为浮点数，并通过 assign 创建一个新变量来保存转换之后的浮点数。

下例中，除数是一个变量，保存的是一个整数，所以返回值也是一个整数：

{% assign my_integer = 7 %}
{{ 20 | divided_by: my_integer }}

# 2

下面，我们将这个变量乘以 1.0 来得到一个浮点数，然后将此浮点数作为除数进行运算：

{% assign my_integer = 7 %}
{% assign my_float = my_integer | times: 1.0 %}
{{ 20 | divided_by: my_float }}

# 2.857142857142857
```

### downcase

用于将字符串中的各个字符转换为小写形式。对于已经是小写形式的字符串没有任何影响。

```ruby
{{ "Parker Moore" | downcase }}

# parker moore

{{ "apple" | downcase }}

# apple
```

### escape

对字符串转义操作就是将字符串中的某些字符替换为转义序列（escape sequence），这样整个字符串就能够用于 URL 了。如果字符串不需要转义则不会对字符串做任何操作。

```ruby
{{ "Have you read 'James & the Giant Peach'?" | escape }}

# Have you read &#39;James &amp; the Giant Peach&#39;?

{{ "Tetsuro Takara" | escape }}

# Tetsuro Takara
```

### escape_once

转义一个字符串并且不修改已经转义过的实体（entities)。对于无须转义的字符串不做任何修改。

```ruby

{{ "1 < 2 & 3" | escape_once }}

# 1 &lt; 2 &amp; 3

{{ "1 &lt; 2 &amp; 3" | escape_once }}

# 1 &lt; 2 &amp; 3
```

### first

返回数组的第一项。

```ruby

{% assign my_array = "apples, oranges, peaches, plums" | split: ", " %}

{{ my_array.first }}

# apples

{% assign my_array = "zebra, octopus, giraffe, tiger" | split: ", " %}

{{ my_array.first }}

# zebra
```

### floor

将一个浮点数通过舍弃小数部分得到最近的整数。在 floor 过滤器执行之前 Liquid 会先尝试将输入转换为数字格式。

```ruby

{{ 1.2 | floor }}

# 1

{{ 2.0 | floor }}

# 2

{{ 183.357 | floor }}

# 183

以下实例所用输入是字符串：

{{ "3.5" | floor }}

# 3
```

### join

将数组中的各个字符串合并为一个字符串，并将 split 参数作为字符串之间的分隔符。

```ruby

{% assign beatles = "John, Paul, George, Ringo" | split: ", " %}

{{ beatles | join: " and " }}

# John and Paul and George and Ringo
```

### last

返回数组中的最后一项。

```ruby

{% assign my_array = "apples, oranges, peaches, plums" | split: ", " %}

{{ my_array.last }}

# plums

{% assign my_array = "zebra, octopus, giraffe, tiger" | split: ", " %}

{{ my_array.last }}

# tiger
```

### lstrip

删除字符串左侧的所有空白符（制表符、空格和换行符）。字符串中间的所有空白符不受影响。

```ruby

{{ "          So much room for activities!          " | lstrip }}

# So much room for activities
```

### map

从对象（object）中提取指定名称的属性的值，并用这些值构建一个数组。

以下实例中，假定 site.pages 包含了整个网站的元数据信息。利用 assign 和 map 过滤器创建一个变量，此变量只包含 site.pages 对象中 category 属性对应的所有值。

```ruby

{% assign all_categories = site.pages | map: "category" %}

{% for item in all_categories %}
{{ item }}
{% endfor %}

# business

celebrities
lifestyle
sports
technology
```

### minus

从一个数中减去另一个数。

```ruby

{{ 4 | minus: 2 }}

# 2

{{ 16 | minus: 4 }}

# 12

{{ 183.357 | minus: 12 }}

# 171.357
```

### modulo

返回除法运算的余数。

```ruby

{{ 3 | modulo: 2 }}

# 1

{{ 24 | modulo: 7 }}

# 3

{{ 183.357 | modulo: 12 }}

# 3.357
```

### newline_to_br

将所有换行符(\n) 替换为 HTML 的 (\<br>) 标签。

```ruby
{% capture string_with_newlines %}
Hello
there
{% endcapture %}

{{ string_with_newlines | newline_to_br }}

# <br />
Hello<br />
there<br />
```

### plus

两个数相加。

```ruby

{{ 4 | plus: 2 }}

# 6

{{ 16 | plus: 4 }}

# 20

{{ 183.357 | plus: 12 }}

# 195.357
```

### prepend

在一个字符串前面附加另一个字符串。

```ruby
{{ "apples, oranges, and bananas" | prepend: "Some fruit: " }}

# Some fruit: apples, oranges, and bananas

prepend 也能作用于变量：

{% assign url = "example.com" %}

{{ "/index.html" | prepend: url }}

# example.com/index.html
```

### remove

从一个字符串中删除所有出现的另一个子字符串。

```ruby
{{ "I strained to see the train through the rain" | remove: "rain" }}

# I sted to see the t through the

### remove_first

从一个字符串中仅仅删除第一次出现的另一个子字符串。

{{ "I strained to see the train through the rain" | remove_first: "rain" }}

# I sted to see the train through the rain
```

### replace

将参数中给出的第一个参数全部替换为第二个参数。

```ruby
{{ "Take my protein pills and put my helmet on" | replace: "my", "your" }}

# Take your protein pills and put your helmet on
```

### replace_first

将字符串中出现的第一个参数替换为第二个参数。

```ruby
{% assign my_string = "Take my protein pills and put my helmet on" %}
{{ my_string | replace_first: "my", "your" }}

# Take your protein pills and put my helmet on
```

### reverse

将数组中的所有项的顺序反转。reverse 不能操作字符串。

```ruby
{% assign my_array = "apples, oranges, peaches, plums" | split: ", " %}

{{ my_array | reverse | join: ", " }}

# plums, peaches, oranges, apples

reverse 不能直接应用到字符串上，但是你可以先将字符串分割成字符数组，然后再将数组反转，最后将反转之后的数组合并。

{{ "Ground control to Major Tom." | split: "" | reverse | join: "" }}

# .moT rojaM ot lortnoc dnuorG
```

### round

将浮点数舍入到最近的整数，或者，如果传入的参数是一个数值的话，将浮点数舍入到参数指定的小数位。

```ruby
{{ 1.2 | round }}

# 1

{{ 2.7 | round }}

# 3

{{ 183.357 | round: 2 }}

# 183.36
```

### rstrip

将字符串右侧的所有空白字符（制表符 - tab、空格符 - space 和 回车符 - newline）删除。

```ruby

{{ "          So much room for activities!          " | rstrip }}

# So much room for activities
```

### size

返回字符串中所包含的字符数或者数组中所包含的条目数量。size 还支持“点标记”（例如 {{ my_string.size }}）。这种用法便于你在标签（tag）中使用 size 过滤器，例如条件判断标签（tag）。

```ruby
{{ "Ground control to Major Tom." | size }}

# 28

{% assign my_array = "apples, oranges, peaches, plums" | split: ", " %}

{{ my_array | size }}

# 4

使用“点标记”：

{% if site.pages.size > 10 %}
  This is a big website!
{% endif %}
```

### slice

只传入一个参数时将返回此参数作为下标所对应的单个字符。第二个参数是可选的，用于指定返回的子字符串的长度。

String indices are numbered starting from 0.

```ruby
{{ "Liquid" | slice: 0 }}

# L

{{ "Liquid" | slice: 2 }}

# q

{{ "Liquid" | slice: 2, 5 }}

# quid

If the first parameter is a negative number, the indices are counted from the end of the string:

{{ "Liquid" | slice: -3, 2 }}

# ui
```

### sort

对数组中的所有进行排序。排序后的数组是按照区分大小写的顺序排列的。

```ruby
{% assign my_array = "zebra, octopus, giraffe, Sally Snake" | split: ", " %}

{{ my_array | sort | join: ", " }}

# Sally Snake, giraffe, octopus, zebra
```

### sort_natural

对数组进行排序，并且大小写无关。

```ruby
{% assign my_array = "zebra, octopus, giraffe, Sally Snake" | split: ", " %}

{{ my_array | sort_natural | join: ", " }}

# giraffe, octopus, Sally Snake, zebra
```

### split

根据参数传入的分隔符将字符串分解为数组。split 通常被用于将以逗号为分隔符的字符串转换为数组。

```ruby
{% assign beatles = "John, Paul, George, Ringo" | split: ", " %}

{% for member in beatles %}
  {{ member }}
{% endfor %}

# John

  Paul

  George

  Ringo
```

### strip

删除字符串左右两侧的所有空白符号（包括制表符、空格、换行符）。对于字符串中间的空白符不做任何处理。

```ruby
Input

{{ "          So much room for activities!          " | strip }}

Output

So much room for activities!
```

### strip_html

从字符串中删除所有 HTML 标签。

```ruby
{{ "Have <em>you</em> read <strong>Ulysses</strong>?" | strip_html }}

# Have you read Ulysses?
```

### strip_newlines

从字符串中删除所有换行字符（newline character）。

```ruby
{% capture string_with_newlines %}
Hello
there
{% endcapture %}

{{ string_with_newlines | strip_newlines }}

# Hellothere
```

### times

将一个数乘以另一个数。

```ruby
{{ 3 | times: 2 }}

# 6

{{ 24 | times: 7 }}

# 168

{{ 183.357 | times: 12 }}

# 2200.284
```

### truncate

truncate 将字符串截短为指定的字符个数。如果指定的字符数量小于字符串的长度，则会在字符串末尾添加一个省略号(…) 并将此省略号计入字符个数中。

```ruby
{{ "Ground control to Major Tom." | truncate: 20 }}

# Ground control to

自定义省略号
truncate 还支持第二个可选参数，用于指定一个字符序列，此字符序列将被添加到截短字符串的后面。默认是省略号(…)，但是你可以按照你的需要传递一个新的。

第二个参数的长度将被计入第一个参数的字符个数中。例如，如果你希望将字符串截短为 10 个字符，并且使用由 3 个字符组成的省略号，这时，你需要将 truncate 的第一个参数设置为 13，是因为需要计入省略号的 3 个字符。

{{ "Ground control to Major Tom." | truncate: 25, ", and so on" }}

# Ground control, and so on

无省略号
你可以将字符串按照第一个参数截短为指定长度，并且可以通过传递一个空字符作为第二个参数，从而让截短之后的字符串不显示省略号。

{{ "Ground control to Major Tom." | truncate: 20, "" }}

# Ground control to Ma
```

### truncatewords

将字符串截短为指定的单词个数。如果指定的单词数量小于字符串中包含的单词个数，则会在字符串末尾添加一个省略号(…)。

```ruby
{{ "Ground control to Major Tom." | truncatewords: 3 }}

# Ground control to

自定义省略号
truncatewords 还支持第二个可选参数，用于指定一个字符序列，此字符序列将被添加到截短字符串的后面。默认是省略号(…)，但是你可以按照你的需要传递一个新的。

{{ "Ground control to Major Tom." | truncatewords: 3, "--" }}

# Ground control to--

无省略号
如果你不希望在末尾添加省略号，可以将 truncatewords 的第二个参数设置为空字符串：

{{ "Ground control to Major Tom." | truncatewords: 3, "" }}

# Ground control to
```

### uniq

删除数组中的所有冗余项。

```ruby
{% assign my_array = "ants, bugs, bees, bugs, ants" | split: ", " %}

{{ my_array | uniq | join: ", " }}

# ants, bugs, bees
```

### upcase

将字符串中的每个字符都转换为大写形式。对于已经全是大写的字符串不做任何操作。

```ruby
{{ "Parker Moore" | upcase }}

# PARKER MOORE

{{ "APPLE" | upcase }}

# APPLE
```

### url_decode

对于作为 URL 进行编码或通过 url_encode 编码的字符串进行解码。

```ruby
{{ "%27Stop%21%27+said+Fred" | url_decode }}

# 'Stop!' said Fred
```

### url_encode

将字符串中非 URL 安全的字符转换为百分号编码（percent-encoded）的字符。

```ruby
{{ "john@liquid.com" | url_encode }}

# john%40liquid.com

{{ "Tetsuro Takara" | url_encode }}

# Tetsuro+Takara
```
