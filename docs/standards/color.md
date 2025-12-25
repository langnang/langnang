---
named:
  - name: Blue
    nameCn: 蓝色
    rgb:
safe:
  - "00"
  - 33
  - 66
  - 99
  - CC
  - FF
unnamed:
  - 354141
---

# 色彩·Color

## Named

```yml
white: ffffff
black: 000000
red:
yellow:
blue:
blue-60: 0060df
blue-70: 003eaa
gray-20: ededf0
light-gray: F0F0F4
primary-text: 15141A
secondary-text: 5B5B66
primary: 007bff
info: 17a2b8
success: 28a745
warning: ffc107
danger: dc3545
dark: 343a40
secondary: 6c757d
light: f8f9fa
purple: d3dce6
purple-light: e5e9f2
purple-dark: 99a9bf
```

- 天蓝色（Sky Blue）: RGB(135, 206, 235)
- 钢蓝色（Steel Blue）: RGB(70, 130, 180)
- 中蓝色（Medium Blue）: RGB(0, 0, 205)
- 绿宝石蓝（Turquoise Blue）: RGB(0, 199, 183)
- 夜空蓝（Midnight Blue）: RGB(25, 25, 112)

## 安全色（Safe Color）

<div class="row row-cols-6">

{% assign cor = page.safe %}
{% for r in cor %}
{% for g in cor %}
{% for b in cor %}

<div class="col p-2">
<div class="card" style="background:#{{r}}{{g}}{{b}}">
<div class="card-body p-2"> #{{r}}{{g}}{{b}}
</div>
</div>
</div>
{% endfor %}
{% endfor %}
{% endfor %}

## Unnamed

<div class="row row-cols-6">
  {% for cor in page.unnamed %}
    <div class="col p-2">
      <div class="card" style="background:#{{cor}}">
        <div class="card-body p-2">
          #{{cor}}
        </div>
      </div>
    </div>
  {% endfor %}

</div>
