# Object

`**Object**` 是 JavaScript 的一种 [数据类型](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Data_structures) 。它用于存储各种键值集合和更复杂的实体。Objects 可以通过 `Object()` 构造函数或者使用 [对象字面量](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/Object_initializer) 的方式创建

## [描述](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#描述)

  在 JavaScript 中，几乎所有的对象都是 `Object` 类型的实例，它们都会从 `Object.prototype` 继承属性和方法，虽然大部分属性都会被覆盖（shadowed）或者说被重写了（overridden）。  除此之外，`Object` 还可以被故意的创建，但是这个对象并不是一个“真正的对象”（例如：通过 `Object.create(null)`），或者通过一些手段改变对象，使其不再是一个“真正的对象”（比如说：`Object.setPrototypeOf`）。

通过原型链，所有的 `object` 都能观察到 Object 原型对象（Object prototype object）的改变，除非这些受到改变影响的属性和方法沿着原型链被进一步的重写。尽管有潜在的危险，但这为覆盖或扩展对象的行为提供了一个非常强大的机制。

  `Object` 构造函数为给定的参数创建一个包装类对象（object wrapper），具体有以下情况：

- 如果给定值是 [`null`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/null) 或 [`undefined`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/undefined)，将会创建并返回一个空对象
- 如果传进去的是一个基本类型的值，则会构造其包装类型的对象
- 如果传进去的是引用类型的值，仍然会返回这个值，经他们复制的变量保有和源对象相同的引用地址

当以非构造函数形式被调用时，`Object` 的行为等同于 `new Object()`。

可查看 [对象初始化/字面量语法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/Object_initializer)。

### [从一个对象上删除一个属性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#从一个对象上删除一个属性)

 Object 自身没有提供方法删除其自身属性（Map 中的 `Map.prototype.delete()` 可以删除自身属性 ）为了删除对象上的属性，必须使用 [delete 操作符](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/delete) 

## [构造函数](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#构造函数)

- [`Object()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/Object)

  创建一个新的 `Object` 对象。该对象将会包裹（wrapper）传入的参数 

## [静态方法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#静态方法)

- [`Object.assign()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/assign)

  通过复制一个或多个对象来创建一个新的对象。

- [`Object.create()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/create)

  使用指定的原型对象和属性创建一个新对象。

- [`Object.defineProperty()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty)

  给对象添加一个属性并指定该属性的配置。

- [`Object.defineProperties()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperties)

  给对象添加多个属性并分别指定它们的配置。

- [`Object.entries()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/entries)

  返回给定对象自身可枚举属性的 `[key, value]` 数组。

- [`Object.freeze()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/freeze)

  冻结对象：其他代码不能删除或更改任何属性。

- [`Object.getOwnPropertyDescriptor()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertyDescriptor)

  返回对象指定的属性配置。

- [`Object.getOwnPropertyNames()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertyNames)

  返回一个数组，它包含了指定对象所有的可枚举或不可枚举的属性名。

- [`Object.getOwnPropertySymbols()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertySymbols)

  返回一个数组，它包含了指定对象自身所有的符号属性。

- [`Object.getPrototypeOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/GetPrototypeOf)

  返回指定对象的原型对象。

- [`Object.is()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/is)

  比较两个值是否相同。所有 NaN 值都相等（这与==和===不同）。

- [`Object.isExtensible()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/isExtensible)

  判断对象是否可扩展。

- [`Object.isFrozen()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/isFrozen)

  判断对象是否已经冻结。

- [`Object.isSealed()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/isSealed)

  判断对象是否已经密封。

- [`Object.keys()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/keys)

  返回一个包含所有给定对象**自身**可枚举属性名称的数组。

- [`Object.preventExtensions()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/preventExtensions)

  防止对象的任何扩展。

- [`Object.seal()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/seal)

  防止其他代码删除对象的属性。

- [`Object.setPrototypeOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/setPrototypeOf)

  设置对象的原型（即内部 `[[Prototype]]` 属性）。

- [`Object.values()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/values)

  返回给定对象自身可枚举值的数组。

## [实例属性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#实例属性)

- [`Object.prototype.constructor`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/constructor)

  一个引用值，指向 Object 构造函数

- [`Object.prototype.__proto__`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/proto)

  指向一个对象，当一个 object 实例化时，使用该对象作为实例化对象的原型

## [实例方法](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#实例属性_2)

