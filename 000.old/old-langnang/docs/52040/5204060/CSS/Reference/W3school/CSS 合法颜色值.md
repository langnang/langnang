---
created: 2022-07-28T22:23:20 (UTC +08:00)
tags: []
source: https://www.w3school.com.cn/cssref/css_colors_legal.asp
author: w3school.com.cn
---

# CSS 合法颜色值

> ## Excerpt
> CSS 中的颜色可以通过以下方法指定：

---
## CSS 合法颜色值

-   [CSS 颜色](https://www.w3school.com.cn/cssref/css_colors.asp "CSS 颜色")
-   [CSS 默认值](https://www.w3school.com.cn/cssref/css_default_values.asp "CSS 默认值")

## CSS 颜色

CSS 中的颜色可以通过以下方法指定：

-   十六进制颜色
-   带透明度的十六进制颜色
-   RGB 颜色
-   RGBA 颜色
-   HSL 颜色
-   HSLA 颜色
-   预定义/跨浏览器的颜色名称
-   使用 `currentcolor` 关键字

## 十六进制颜色

用 #RRGGBB 规定十六进制颜色，其中 RR（红色）、GG（绿色）和 BB（蓝色）十六进制整数指定颜色的成分（分量）。所有值必须在 00 到 FF 之间。

例如，＃0000ff 值呈现为蓝色，因为蓝色分量设置为最高值（ff），其他分量设置为 00。

### 实例

定义不同的 HEX 颜色：

```
#p1 {background-color: #ff0000;}   
#p2 {background-color: #00ff00;}   
#p3 {background-color: #0000ff;}   

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_hex)

## 带透明度的十六进制颜色

用 #RRGGBB 规定十六进制颜色。如需增加透明度，请在 00 和 FF 之间添加两个额外的数字。

### 实例

定义带透明度的 HEX 颜色：

```css
#p1a {background-color: #ff000080;}   
#p2a {background-color: #00ff0080;}   
#p3a {background-color: #0000ff80;}   

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_hexa)

## RGB 颜色

RGB 颜色值由 [rgb() 函数](https://www.w3school.com.cn/cssref/func_rgb.asp "CSS rgb() 函数")规定，语法如下：

```css
rgb(red, green, blue)
```

每个参数（_red_, _green_, _blue_）定义颜色的强度，可以是 0 到 255 之间的整数或百分比值（从 0％ 到 100％）。

例如，值 rgb(0,0,255) 呈现为蓝色，因为 blue 参数设置为其最高值（255），其他参数设置为 0。

此外，以下值定义相同的颜色：rgb(0,0,255) 和 rgb(0%,0%,100%)。

### 实例

定义不同的 RGB 颜色：

```css
#p1 {background-color: rgb(255, 0, 0);}   
#p2 {background-color: rgb(0, 255, 0);}   
#p3 {background-color: rgb(0, 0, 255);}   

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_rgb)

## RGBA 颜色

RGBA 颜色值是 RGB 颜色值的扩展，它带有 Alpha 通道 - 指定对象的不透明度。

RGBA 颜色通过 [rgba() 函数](https://www.w3school.com.cn/cssref/func_rgba.asp "CSS rgba() 函数")规定，语法如下：

```
rgba(red, green, blue, alpha)
```

_alpha_ 参数是介于 0.0（完全透明）和 1.0（完全不透明）之间的数字。

### 实例

定义带有不透明度的不同 RGB 颜色：

```
#p1 {background-color: rgba(255, 0, 0, 0.3);}   
#p2 {background-color: rgba(0, 255, 0, 0.3);}   
#p3 {background-color: rgba(0, 0, 255, 0.3);}   

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_rgba)

## HSL 颜色

HSL 指的是色相（hue）、饱和度（saturation）和亮度（lightness）- 代表颜色的圆柱坐标表示。

使用 [hsl() 函数](https://www.w3school.com.cn/cssref/func_hsl.asp "CSS hsl() 函数")指定 HSL 颜色值，该函数的语法如下：

```
hsl(hue, saturation, lightness)
```

色相是色轮上的度数（从 0 到 360）- 0（或 360）是红色，120 是绿色，240 是蓝色。

饱和度是一个百分比值； 0％ 表示灰色阴影，而 100％ 是全彩色。

亮度也是一个百分比； 0％ 是黑色，100％ 是白色。

### 实例

定义不同的 HSL 颜色：

```
#p1 {background-color: hsl(120, 100%, 50%);}   
#p2 {background-color: hsl(120, 100%, 75%);}   
#p3 {background-color: hsl(120, 100%, 25%);}   
#p4 {background-color: hsl(120, 60%, 70%);}    

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_hsl)

## HSLA 颜色

HSLA 颜色值是 HSL 颜色值的扩展，它带有 Alpha 通道 - 指定对象的不透明度。

HSLA 颜色值由 [hsla() 函数](https://www.w3school.com.cn/cssref/func_hsla.asp "CSS hsla() 函数")指定，该函数的语法如下：

```
hsla(hue, saturation, lightness, alpha)
```

_alpha_ 参数是介于 0.0（完全透明）和 1.0（完全不透明）之间的数字。

### 实例

定义带有不透明度的不同 HSL 颜色：

```
#p1 {background-color: hsla(120, 100%, 50%, 0.3);}   
#p2 {background-color: hsla(120, 100%, 75%, 0.3);}   
#p3 {background-color: hsla(120, 100%, 25%, 0.3);}   
#p4 {background-color: hsla(120, 60%, 70%, 0.3);}    

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_hsla)

## 预定义/跨浏览器的颜色名称

HTML 和 CSS 颜色规范中预定义了 140 个颜色名称。

例如：`blue`、`red`、`coral`、`brown` 等：

### 实例

定义不同的颜色名：

```
#p1 {background-color: blue;}
#p2 {background-color: red;}
#p3 {background-color: coral;}
#p4 {background-color: brown;}

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_names)

所有预定义名称的列表都可以在我们的 颜色名称参考手册 中找到。

## currentcolor 关键字

`currentcolor` 关键字引用元素的 color 属性值。

### 实例

以下 <div> 元素的边框颜色将为蓝色，因为 <div> 元素的文本颜色为蓝色：

```
#myDIV {
  color: blue; 
  border: 10px solid currentcolor; 
}

```

[亲自试一试](https://www.w3school.com.cn/tiy/t.asp?f=cssref_color_currentcolor)

-   [CSS 颜色](https://www.w3school.com.cn/cssref/css_colors.asp "CSS 颜色")
-   [CSS 默认值](https://www.w3school.com.cn/cssref/css_default_values.asp "CSS 默认值")
