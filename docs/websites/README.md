---
title: Websites
layout: default
fetch_url: https://cdn.jsdelivr.net/gh/langnang/storage/json/websites.json
---
> 网站

<!-- <ul>
  <li v-for="(content,index) in fetch.data.contents" v-bind:key="index" v-text="content.title"></li>
</ul>

<script>
  $(document).ready(()=>{
    console.log(app);
  })
</script> -->

{% if site.data.websites %}
<ul>
  {% for site in site.data.websites %}
  <li>
    {% if site.url %}
    <a target="_blank" href="{{site.url}}">{{site.title}}: {{site.description}}</a>
    {% else %}
    {{site.title}}: {{site.description}}
    {% endif %}
  </li>
  {% endfor %}
</ul>
{% endif %}