- [`Object.prototype.__defineGetter__()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/__defineGetter__)

  将一个属性与一个函数相关联，当该属性被访问时，执行该函数，并且返回函数的返回值。

- [`Object.prototype.__defineSetter__()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/__defineSetter__)

  将一个属性与一个函数相关联，当该属性被设置时，执行该函数，执行该函数去修改某个属性。

- [`Object.prototype.__lookupGetter__()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/__lookupGetter__)

  返回一个函数，该函数通过给定属性的 `Object.prototype.__defineGetter__()` 得出。

- [`Object.prototype.__lookupSetter__()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/__lookupSetter__)

  返回一个函数，该函数通过给定属性的 `Object.prototype.__defineSetter__()` 得出。

- [`Object.prototype.hasOwnProperty()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty)

  返回一个布尔值，用于表示一个对象自身是否包含指定的属性，该方法并不会查找原型链上继承来的属性。

- [`Object.prototype.isPrototypeOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/isPrototypeOf)

  返回一个布尔值，用于表示该方法所调用的对象是否在指定对象的原型链中。

- [`Object.prototype.propertyIsEnumerable()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/propertyIsEnumerable)

  返回一个布尔值，用于表示内部属性 [ECMAScript [[Enumerable\]] attribute](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Data_structures#属性) 是否被设置。

- [`Object.prototype.toLocaleString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toLocaleString)

  调用 `toString()。`

