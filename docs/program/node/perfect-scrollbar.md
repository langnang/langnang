---
title: perfect-scrollbar
---

## Installation

### NPM

Prerequisites

Before starting project make sure to install [Node LTS](https://nodejs.org/en/) (12.x.x recommended).

Installation

To install MDB UI KIT in your project easily type the following command in terminal:

### CDN

Installation via CDN is one of the easiest methods of integrating MDB UI KIT with your project. Just copy the latest compiled JS script tag and CSS link tag from [cdnjs](https://cdnjs.com/libraries/mdb-ui-kit/) to the application.

Don't forget to add also Font Awesome and Roboto font if you need. Here's an example code:

**Other ways to install**

### MDB CLI

CLI installation is **the most efficient** way to use MDB. It enables options such as:

- **Free hosting** (supports custom domains, SSL, FTP access)
- Easy updates with a single command
- Backend starter templates (Laravel, plain PHP, node.js & more)
- WordPress setup in 3 minutes (blog, ecommerce or blank project)
- Git repository for you and your team
- and much more!

### Webpack Starter

Installing MDB with Webpack is very useful for experienced developers. What using Webpack actually gives:

- Bundling via [webpack](https://github.com/webpack/webpack)
- ES6+ Support via [babel](https://babeljs.io/)
- SASS Support via [sass-loader](https://github.com/jtangelder/sass-loader)
- Linting via [eslint-loader](https://github.com/MoOx/eslint-loader)
- and much more!

## How to use

### Before using

The following requirements should be met:

- the container must have a `position` style.
- the container must be a normal container element.

Those requirements are met in the CSS in the package, but please keep in mind when you'd like to change the CSS files.

- the container must have an `overflow: hidden` css style.
- the scrollbar's position must be `absolute`.
- the scrollbar-x must have `bottom` or `top`, and the scrollbar-y must have `right` or `left`.

Finally, scroll hooking is generally considered a bad practice, and perfect-scrollbar should be used carefully. Unless custom scroll is really needed, using browser-native scroll is always recommended. If you want to diversify your perfect scrollbar, you can combine it with information about the [scroll status](https://mdbootstrap.com/docs/standard/plugins/scroll-status/).

Additionally, with Perfect Scrollbar you can use a component with [Scroll back to the top](https://mdbootstrap.com/docs/standard/extended/back-to-top/) option

### Caveats

Perfect-scrollbar emulates some scrolls, but not all of the kinds. It also _does not_ work in some situations. You can find these cases in [Caveats](https://github.com/mdbootstrap/perfect-scrollbar/wiki/Caveats). Basically, items listed in the caveats are hacky to implement and may not be implemented in the future. If the features are really needed, please consider using browser-native scroll.

First of all, please check if the container element meets the requirements and the main CSS is imported.

```html
<style>
    #container {
      position: relative;
      width: 600px;
      height: 400px;
    }
</style>
<!-- <link rel="stylesheet" href="css/perfect-scrollbar.css"> -->
```

Import via ES modules:

```js
import PerfectScrollbar from 'perfect-scrollbar';
```

Or in browser:

```html
<!-- <script src="dist/perfect-scrollbar.js"></script> -->
```

To initialise:

```js
const container =
document.querySelector('#container');
const ps = new PerfectScrollbar(container);

// or just with selector string
const ps = new PerfectScrollbar('#container');
```

It can be initialized with [options](https://perfectscrollbar.com/options.html).

```js
const ps = new
PerfectScrollbar('#container', {
wheelSpeed: 2,
wheelPropagation: true,
minScrollbarLength: 20
});
```

If the size of your container or content changes, call `update`.

```js
ps.update();
```

If you want to destroy the scrollbar, use `destroy`.

```js
ps.destroy();
ps = null; // to make sure garbages are collected
```

If you want to scroll to somewhere, just update `scrollTop`.

```js
const container = document.querySelector('#container');
container.scrollTop = 0;
```

You can also get information about how to use the plugin from code in [`examples`](https://github.com/mdbootstrap/perfect-scrollbar/tree/master/examples).

You can also add a simple customized [Scrollbar](https://mdbootstrap.com/docs/standard/methods/scrollbar/) to your project

## Options

### `handlers {String[]}`

It is a list of handlers to scroll the element

**Default**: `['click-rail', 'drag-thumb', 'keyboard', 'wheel', 'touch']`

### `wheelSpeed {Number}`

The scroll speed applied to mousewheel event.

**Default**: `1`

### `wheelPropagation {Boolean}`

If this option is true, when the scroll reaches the end of the side, mousewheel event will be propagated to parent element.

**Default**: `false`

### `swipeEasing {Boolean}`

If this option is true, swipe scrolling will be eased.

**Default**: `true`

### `minScrollbarLength {Number?}`

When set to an integer value, the thumb part of the scrollbar will not shrink below that number of pixels.

**Default**: `null`

### `maxScrollbarLength {Number?}`

When set to an integer value, the thumb part of the scrollbar will not expand over that number of pixels.

**Default**: `null`

### `scrollingThreshold {Number}`

This sets threashold for `ps--scrolling-x` and `ps--scrolling-y` classes to remain. In the default CSS, they make scrollbars shown regardless of hover state. The unit is millisecond.

**Default**: `1000`

### `useBothWheelAxes {Boolean}`

When set to true, and only one (vertical or horizontal) scrollbar is visible then both vertical and horizontal scrolling will affect the scrollbar.

**Default**: `false`

### `suppressScrollX {Boolean}`

When set to true, the scroll bar in X axis will not be available, regardless of the content width.

**Default**: `false`

### `suppressScrollY {Boolean}`

When set to true, the scroll bar in Y axis will not be available, regardless of the content height.

**Default**: `false`

### `scrollXMarginOffset {Number}`

The number of pixels the content width can surpass the container width without enabling the X axis scroll bar. Allows some "wiggle room" or "offset break", so that X axis scroll bar is not enabled just because of a few pixels.

**Default**: `0`

### `scrollYMarginOffset {Number}`

The number of pixels the content height can surpass the container height without enabling the Y axis scroll bar. Allows some "wiggle room" or "offset break", so that Y axis scroll bar is not enabled just because of a few pixels.

**Default**: `0`

## Events

Perfect-scrollbar dispatches custom events.

### `ps-scroll-y`

This event fires when the y-axis is scrolled in either direction.

### `ps-scroll-x`

This event fires when the x-axis is scrolled in either direction.

### `ps-scroll-up`

This event fires when scrolling upwards.

### `ps-scroll-down`

This event fires when scrolling downwards.

### `ps-scroll-left`

This event fires when scrolling to the left.

### `ps-scroll-right`

This event fires when scrolling to the right.

### `ps-y-reach-start`

This event fires when scrolling reaches the start of the y-axis.

### `ps-y-reach-end`

This event fires when scrolling reaches the end of the y-axis (useful for infinite scroll).

### `ps-x-reach-start`

This event fires when scrolling reaches the start of the x-axis.

### `ps-x-reach-end`

This event fires when scrolling reaches the end of the x-axis.

You can also watch the reach state via the `reach` property.
