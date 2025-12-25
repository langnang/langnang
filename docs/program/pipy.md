---
title: PyPI - Dependencies

pypi_cdns:
  - name: pypi
    homepage: https://pypi.org/
    storageIco: pypi.ico
    packageUrl: https://pypi.org/project/
---

<div class="d-flex justify-content-around mb-3" style="height: 3rem;">
  {% for cdn in page.pypi_cdns %}
    <a target="_blank" class="d-inline-flex" href="{{cdn.homepage}}">
      {% if cdn.storageIco %}
        <img src="{{site.storageUrl.favicon}}/{{cdn.storageIco}}"/>
      {% else if cdn.ico %}
        <img src="{{cdn.ico}}"/>
      {% endif %}
    </a>
  {% endfor %}
</div>

**intall**

```bash
pip install {package}
```

{% if site.data.dependencies.pypi_packages %}
{% assign pypi_packages = site.data.dependencies.pypi_packages %}
<ul>
  {% for package in pypi_packages %}
    {% if package.name %}
      <li>
        {% for cdn in page.pypi_cdns %}
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
        <code class="language-plaintext highlighter-rouge">{{package.name}}</code>:
        {% if package.description %}
          <span>{{package.description}}</span>
        {% endif %}
      </li>
    {% endif %}
  {% endfor %}
</ul>
{% endif %}
