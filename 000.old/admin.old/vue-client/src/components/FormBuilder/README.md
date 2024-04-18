# FormBuilder

> 表单构造器

## Row Attributes

| 参数    | 说明                                  | 类型   | 可选值                                      | 默认值 |
| ------- | ------------------------------------- | ------ | ------------------------------------------- | ------ |
| gutter  | 栅格间隔                              | number | —                                           | 0      |
| type    | 布局模式，可选 flex，现代浏览器下有效 | string | —                                           | —      |
| justify | flex 布局下的水平排列方式             | string | start/end/center/space-around/space-between | start  |
| align   | flex 布局下的垂直排列方式             | string | top/middle/bottom                           | —      |
| tag     | 自定义元素标签                        | string | \*                                          | div    |

## Form Attributes

| 参数                    | 说明                                                                                    | 类型    | 可选值                | 默认值 |
| ----------------------- | --------------------------------------------------------------------------------------- | ------- | --------------------- | ------ |
| model                   | 表单数据对象                                                                            | object  | —                     | —      |
| rules                   | 表单验证规则                                                                            | object  | —                     | —      |
| inline                  | 行内表单模式                                                                            | boolean | —                     | false  |
| label-position          | 表单域标签的位置，如果值为 left 或者 right 时，则需要设置 label-width                   | string  | right/left/top        | right  |
| label-width             | 表单域标签的宽度，例如 '50px'。作为 Form 直接子元素的 form-item 会继承该值。支持 auto。 | string  | —                     | —      |
| label-suffix            | 表单域标签的后缀                                                                        | string  | —                     | —      |
| hide-required-asterisk  | 是否隐藏必填字段的标签旁边的红色星号                                                    | boolean | —                     | false  |
| show-message            | 是否显示校验错误信息                                                                    | boolean | —                     | true   |
| inline-message          | 是否以行内形式展示校验信息                                                              | boolean | —                     | false  |
| status-icon             | 是否在输入框中显示校验结果反馈图标                                                      | boolean | —                     | false  |
| validate-on-rule-change | 是否在 rules 属性改变后立即触发一次验证                                                 | boolean | —                     | true   |
| size                    | 用于控制该表单内组件的尺寸                                                              | string  | medium / small / mini | —      |
| disabled                | 是否禁用该表单内的所有组件。若设置为 true，则表单内组件上的 disabled 属性不再生效       | boolean | —                     | false  |

## Col Attributes

| 参数   | 说明                                 | 类型                                        | 可选值 | 默认值 |
| ------ | ------------------------------------ | ------------------------------------------- | ------ | ------ |
| span   | 栅格占据的列数                       | number                                      | —      | 24     |
| offset | 栅格左侧的间隔格数                   | number                                      | —      | 0      |
| push   | 栅格向右移动格数                     | number                                      | —      | 0      |
| pull   | 栅格向左移动格数                     | number                                      | —      | 0      |
| xs     | <768px 响应式栅格数或者栅格属性对象  | number/object (例如： {span: 4, offset: 4}) | —      | —      |
| sm     | ≥768px 响应式栅格数或者栅格属性对象  | number/object (例如： {span: 4, offset: 4}) | —      | —      |
| md     | ≥992px 响应式栅格数或者栅格属性对象  | number/object (例如： {span: 4, offset: 4}) | —      | —      |
| lg     | ≥1200px 响应式栅格数或者栅格属性对象 | number/object (例如： {span: 4, offset: 4}) | —      | —      |
| xl     | ≥1920px 响应式栅格数或者栅格属性对象 | number/object (例如： {span: 4, offset: 4}) | —      | —      |
| tag    | 自定义元素标签                       | string                                      | \*     | div    |

## Form-Item Attributes

| 参数           | 说明                                                                         | 类型    | 可选值                          | 默认值 |
| -------------- | ---------------------------------------------------------------------------- | ------- | ------------------------------- | ------ |
| prop           | 表单域 model 字段，在使用 validate、resetFields 方法的情况下，该属性是必填的 | string  | 传入 Form 组件的 model 中的字段 | —      |
| label          | 标签文本                                                                     | string  | —                               | —      |
| label-width    | 表单域标签的的宽度，例如 '50px'。支持 auto。                                 | string  | —                               | —      |
| required       | 是否必填，如不设置，则会根据校验规则自动生成                                 | boolean | —                               | false  |
| rules          | 表单验证规则                                                                 | object  | —                               | —      |
| error          | 表单域验证错误信息, 设置该值会使表单验证状态变为 error，并显示该错误信息     | string  | —                               | —      |
| show-message   | 是否显示校验错误信息                                                         | boolean | —                               | true   |
| inline-message | 以行内形式展示校验信息                                                       | boolean | —                               | false  |
| size           | 用于控制该表单域下组件的尺寸                                                 | string  | medium / small / mini           | -      |
