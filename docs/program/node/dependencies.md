---
title: NPM - Dependencies

npm_cdns:
  - name: npmjs
    homepage: https://npmjs.com/
    storageIco: npmjs.ico
    packageUrl: https://npmjs.com/
  - name: cdnjs
    homepage: https://cdnjs.com/
    storageIco: cdnjs.ico
    packageUrl: https://cdnjs.com/
  - name: jsdelivr
    homepage: https://jsdelivr.com/
    storageIco: jsdelivr.ico
    packageUrl: https://jsdelivr.com/
  - name: unpkg
    homepage: https://unpkg.com/
    storageIco: unpkg.ico
    packageUrl: https://unpkg.com/
  - name: bootcdn
    homepage: https://bootcdn.cn/
    storageIco: bootcdn.ico
    packageUrl: https://bootcdn.cn/
---

# Node

<div class="d-flex justify-content-around mb-3" style="height: 3rem;">
  {% for cdn in page.npm_cdns %}
    <a target="_blank" class="d-inline-flex" href="{{cdn.homepage}}">
      {% if cdn.storageIco %}
        <img src="{{site.storageUrl.favicon}}/{{cdn.storageIco}}"/>
      {% else if cdn.ico %}
        <img src="{{cdn.ico}}"/>
      {% endif %}
    </a>
  {% endfor %}
</div>

<!-- UNPKG -->
<!-- <link rel="stylesheet" href="" /> -->
<!-- <script src=""></script> -->

```html
<!-- UNPKG -->
<!--  -->
<link rel="stylesheet" href="https://www.unpkg.com/{package}" />
<script src="https://www.unpkg.com/{package}"></script>
<!-- OR -->
<!-- https://www.unpkg.com/{package}@{version} -->
<link rel="stylesheet" href="https://www.unpkg.com/{package}@{version}" />
<script src="https://www.unpkg.com/{package}@{version}"></script>
<!-- OR -->
<!-- https://www.unpkg.com/{package}@{version}/{file} -->
<script src="https://www.unpkg.com/{package}@{version}"></script>

<!-- NPM -->

<!-- jsDelivr -->
```

{% if site.data.dependencies.npm_packages %}
{% assign npm_packages = site.data.dependencies.npm_packages %}

<ul>
  {% for package in npm_packages %}
    {% if package.name %}
      <li>
        {% for cdn in page.npm_cdns %}
          <a target="_blank" href="{{cdn.packageUrl}}/{{package.name}}">
            {% if cdn.storageIco %}
              <img src="{{site.storageUrl.favicon}}/{{cdn.storageIco}}" alt=""/>
            {% else if cdn.ico %}
              <img src="{{cdn.ico}}" alt=""/>
            {% endif %}
          </a>
        {% endfor %}
        {% if package.github_user and package.github_repo %}
          <a target="_blank" href="https://github.com/{{package.github_user}}/{{package.github_repo}}">
            <img src="{{site.storageUrl.favicon}}/github.ico" alt="">
          </a>
        {% endif %}
        {% if package.storageIco or package.ico and package.homepage %}
          <a target="_blank" href="{{package.homepage}}">
            {% if package.storageIco %}
              <img src="{{site.storageUrl.favicon}}/{{package.storageIco}}" alt=""/>
            {% else if package.ico %}
              <img src="{{package.ico}}" alt=""/>
            {% endif %}
          </a>
        {% endif %}
        <img src="https://img.shields.io/npm/dt/{{package.name}}" />
        {% if package.localpage %}
          <a href="{{package.localpage}}"><code class="language-plaintext highlighter-rouge">{{package.name}}</code></a>:
        {% else %}
          <code class="language-plaintext highlighter-rouge">{{package.name}}</code>:
        {% endif %}
        {% if package.description %}
          <span>{{package.description}}</span>
        {% endif %}
      </li>
    {% endif %}
  {% endfor %}
</ul>
{% endif %}
