---
created: 2022-07-29T13:12:53 (UTC +08:00)
tags: []
source: http://nodejs.cn/api-v12/assert.html
author: 
---

# assert 断言 | Node.js API 文档

> ## Excerpt
> 中英对照

---
[中英对照](http://nodejs.cn/api-v12/assert/assert.html)

**源代码:** [lib/assert.js](https://github.com/nodejs/node/blob/v12.22.12/lib/assert.js)

`assert` 模块提供了一组用于验证不变量的断言函数。

### 严格断言模式[#](http://nodejs.cn/api-v12/assert.html#strict-assertion-mode)

[中英对照](http://nodejs.cn/api-v12/assert/strict_assertion_mode.html)

在严格断言模式下，非严格方法的行为与其对应的严格方法相同。 例如，[`assert.deepEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepequal_actual_expected_message) 的行为类似于 [`assert.deepStrictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepstrictequal_actual_expected_message)。

在严格断言模式下，对象的错误消息显示差异。 在旧版断言模式下，对象的错误消息显示对象，通常被截断。

使用严格断言模式：

```
const assert = require('assert').strict;
```

错误差异的示例：

```
const assert = require('assert').strict;

assert.deepEqual([[[1, 2, 3]], 4, 5], [[[1, 2, '3']], 4, 5]);
// AssertionError: Expected inputs to be strictly deep-equal:
// + actual - expected ... Lines skipped
//
//   [
//     [
// ...
//       2,
// +     3
// -     '3'
//     ],
// ...
//     5
//   ]
```

要停用颜色，则使用 `NO_COLOR` 或 `NODE_DISABLE_COLORS` 环境变量。 这也将停用交互式解释器中的颜色。

### 旧版断言模式[#](http://nodejs.cn/api-v12/assert.html#legacy-assertion-mode)

[中英对照](http://nodejs.cn/api-v12/assert/legacy_assertion_mode.html)

旧版断言模式在以下方法中使用[抽象相等比较](http://url.nodejs.cn/tiZhGn)：

-   [`assert.deepEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepequal_actual_expected_message)
-   [`assert.equal()`](http://nodejs.cn/api-v12/assert.html#assert_assert_equal_actual_expected_message)
-   [`assert.notDeepEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_notdeepequal_actual_expected_message)
-   [`assert.notEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_notequal_actual_expected_message)

要使用旧版断言模式：

```
const assert = require('assert');
```

尽可能改用[严格断言模式](http://nodejs.cn/api-v12/assert.html#assert_strict_assertion_mode)。 否则，[抽象相等比较](http://url.nodejs.cn/tiZhGn)可能会导致意外的结果。 对于 [`assert.deepEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepequal_actual_expected_message) 尤其如此，其比较规则很宽松：

```
// 注意：这不会抛出 AssertionError！
assert.deepEqual(/a/gi, new Date());
```

### assert.AssertionError 类[#](http://nodejs.cn/api-v12/assert.html#class-assertassertionerror)

[中英对照](http://nodejs.cn/api-v12/assert/class_assert_assertionerror.html)

-   继承自: [<errors.Error>](http://nodejs.cn/api/errors.html#class-error)

表示断言的失败。 `assert` 模块抛出的所有错误都是 `AssertionError` 类的实例。

#### `new assert.AssertionError(options)`[#](http://nodejs.cn/api-v12/assert.html#new-assertassertionerroroptions)

[中英对照](http://nodejs.cn/api-v12/assert/new_assert_assertionerror_options.html)

新增于: v0.1.21

-   `options` [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `message` [<string>](http://url.nodejs.cn/9Tw2bK) 如果提供，则错误消息将设置为此值。
    -   `actual` [<any>](http://url.nodejs.cn/6sTGdS) 错误实例上的 `actual` 属性。
    -   `expected` [<any>](http://url.nodejs.cn/6sTGdS) 错误实例上的 `expected` 属性。
    -   `operator` [<string>](http://url.nodejs.cn/9Tw2bK) 错误实例上的 `operator` 属性。
    -   `stackStartFn` [<Function>](http://url.nodejs.cn/ceTQa6) 如果提供，则生成的堆栈跟踪将省略此函数之前的帧。

`Error` 的子类，表示断言的失败。

所有实例都包含内置的 `Error` 属性（`message` 和 `name`），以及：

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS) 对于 [`assert.strictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_strictequal_actual_expected_message) 等方法，设置为 `actual` 参数。
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS) 对于 [`assert.strictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_strictequal_actual_expected_message) 等方法，设置为 `expected` 值。
-   `generatedMessage` [<boolean>](http://url.nodejs.cn/jFbvuT) 指示消息是否是自动生成的 (`true`)。
-   `code` [<string>](http://url.nodejs.cn/9Tw2bK) 值始终为 `ERR_ASSERTION`，以表明该错误是断言错误。
-   `operator` [<string>](http://url.nodejs.cn/9Tw2bK) 设置为传入的运算符值。

```
const assert = require('assert');

// 生成 AssertionError，以便稍后比较错误信息：
const { message } = new assert.AssertionError({
  actual: 1,
  expected: 2,
  operator: 'strictEqual'
});

// 验证错误的输出：
try {
  assert.strictEqual(1, 2);
} catch (err) {
  assert(err instanceof assert.AssertionError);
  assert.strictEqual(err.message, message);
  assert.strictEqual(err.name, 'AssertionError');
  assert.strictEqual(err.actual, 1);
  assert.strictEqual(err.expected, 2);
  assert.strictEqual(err.code, 'ERR_ASSERTION');
  assert.strictEqual(err.operator, 'strictEqual');
  assert.strictEqual(err.generatedMessage, true);
}
```

### `assert.CallTracker` 类[#](http://nodejs.cn/api-v12/assert.html#class-assertcalltracker)

[中英对照](http://nodejs.cn/api-v12/assert/class_assert_calltracker.html)

新增于: v12.19.0

此功能目前处于实验阶段，行为可能仍会发生变化。

#### `new assert.CallTracker()`[#](http://nodejs.cn/api-v12/assert.html#new-assertcalltracker)

[中英对照](http://nodejs.cn/api-v12/assert/new_assert_calltracker.html)

新增于: v12.19.0

创建新的 [`CallTracker`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_calltracker) 对象，其可用于跟踪函数是否被调用了特定次数。 必须调用 `tracker.verify()` 才能进行验证。 通常的模式是在 [`process.on('exit')`](http://nodejs.cn/api-v12/process.html#process_event_exit) 句柄中调用。

```
const assert = require('assert');

const tracker = new assert.CallTracker();

function func() {}

// callfunc() 必须在 tracker.verify() 之前恰好被调用 1 次。
const callsfunc = tracker.calls(func, 1);

callsfunc();

// 调用 tracker.verify() 并验证是否所有 tracker.calls() 函数都已被准确调用。
process.on('exit', () => {
  tracker.verify();
});
```

#### `tracker.calls([fn][, exact])`[#](http://nodejs.cn/api-v12/assert.html#trackercallsfn-exact)

[中英对照](http://nodejs.cn/api-v12/assert/tracker_calls_fn_exact.html)

新增于: v12.19.0

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6) **Default** 无操作的函数。
-   `exact` [<number>](http://url.nodejs.cn/SXbo1v) **Default** `1`。
-   返回: [<Function>](http://url.nodejs.cn/ceTQa6) 封装 `fn`。

预计封装函数将被精确调用 `exact` 次。 如果在调用 [`tracker.verify()`](http://nodejs.cn/api-v12/assert.html#assert_tracker_verify) 时函数没有被精确调用 `exact` 次，那么 [`tracker.verify()`](http://nodejs.cn/api-v12/assert.html#assert_tracker_verify) 将抛出错误。

```
const assert = require('assert');

// 创建调用跟踪器。
const tracker = new assert.CallTracker();

function func() {}

// 返回封装 func() 的函数，其必须在 tracker.verify() 之前调用准确次数。
const callsfunc = tracker.calls(func);
```

#### `tracker.report()`[#](http://nodejs.cn/api-v12/assert.html#trackerreport)

[中英对照](http://nodejs.cn/api-v12/assert/tracker_report.html)

新增于: v12.19.0

-   返回: [<Array>](http://url.nodejs.cn/ZJSz23) 包含有关 [`tracker.calls()`](http://nodejs.cn/api-v12/assert.html#assert_tracker_calls_fn_exact) 返回的封装函数的信息的对象的数组。
-   对象 [<Object>](http://url.nodejs.cn/jzn6Ao)
    -   `message` [<string>](http://url.nodejs.cn/9Tw2bK)
    -   `actual` [<number>](http://url.nodejs.cn/SXbo1v) 函数被调用的实际次数。
    -   `expected` [<number>](http://url.nodejs.cn/SXbo1v) 函数预期被调用的次数。
    -   `operator` [<string>](http://url.nodejs.cn/9Tw2bK) 被封装的函数的名称。
    -   `stack` [<Object>](http://url.nodejs.cn/jzn6Ao) 函数的堆栈跟踪。

数组包含有关未调用预期次数的函数的预期和实际调用次数的信息。

```
const assert = require('assert');

// 创建调用跟踪器。
const tracker = new assert.CallTracker();

function func() {}

function foo() {}

// 返回封装 func() 的函数，其必须在 tracker.verify() 之前调用准确次数。
const callsfunc = tracker.calls(func, 2);

// 返回包含 callfunc() 信息的数组()
tracker.report();
// [
//  {
//    message: 'Expected the func function to be executed 2 time(s) but was
//    executed 0 time(s).',
//    actual: 0,
//    expected: 2,
//    operator: 'func',
//    stack: stack trace
//  }
// ]
```

#### `tracker.verify()`[#](http://nodejs.cn/api-v12/assert.html#trackerverify)

[中英对照](http://nodejs.cn/api-v12/assert/tracker_verify.html)

新增于: v12.19.0

遍历传给 [`tracker.calls()`](http://nodejs.cn/api-v12/assert.html#assert_tracker_calls_fn_exact) 的函数列表，对于未按预期调用次数的函数将抛出错误。

```
const assert = require('assert');

// 创建调用跟踪器。
const tracker = new assert.CallTracker();

function func() {}

// 返回封装 func() 的函数，其必须在 tracker.verify() 之前调用准确次数。
const callsfunc = tracker.calls(func, 2);

callsfunc();

// 会抛出错误，因为 callfunc() 只被调用了一次。
tracker.verify();
```

### `assert(value[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertvalue-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_value_message.html)

新增于: v0.5.9

-   `value` [<any>](http://url.nodejs.cn/6sTGdS) 检查为真的输入。
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

[`assert.ok()`](http://nodejs.cn/api-v12/assert.html#assert_assert_ok_value_message) 的别名。

### `assert.deepEqual(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertdeepequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_deepequal_actual_expected_message.html)

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

**严格断言模式**

[`assert.deepStrictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepstrictequal_actual_expected_message) 的别名。

**旧版断言模式**

测试 `actual` 和 `expected` 参数之间的深度相等。 考虑使用 [`assert.deepStrictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepstrictequal_actual_expected_message) 代替。 [`assert.deepEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepequal_actual_expected_message) 可能产生意外的结果。

深度相等意味着子对象的可枚举"自有"属性也按照以下规则递归地评估。

#### 比较详情[#](http://nodejs.cn/api-v12/assert.html#comparison-details)

[中英对照](http://nodejs.cn/api-v12/assert/comparison_details.html)

-   对象的[类型标签](http://url.nodejs.cn/NVhBn1)应该是一样的。
-   仅考虑[自有属性](http://url.nodejs.cn/hTNJUJ)。
-   [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 名称和消息总是被比较，即使它们不是可枚举的属性。
-   [对象封装器](http://url.nodejs.cn/hem2hq)作为对象和未封装的值进行比较。
-   `Object` 属性是无序比较的。
-   [`Map`](http://url.nodejs.cn/EnuJtG) 键和 [`Set`](http://url.nodejs.cn/yej4PC) 项是无序比较的。
-   当双方不同或双方遇到循环引用时，则递归停止。
-   实现不测试对象的 [`[[Prototype]]`](http://url.nodejs.cn/yzA3TL)。
-   不比较 [`Symbol`](http://url.nodejs.cn/SyrFMg) 属性。
-   [`WeakMap`](http://url.nodejs.cn/JkfoVY) 和 [`WeakSet`](http://url.nodejs.cn/gsMyy2) 的比较不依赖于它们的值。

以下示例不会抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，因为[抽象相等比较](http://url.nodejs.cn/tiZhGn)（`==`）认为原始值相等。

```
// 注意：这不会抛出 AssertionError！
assert.deepEqual('+00000000', false);
```

“深度”相等意味着子对象的可枚举"自有"属性也被评估：

```
const assert = require('assert');

const obj1 = {
  a: {
    b: 1
  }
};
const obj2 = {
  a: {
    b: 2
  }
};
const obj3 = {
  a: {
    b: 1
  }
};
const obj4 = Object.create(obj1);

assert.deepEqual(obj1, obj1);
// OK

// b 的值不同：
assert.deepEqual(obj1, obj2);
// AssertionError: { a: { b: 1 } } deepEqual { a: { b: 2 } }

assert.deepEqual(obj1, obj3);
// OK

// 原型被忽略：
assert.deepEqual(obj1, obj4);
// AssertionError: { a: { b: 1 } } deepEqual {}
```

如果值不相等，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。

### `assert.deepStrictEqual(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertdeepstrictequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_deepstrictequal_actual_expected_message.html)

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

测试 `actual` 和 `expected` 参数之间的深度相等。 "深度"相等意味着子对象的可枚举"自有"属性也按照以下规则递归地评估。

#### 比较详情[#](http://nodejs.cn/api-v12/assert.html#comparison-details_1)

[中英对照](http://nodejs.cn/api-v12/assert/comparison_details_1.html)

-   使用 [`Object.is()`](http://url.nodejs.cn/fQqJVi) 使用的 [SameValue 比较](http://url.nodejs.cn/25ULs2)来比较原始值。
-   对象的[类型标签](http://url.nodejs.cn/NVhBn1)应该是一样的。
-   对象的 [`[[Prototype]]`](http://url.nodejs.cn/yzA3TL) 使用[严格相等比较](http://url.nodejs.cn/jFa5Tv)进行比较。
-   仅考虑[自有属性](http://url.nodejs.cn/hTNJUJ)。
-   [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 名称和消息总是被比较，即使它们不是可枚举的属性。
-   也比较了可枚举的自有 [`Symbol`](http://url.nodejs.cn/SyrFMg) 属性。
-   [对象封装器](http://url.nodejs.cn/hem2hq)作为对象和未封装的值进行比较。
-   `Object` 属性是无序比较的。
-   [`Map`](http://url.nodejs.cn/EnuJtG) 键和 [`Set`](http://url.nodejs.cn/yej4PC) 项是无序比较的。
-   当双方不同或双方遇到循环引用时，则递归停止。
-   [`WeakMap`](http://url.nodejs.cn/JkfoVY) 和 [`WeakSet`](http://url.nodejs.cn/gsMyy2) 的比较不依赖于它们的值。 有关更多详细信息，请参见下文。

```
const assert = require('assert').strict;

// 这失败了，因为 1 !== '1'。
assert.deepStrictEqual({ a: 1 }, { a: '1' });
// AssertionError: Expected inputs to be strictly deep-equal:
// + actual - expected
//
//   {
// +   a: 1
// -   a: '1'
//   }

// 以下对象没有自有的属性
const date = new Date();
const object = {};
const fakeDate = {};
Object.setPrototypeOf(fakeDate, Date.prototype);

// 不同的原型：
assert.deepStrictEqual(object, fakeDate);
// AssertionError: Expected inputs to be strictly deep-equal:
// + actual - expected
//
// + {}
// - Date {}

// 不同的类型标签：
assert.deepStrictEqual(date, fakeDate);
// AssertionError: Expected inputs to be strictly deep-equal:
// + actual - expected
//
// + 2018-04-26T00:49:08.604Z
// - Date {}

assert.deepStrictEqual(NaN, NaN);
// OK，因为 SameValue 比较

// 不同的解封装数字：
assert.deepStrictEqual(new Number(1), new Number(2));
// AssertionError: Expected inputs to be strictly deep-equal:
// + actual - expected
//
// + [Number: 1]
// - [Number: 2]

assert.deepStrictEqual(new String('foo'), Object('foo'));
// OK，因为对象和字符串在解封装时是相同的。

assert.deepStrictEqual(-0, -0);
// OK

// 使用 SameValue 比较的不同零：
assert.deepStrictEqual(0, -0);
// AssertionError: Expected inputs to be strictly deep-equal:
// + actual - expected
//
// + 0
// - -0

const symbol1 = Symbol();
const symbol2 = Symbol();
assert.deepStrictEqual({ [symbol1]: 1 }, { [symbol1]: 1 });
// OK，因为它是两个对象上的相同符号。

assert.deepStrictEqual({ [symbol1]: 1 }, { [symbol2]: 1 });
// AssertionError [ERR_ASSERTION]: Inputs identical but not reference equal:
//
// {
//   [Symbol()]: 1
// }

const weakMap1 = new WeakMap();
const weakMap2 = new WeakMap([[{}, {}]]);
const weakMap3 = new WeakMap();
weakMap3.unequal = true;

assert.deepStrictEqual(weakMap1, weakMap2);
// OK，因为无法比较条目

// 失败，因为 weakMap3 有一个 weakMap1 不包含的属性：
assert.deepStrictEqual(weakMap1, weakMap3);
// AssertionError: Expected inputs to be strictly deep-equal:
// + actual - expected
//
//   WeakMap {
// +   [items unknown]
// -   [items unknown],
// -   unequal: true
//   }
```

如果值不相等，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 `AssertionError`。

### `assert.doesNotMatch(string, regexp[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertdoesnotmatchstring-regexp-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_doesnotmatch_string_regexp_message.html)

新增于: v12.16.0

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `regexp` [<RegExp>](http://url.nodejs.cn/G38byW)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

期望 `string` 输入与正则表达式不匹配。

此特性目前处于实验阶段，名称可能会更改，也可能会再次完全删除。

```
const assert = require('assert').strict;

assert.doesNotMatch('I will fail', /fail/);
// AssertionError [ERR_ASSERTION]: The input was expected to not match the ...

assert.doesNotMatch(123, /pass/);
// AssertionError [ERR_ASSERTION]: The "string" argument must be of type string.

assert.doesNotMatch('I will pass', /different/);
// OK
```

如果值匹配，或者 `string` 参数的类型不是 `string`，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。

### `assert.doesNotReject(asyncFn[, error][, message])`[#](http://nodejs.cn/api-v12/assert.html#assertdoesnotrejectasyncfn-error-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_doesnotreject_asyncfn_error_message.html)

新增于: v10.0.0

-   `asyncFn` [<Function>](http://url.nodejs.cn/ceTQa6) | [<Promise>](http://url.nodejs.cn/ri1kj8)
-   `error` [<RegExp>](http://url.nodejs.cn/G38byW) | [<Function>](http://url.nodejs.cn/ceTQa6)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK)

等待 `asyncFn` promise，或者，如果 `asyncFn` 是函数，则立即调用该函数并等待返回的 promise 完成。 然后会检查 promise 是否没有被拒绝。

如果 `asyncFn` 是函数并且它同步抛出错误，则 `assert.doesNotReject()` 将返回使用使用该错误拒绝的 `Promise`。 如果函数没有返回 promise，则 `assert.doesNotReject()` 将返回使用 [`ERR_INVALID_RETURN_VALUE`](http://nodejs.cn/api-v12/errors.html#errors_err_invalid_return_value) 错误拒绝的 `Promise`。 在这两种情况下，都会跳过错误句柄。

使用 `assert.doesNotReject()` 实际上没有用，因为捕获拒绝然后再次拒绝它几乎没有什么好处。 相反，请考虑在特定代码路径旁边添加不应拒绝的注释，并尽可能使错误消息具有表现力。

如果指定，则 `error` 可以是 [`Class`](http://url.nodejs.cn/5wDLcp)、[`RegExp`](http://url.nodejs.cn/tbQJCP) 或验证函数。 有关详细信息，请参阅 [`assert.throws()`](http://nodejs.cn/api-v12/assert.html#assert_assert_throws_fn_error_message)。

除了等待完成的异步性质外，其行为与 [`assert.doesNotThrow()`](http://nodejs.cn/api-v12/assert.html#assert_assert_doesnotthrow_fn_error_message) 相同。

```
(async () => {
  await assert.doesNotReject(
    async () => {
      throw new TypeError('Wrong value');
    },
    SyntaxError
  );
})();
```

```
assert.doesNotReject(Promise.reject(new TypeError('Wrong value')))
  .then(() => {
    // ...
  });
```

### `assert.doesNotThrow(fn[, error][, message])`[#](http://nodejs.cn/api-v12/assert.html#assertdoesnotthrowfn-error-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_doesnotthrow_fn_error_message.html)

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6)
-   `error` [<RegExp>](http://url.nodejs.cn/G38byW) | [<Function>](http://url.nodejs.cn/ceTQa6)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK)

断言函数 `fn` 不会抛出错误。

使用 `assert.doesNotThrow()` 实际上没有用，因为捕获错误然后重新抛出它没有任何好处。 相反，请考虑在不应该抛出的特定代码路径旁边添加注释，并尽可能保持错误消息的表现力。

当 `assert.doesNotThrow()` 被调用时，它会立即调用 `fn` 函数。

如果抛出错误并且它与 `error` 参数指定的类型相同，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。 如果错误属于不同类型，或者 `error` 参数未定义，则错误将传播回调用者。

如果指定，则 `error` 可以是 [`Class`](http://url.nodejs.cn/5wDLcp)、[`RegExp`](http://url.nodejs.cn/tbQJCP) 或验证函数。 有关详细信息，请参阅 [`assert.throws()`](http://nodejs.cn/api-v12/assert.html#assert_assert_throws_fn_error_message)。

例如，以下将抛出 [`TypeError`](http://nodejs.cn/api-v12/errors.html#errors_class_typeerror)，因为断言中没有匹配的错误类型：

```
assert.doesNotThrow(
  () => {
    throw new TypeError('Wrong value');
  },
  SyntaxError
);
```

但是，以下将导致使用消息 'Got unwanted exception...' 的 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)：

```
assert.doesNotThrow(
  () => {
    throw new TypeError('Wrong value');
  },
  TypeError
);
```

如果抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror) 并且为 `message` 参数提供了值，则 `message` 的值将附加到 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror) 消息：

```
assert.doesNotThrow(
  () => {
    throw new TypeError('Wrong value');
  },
  /Wrong value/,
  'Whoops'
);
// 抛出: AssertionError: Got unwanted exception: Whoops
```

### `assert.equal(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_equal_actual_expected_message.html)

新增于: v0.1.21

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

**严格断言模式**

[`assert.strictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_strictequal_actual_expected_message) 的别名。

**旧版断言模式**

使用[抽象相等比较](http://url.nodejs.cn/tiZhGn)（`==`）测试 `actual` 和 `expected` 参数之间的浅层强制相等。

```
const assert = require('assert');

assert.equal(1, 1);
// OK, 1 == 1
assert.equal(1, '1');
// OK, 1 == '1'

assert.equal(1, 2);
// AssertionError: 1 == 2
assert.equal({ a: { b: 1 } }, { a: { b: 1 } });
// AssertionError: { a: { b: 1 } } == { a: { b: 1 } }
```

如果值不相等，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 `AssertionError`。

### `assert.fail([message])`[#](http://nodejs.cn/api-v12/assert.html#assertfailmessage)

[中英对照](http://nodejs.cn/api-v12/assert/assert_fail_message.html)

新增于: v0.1.21

-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x) **默认值:** `'Failed'`

抛出带有提供的错误消息或默认错误消息的 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。

```
const assert = require('assert').strict;

assert.fail();
// AssertionError [ERR_ASSERTION]: Failed

assert.fail('boom');
// AssertionError [ERR_ASSERTION]: boom

assert.fail(new TypeError('need array'));
// TypeError: need array
```

可以使用带有两个以上参数的 `assert.fail()`，但不推荐使用。 有关更多详细信息，请参见下文。

### `assert.fail(actual, expected[, message[, operator[, stackStartFn]]])`[#](http://nodejs.cn/api-v12/assert.html#assertfailactual-expected-message-operator-stackstartfn)

[中英对照](http://nodejs.cn/api-v12/assert/assert_fail_actual_expected_message_operator_stackstartfn.html)

[稳定性: 0](http://nodejs.cn/api/documentation.html#stability-index) - 弃用: 改为使用 `assert.fail([message])` 或其他 assert 函数。

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)
-   `operator` [<string>](http://url.nodejs.cn/9Tw2bK) **默认值:** `'!='`
-   `stackStartFn` [<Function>](http://url.nodejs.cn/ceTQa6) **默认值:** `assert.fail`

如果 `message` 为假，则错误消息设置为由提供的 `operator` 分隔的 `actual` 和 `expected` 的值。 如果只提供了两个 `actual` 和 `expected` 参数，则 `operator` 将默认为 `'!='`。 如果 `message` 作为第三个参数提供，则它将用作错误消息，其他参数将作为抛出对象的属性存储。 如果提供了 `stackStartFn`，则该函数之上的所有堆栈帧都将从堆栈跟踪中删除（参见 [`Error.captureStackTrace`](http://nodejs.cn/api-v12/errors.html#errors_error_capturestacktrace_targetobject_constructoropt)）。 如果没有给出参数，则将使用默认消息 `Failed`。

```
const assert = require('assert').strict;

assert.fail('a', 'b');
// AssertionError [ERR_ASSERTION]: 'a' != 'b'

assert.fail(1, 2, undefined, '>');
// AssertionError [ERR_ASSERTION]: 1 > 2

assert.fail(1, 2, 'fail');
// AssertionError [ERR_ASSERTION]: fail

assert.fail(1, 2, 'whoops', '>');
// AssertionError [ERR_ASSERTION]: whoops

assert.fail(1, 2, new TypeError('need array'));
// TypeError: need array
```

在后三种情况下，`actual`、`expected` 和 `operator` 对错误消息没有影响。

使用 `stackStartFn` 截断异常堆栈跟踪的示例：

```
function suppressFrame() {
  assert.fail('a', 'b', undefined, '!==', suppressFrame);
}
suppressFrame();
// AssertionError [ERR_ASSERTION]: 'a' !== 'b'
//     at repl:1:1
//     at ContextifyScript.Script.runInThisContext (vm.js:44:33)
//     ...
```

### `assert.ifError(value)`[#](http://nodejs.cn/api-v12/assert.html#assertiferrorvalue)

[中英对照](http://nodejs.cn/api-v12/assert/assert_iferror_value.html)

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)

如果 `value` 不是 `undefined` 或 `null`，则抛出 `value`。 这在回调中测试 `error` 参数时很有用。 堆栈跟踪包含来自传给 `ifError()` 的错误的所有帧，包括 `ifError()` 本身的潜在新帧。

```
const assert = require('assert').strict;

assert.ifError(null);
// OK
assert.ifError(0);
// AssertionError [ERR_ASSERTION]: ifError got unwanted exception: 0
assert.ifError('error');
// AssertionError [ERR_ASSERTION]: ifError got unwanted exception: 'error'
assert.ifError(new Error());
// AssertionError [ERR_ASSERTION]: ifError got unwanted exception: Error

// 创建一些随机错误帧。
let err;
(function errorFrame() {
  err = new Error('test error');
})();

(function ifErrorFrame() {
  assert.ifError(err);
})();
// AssertionError [ERR_ASSERTION]: ifError got unwanted exception: test error
//     at ifErrorFrame
//     at errorFrame
```

### `assert.match(string, regexp[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertmatchstring-regexp-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_match_string_regexp_message.html)

新增于: v12.16.0

-   `string` [<string>](http://url.nodejs.cn/9Tw2bK)
-   `regexp` [<RegExp>](http://url.nodejs.cn/G38byW)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

期望 `string` 输入与正则表达式匹配。

此特性目前处于实验阶段，名称可能会更改，也可能会再次完全删除。

```
const assert = require('assert').strict;

assert.match('I will fail', /pass/);
// AssertionError [ERR_ASSERTION]: The input did not match the regular ...

assert.match(123, /pass/);
// AssertionError [ERR_ASSERTION]: The "string" argument must be of type string.

assert.match('I will pass', /pass/);
// OK
```

如果值不匹配，或者 `string` 参数的类型不是 `string`，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。

### `assert.notDeepEqual(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertnotdeepequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_notdeepequal_actual_expected_message.html)

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

**严格断言模式**

[`assert.notDeepStrictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_notdeepstrictequal_actual_expected_message) 的别名。

**旧版断言模式**

测试任何深度不相等。 [`assert.deepEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepequal_actual_expected_message) 的相反。

```
const assert = require('assert');

const obj1 = {
  a: {
    b: 1
  }
};
const obj2 = {
  a: {
    b: 2
  }
};
const obj3 = {
  a: {
    b: 1
  }
};
const obj4 = Object.create(obj1);

assert.notDeepEqual(obj1, obj1);
// AssertionError: { a: { b: 1 } } notDeepEqual { a: { b: 1 } }

assert.notDeepEqual(obj1, obj2);
// OK

assert.notDeepEqual(obj1, obj3);
// AssertionError: { a: { b: 1 } } notDeepEqual { a: { b: 1 } }

assert.notDeepEqual(obj1, obj4);
// OK
```

如果值深度相等，则会抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 `AssertionError`。

### `assert.notDeepStrictEqual(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertnotdeepstrictequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_notdeepstrictequal_actual_expected_message.html)

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

检验深度严格不相等。 [`assert.deepStrictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_deepstrictequal_actual_expected_message) 的相反。

```
const assert = require('assert').strict;

assert.notDeepStrictEqual({ a: 1 }, { a: '1' });
// OK
```

如果值是深度且严格相等的，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。

### `assert.notEqual(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertnotequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_notequal_actual_expected_message.html)

新增于: v0.1.21

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

**严格断言模式**

[`assert.notStrictEqual()`](http://nodejs.cn/api-v12/assert.html#assert_assert_notstrictequal_actual_expected_message) 的别名。

**旧版断言模式**

```
const assert = require('assert');

assert.notEqual(1, 2);
// OK

assert.notEqual(1, 1);
// AssertionError: 1 != 1

assert.notEqual(1, '1');
// AssertionError: 1 != '1'
```

如果值相等，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 `AssertionError`。

### `assert.notStrictEqual(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertnotstrictequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_notstrictequal_actual_expected_message.html)

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

测试由 [SameValue 比较](http://url.nodejs.cn/25ULs2) 确定的 `actual` 和 `expected` 参数之间的严格不相等。

```
const assert = require('assert').strict;

assert.notStrictEqual(1, 2);
// OK

assert.notStrictEqual(1, 1);
// AssertionError [ERR_ASSERTION]: Expected "actual" to be strictly unequal to:
//
// 1

assert.notStrictEqual(1, '1');
// OK
```

如果值严格相等，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 `AssertionError`。

### `assert.ok(value[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertokvalue-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_ok_value_message.html)

-   `value` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

测试 `value` 是否为真。 相当于 `assert.equal(!!value, true, message)`。

如果 `value` 不是真值，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果 `message` 参数为 `undefined`，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 `AssertionError`。 如果根本没有传入任何参数，则 `message` 将设置为字符串：``'No value argument passed to `assert.ok()`'``。

请注意，在 `repl` 中，错误消息将与文件中抛出的错误消息不同！ 有关更多详细信息，请参见下文。

```
const assert = require('assert').strict;

assert.ok(true);
// OK
assert.ok(1);
// OK

assert.ok();
// AssertionError: No value argument passed to `assert.ok()`

assert.ok(false, 'it\'s false');
// AssertionError: it's false

// 在交互式解释器中：
assert.ok(typeof 123 === 'string');
// AssertionError: false == true

// 在文件中（例如 test.js）：
assert.ok(typeof 123 === 'string');
// AssertionError: The expression evaluated to a falsy value:
//
//   assert.ok(typeof 123 === 'string')

assert.ok(false);
// AssertionError: The expression evaluated to a falsy value:
//
//   assert.ok(false)

assert.ok(0);
// AssertionError: The expression evaluated to a falsy value:
//
//   assert.ok(0)

// 使用 `assert()` 的工作一样：
assert(0);
// AssertionError: The expression evaluated to a falsy value:
//
//   assert(0)
```

### `assert.rejects(asyncFn[, error][, message])`[#](http://nodejs.cn/api-v12/assert.html#assertrejectsasyncfn-error-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_rejects_asyncfn_error_message.html)

新增于: v10.0.0

-   `asyncFn` [<Function>](http://url.nodejs.cn/ceTQa6) | [<Promise>](http://url.nodejs.cn/ri1kj8)
-   `error` [<RegExp>](http://url.nodejs.cn/G38byW) | [<Function>](http://url.nodejs.cn/ceTQa6) | [<Object>](http://url.nodejs.cn/jzn6Ao) | [<Error>](http://url.nodejs.cn/qZ873x)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK)

等待 `asyncFn` promise，或者，如果 `asyncFn` 是函数，则立即调用该函数并等待返回的 promise 完成。 然后将检查 promise 是否被拒绝。

如果 `asyncFn` 是函数并且它同步抛出错误，则 `assert.rejects()` 将返回使用使用该错误拒绝的 `Promise`。 如果函数没有返回 promise，则 `assert.rejects()` 将返回使用 [`ERR_INVALID_RETURN_VALUE`](http://nodejs.cn/api-v12/errors.html#errors_err_invalid_return_value) 错误拒绝的 `Promise`。 在这两种情况下，都会跳过错误句柄。

除了等待完成的异步性质外，其行为与 [`assert.throws()`](http://nodejs.cn/api-v12/assert.html#assert_assert_throws_fn_error_message) 相同。

如果指定，则 `error` 可以是 [`Class`](http://url.nodejs.cn/5wDLcp)、[`RegExp`](http://url.nodejs.cn/tbQJCP)、验证函数、每个属性将被测试的对象，或者每个属性（包括不可枚举的 `message` 和 `name` 属性）将被测试的错误实例。

如果指定，则 `message` 将是 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror) 提供的消息（如果 `asyncFn` 没有被拒绝）。

```
(async () => {
  await assert.rejects(
    async () => {
      throw new TypeError('Wrong value');
    },
    {
      name: 'TypeError',
      message: 'Wrong value'
    }
  );
})();
```

```
(async () => {
  await assert.rejects(
    async () => {
      throw new TypeError('Wrong value');
    },
    (err) => {
      assert.strictEqual(err.name, 'TypeError');
      assert.strictEqual(err.message, 'Wrong value');
      return true;
    }
  );
})();
```

```
assert.rejects(
  Promise.reject(new Error('Wrong value')),
  Error
).then(() => {
  // ...
});
```

`error` 不能是字符串。 如果提供字符串作为第二个参数，则假定 `error` 被省略，而该字符串将用于 `message`。 这可能会导致容易遗漏的错误。 如果考虑使用字符串作为第二个参数，则请仔细阅读 [`assert.throws()`](http://nodejs.cn/api-v12/assert.html#assert_assert_throws_fn_error_message) 中的示例。

### `assert.strictEqual(actual, expected[, message])`[#](http://nodejs.cn/api-v12/assert.html#assertstrictequalactual-expected-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_strictequal_actual_expected_message.html)

-   `actual` [<any>](http://url.nodejs.cn/6sTGdS)
-   `expected` [<any>](http://url.nodejs.cn/6sTGdS)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK) | [<Error>](http://url.nodejs.cn/qZ873x)

测试由 [SameValue 比较](http://url.nodejs.cn/25ULs2) 确定的 `actual` 和 `expected` 参数之间的严格相等。

```
const assert = require('assert').strict;

assert.strictEqual(1, 2);
// AssertionError [ERR_ASSERTION]: Expected inputs to be strictly equal:
//
// 1 !== 2

assert.strictEqual(1, 1);
// OK

assert.strictEqual('Hello foobar', 'Hello World!');
// AssertionError [ERR_ASSERTION]: Expected inputs to be strictly equal:
// + actual - expected
//
// + 'Hello foobar'
// - 'Hello World!'
//          ^

const apples = 1;
const oranges = 2;
assert.strictEqual(apples, oranges, `apples ${apples} !== oranges ${oranges}`);
// AssertionError [ERR_ASSERTION]: apples 1 !== oranges 2

assert.strictEqual(1, '1', new TypeError('Inputs are not identical'));
// TypeError: Inputs are not identical
```

如果值不严格相等，则抛出 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)，其 `message` 属性设置为等于 `message` 参数的值。 如果未定义 `message` 参数，则分配默认错误消息。 如果 `message` 参数是 [`Error`](http://nodejs.cn/api-v12/errors.html#errors_class_error) 的实例，则将抛出错误而不是 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror)。

### `assert.throws(fn[, error][, message])`[#](http://nodejs.cn/api-v12/assert.html#assertthrowsfn-error-message)

[中英对照](http://nodejs.cn/api-v12/assert/assert_throws_fn_error_message.html)

-   `fn` [<Function>](http://url.nodejs.cn/ceTQa6)
-   `error` [<RegExp>](http://url.nodejs.cn/G38byW) | [<Function>](http://url.nodejs.cn/ceTQa6) | [<Object>](http://url.nodejs.cn/jzn6Ao) | [<Error>](http://url.nodejs.cn/qZ873x)
-   `message` [<string>](http://url.nodejs.cn/9Tw2bK)

期望函数 `fn` 抛出错误。

如果指定，则 `error` 可以是 [`Class`](http://url.nodejs.cn/5wDLcp)、[`RegExp`](http://url.nodejs.cn/tbQJCP)、验证函数、其中每个属性都将进行严格深度相等测试的验证对象，或者其中每个属性（包括不可枚举的 `message`和 `name` 属性）都将进行严格深度相等测试的错误实例。 使用对象时，也可以使用正则表达式来验证字符串属性。 有关示例，请参见下文。

如果指定，且如果 `fn` 调用失败或错误验证失败，则 `message` 将附加到 `AssertionError` 提供的消息。

自定义验证对象/错误实例：

```
const err = new TypeError('Wrong value');
err.code = 404;
err.foo = 'bar';
err.info = {
  nested: true,
  baz: 'text'
};
err.reg = /abc/i;

assert.throws(
  () => {
    throw err;
  },
  {
    name: 'TypeError',
    message: 'Wrong value',
    info: {
      nested: true,
      baz: 'text'
    }
    // 只会测试验证对象上的属性。
    // 使用嵌套对象需要存在所有属性。
    // 否则验证将失败。
  }
);

// 使用正则表达式验证错误属性：
assert.throws(
  () => {
    throw err;
  },
  {
    // `name` 和 `message` 属性是字符串，在这些属性上使用正则表达式将匹配字符串。
    // 如果失败，则会抛出错误。
    name: /^TypeError$/,
    message: /Wrong/,
    foo: 'bar',
    info: {
      nested: true,
      // 不能对嵌套属性使用正则表达式！
      baz: 'text'
    },
    // `reg` 属性包含正则表达式，只有当验证对象包含相同的正则表达式时，它才会通过。
    reg: /abc/i
  }
);

// 由于不同的 `message` 和 `name` 属性而失败：
assert.throws(
  () => {
    const otherErr = new Error('Not found');
    // 将所有可枚举属性从 `err` 复制到 `otherErr`。
    for (const [key, value] of Object.entries(err)) {
      otherErr[key] = value;
    }
    throw otherErr;
  },
  // 当使用错误作为验证对象时，错误的 `message` 和 `name` 属性也将被检查。
  err
);
```

使用构造函数验证 instanceof：

```
assert.throws(
  () => {
    throw new Error('Wrong value');
  },
  Error
);
```

使用 [`RegExp`](http://url.nodejs.cn/tbQJCP) 验证错误消息：

使用正则表达式在错误对象上运行 `.toString`，因此还将包含错误名称。

```
assert.throws(
  () => {
    throw new Error('Wrong value');
  },
  /^Error: Wrong value$/
);
```

自定义错误验证：

该函数必须返回 `true` 以指示通过了所有内部验证。 否则它将因 [`AssertionError`](http://nodejs.cn/api-v12/assert.html#assert_class_assert_assertionerror) 而失败。

```
assert.throws(
  () => {
    throw new Error('Wrong value');
  },
  (err) => {
    assert(err instanceof Error);
    assert(/value/.test(err));
    // 避免从验证函数返回除 `true` 之外的任何内容。
    // 否则，不清楚验证的哪一部分失败。而是，抛出有关失败的特定验证的错误（如本示例中所做的那样），并尽可能多地向该错误添加有用的调试信息。
    return true;
  },
  'unexpected error'
);
```

`error` 不能是字符串。 如果提供字符串作为第二个参数，则假定 `error` 被省略，而该字符串将用于 `message`。 这可能会导致容易遗漏的错误。 使用与抛出的错误消息相同的消息将导致 `ERR_AMBIGUOUS_ARGUMENT` 错误。 如果考虑使用字符串作为第二个参数，则请仔细阅读下面的示例：

```
function throwingFirst() {
  throw new Error('First');
}

function throwingSecond() {
  throw new Error('Second');
}

function notThrowing() {}

// 第二个参数是字符串，且输入函数抛出错误。
// 第一种情况不会抛出错误，因为它与输入函数抛出的错误消息不匹配！
assert.throws(throwingFirst, 'Second');
// 在下一个示例中，该消息与错误消息相比没有任何好处，并且由于不清楚用户是否打算实际匹配错误消息，Node.js 会抛出 `ERR_AMBIGUOUS_ARGUMENT` 错误。
assert.throws(throwingSecond, 'Second');
// TypeError [ERR_AMBIGUOUS_ARGUMENT]

// 该字符串仅在函数不抛出的情况下（作为消息）使用：
assert.throws(notThrowing, 'Second');
// AssertionError [ERR_ASSERTION]: Missing expected exception: Second

// 如果它旨在匹配错误消息，则执行以下操作：
// 它不会抛出错误，因为错误消息匹配。
assert.throws(throwingSecond, /Second$/);

// 如果错误消息不匹配，则抛出 AssertionError。
assert.throws(throwingFirst, /Second$/);
// AssertionError [ERR_ASSERTION]
```

由于容易混淆的符号，请避免将字符串作为第二个参数。