- [`Object.prototype.toString()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/toString)

  返回一个代表该对象的字符串。

- [`Object.prototype.valueOf()`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object/valueOf)

  返回指定对象的原始值。

## [示例](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#examples)

### [给定 `undefined` 和 `null` 类型使用 `Object`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#example.3a_using_object_given_undefined_and_null_types)

下面的例子将一个空的 `Object` 对象存到 `o` 中：

```
var o = new Object();
var o = new Object(undefined);
var o = new Object(null);
```

### [使用 `Object` 生成布尔对象](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#使用_object_生成布尔对象)

下面的例子将[`Boolean`](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Boolean) 对象存到 `o` 中：

```
// 等价于 o = new Boolean(true);
var o = new Object(true);
// 等价于 o = new Boolean(false);
var o = new Object(Boolean());
```

### [Object prototypes](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#object_prototypes)

  当我们要修改现有的 `Object.prototype` 方法时，请你考虑一下在已经存在的逻辑之前或者之后通过包装扩展代码的方式来注入代码。  比如说，有一段代码将会在执行内部逻辑或者是其他扩展之前，有条件的执行一段自定义的逻辑。

  当一个函数被调用时，调用的参数被保存在一个类似数组的“变量”  [arguments](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Functions/arguments)。  比如说：在调用 `myFn(a, b, c)` 时，myFunc 函数体中的 arguments 将会包含三个类似数组的元素，对应 `(a, b , c)`

  When modifying prototypes with hooks, pass `this` and the arguments (the call state) to the current behavior by calling `apply()` on the function. This pattern can be used for any prototype, such as `Node.prototype`, `Function.prototype`, etc.

```
var current = Object.prototype.valueOf;

// Since my property "-prop-value" is cross-cutting and isn't always
// on the same prototype chain, I want to modify Object.prototype:
Object.prototype.valueOf = function() {
  if (this.hasOwnProperty('-prop-value')) {
    return this['-prop-value'];
  } else {
    // It doesn't look like one of my objects, so let's fall back on
    // the default behavior by reproducing the current behavior as best we can.
    // The apply behaves like "super" in some other languages.
    // Even though valueOf() doesn't take arguments, some other hook may.
    return current.apply(this, arguments);
  }
}
```

Since JavaScript doesn't exactly have sub-class objects, prototype is a useful workaround to make a “base class” object of certain functions  that act as objects. For example:

```
  var Person = function(name) {
    this.name = name;
    this.canTalk = true;
  };
  
  Person.prototype.greet = function() {
    if (this.canTalk) {
      console.log('Hi, I am ' + this.name);
    }
  };
  
  var Employee = function(name, title) {
    Person.call(this, name);
    this.title = title;
  };
  
  Employee.prototype = Object.create(Person.prototype);
  Employee.prototype.constructor = Employee; //If you don't set Object.prototype.constructor to Employee,
                                             //it will take prototype.constructor of Person (parent).
                                             //To avoid that, we set the prototype.constructor to Employee (child).
  
  Employee.prototype.greet = function() {
    if (this.canTalk) {
      console.log('Hi, I am ' + this.name + ', the ' + this.title);
    }
  };
  
  var Customer = function(name) {
    Person.call(this, name);
  };
  
  Customer.prototype = Object.create(Person.prototype);
  Customer.prototype.constructor = Customer; //If you don't set Object.prototype.constructor to Customer,
                                             //it will take prototype.constructor of Person (parent).
                                             //To avoid that, we set the prototype.constructor to Customer (child).
  
  var Mime = function(name) {
    Person.call(this, name);
    this.canTalk = false;
  };
  
  Mime.prototype = Object.create(Person.prototype);
  Mime.prototype.constructor = Mime; //If you don't set Object.prototype.constructor to Mime,
                                     //it will take prototype.constructor of Person (parent).
                                     //To avoid that, we set the prototype.constructor to Mime (child).
  
  var bob = new Employee('Bob', 'Builder');
  var joe = new Customer('Joe');
  var rg = new Employee('Red Green', 'Handyman');
  var mike = new Customer('Mike');
  var mime = new Mime('Mime');
  
  bob.greet();
  // Hi, I am Bob, the Builder
  
  joe.greet();
  // Hi, I am Joe
  
  rg.greet();
  // Hi, I am Red Green, the Handyman
  
  mike.greet();
  // Hi, I am Mike
  
  mime.greet();
```

## [规范](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#规范)

| Specification                                                |
| ------------------------------------------------------------ |
| [ECMAScript Language Specification  # sec-object-objects](https://tc39.es/ecma262/multipage/fundamental-objects.html#sec-object-objects) |

## [浏览器兼容性](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#浏览器兼容性)

[Report problems with this compatibility data on GitHub](https://github.com/mdn/browser-compat-data/issues/new?mdn-url=https%3A%2F%2Fdeveloper.mozilla.org%2Fzh-CN%2Fdocs%2FWeb%2FJavaScript%2FReference%2FGlobal_Objects%2FObject&metadata= MDN+page+report+details<%2Fsummary> *+Query%3A+`javascript.builtins.Object` *+Report+started%3A+2022-07-27T11%3A32%3A04.063Z <%2Fdetails>&title=javascript.builtins.Object+-+&template=data-problem.yml)

|          | desktop | mobile | server  |                   |       |        |                |                     |               |               |                  |                 |      |         |
| -------- | ------- | ------ | ------- | ----------------- | ----- | ------ | -------------- | ------------------- | ------------- | ------------- | ---------------- | --------------- | ---- | ------- |
|          | Chrome  | Edge   | Firefox | Internet Explorer | Opera | Safari | Chrome Android | Firefox for Android | Opera Android | Safari on iOS | Samsung Internet | WebView Android | Deno | Node.js |
| `Object` |         |        |         |                   |       |        |                |                     |               |               |                  |                 |      |         |

| [`Object()` constructor](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/Object) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`assign`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`constructor`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/constructor) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`create`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/create) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`__defineGetter__`Deprecated](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/__defineGetter__) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`defineProperties`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperties) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`defineProperty`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/defineProperty) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`__defineSetter__`Deprecated](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/__defineSetter__) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`entries`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`freeze`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/freeze) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`fromEntries`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/fromEntries) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`getOwnPropertyDescriptor`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertyDescriptor) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`getOwnPropertyDescriptors`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertyDescriptors) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`getOwnPropertyNames`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertyNames) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`getOwnPropertySymbols`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertySymbols) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`getPrototypeOf`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/getPrototypeOf) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`hasOwn`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwn) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`hasOwnProperty`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`is`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isExtensible`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/isExtensible) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isFrozen`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/isFrozen) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isPrototypeOf`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/isPrototypeOf) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`isSealed`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/isSealed) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`keys`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`__lookupGetter__`Deprecated](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/__lookupGetter__) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`__lookupSetter__`Deprecated](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/__lookupSetter__) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`preventExtensions`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/preventExtensions) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| ES2015 behavior for non-object argument |      |
| --------------------------------------- | ---- |
|                                         |      |

| [`propertyIsEnumerable`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/propertyIsEnumerable) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`__proto__`Deprecated](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/proto) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`seal`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/seal) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`setPrototypeOf`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/setPrototypeOf) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`toLocaleString`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/toLocaleString) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`toString()`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/toString) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`valueOf`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/valueOf) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

| [`values`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/values) |      |
| ------------------------------------------------------------ | ---- |
|                                                              |      |

### Legend



## [相关链接](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Object#see_also)

- [初始化对象](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Operators/Object_initializer)