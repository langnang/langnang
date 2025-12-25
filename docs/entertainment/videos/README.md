# 视频·Video

- 电影 `Movie`
- 剧集 `Episode`
- 动漫 `Comic`
- 纪录 `Documentary`
- 综艺 `Variety`

- https://www.bilibili.com/

- https://www.66ss.org/

<!--

## 电影

{% if site.data.entertainment.video.movie %}
{% assign video_movie = site.data.entertainment.video.movie %}

<div class="row row-cols-2 row-cols-sm-4 row-cols-md-6">
  {% for video in video_movie %}
    {% if video.title != "" %}
    <div class="col">
      {% if video.movie_douban_slug and video.movie_douban_slug != '' %}
        <a class="card" target="_blank" href="https://movie.douban.com/subject/{{video.movie_douban_slug}}/">
          {% if video.movie_douban_ico and video.movie_douban_ico != '' %}
          <img class="card-img-top lazyload" data-src="https://img3.doubanio.com/view/photo/s_ratio_poster/public/{{video.movie_douban_ico}}.webp" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% else %}
        <a class="card" target="_blank" href="{{video.url}}">
          {% if video.storageIco %}
            <img class="card-img-top lazyload" data-src="{{site.storageUrl.favicon}}/{{video.storageIco}}" alt=""/>
          {% else if video.ico %}
            <img class="card-img-top lazyload" data-src="{{video.ico}}" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% endif %}
    </div>
    {% endif %}
  {% endfor %}
</div>
{% endif %} -->

## 动作

### 动作.电影

### 动作.剧集

### 动作.动漫

### 动作.纪录

### 动作.综艺

## 喜剧

### 喜剧.电影

### 喜剧.剧集

### 喜剧.动漫

### 喜剧.纪录

### 喜剧.综艺

## 爱情

### 爱情.电影

### 爱情.剧集

### 爱情.动漫

### 爱情.纪录

### 爱情.综艺

## 科幻

### 科幻.电影

### 科幻.剧集

### 科幻.动漫

### 科幻.纪录

### 科幻.综艺

## 恐怖

### 恐怖.电影

### 恐怖.剧集

### 恐怖.动漫

### 恐怖.纪录

### 恐怖.综艺

## 剧情

### 剧情.电影

### 剧情.剧集

### 剧情.动漫

### 剧情.纪录

### 剧情.综艺

## 战争

### 战争.电影

### 战争.剧集

### 战争.动漫

### 战争.纪录

### 战争.综艺

## 记录

### 记录.电影

### 记录.剧集

### 记录.动漫

### 记录.纪录

### 记录.综艺

<!--
## 电视剧

{% if site.data.entertainment.video.teleplay %}
{% assign video_teleplay = site.data.entertainment.video.teleplay %}

<div class="row row-cols-2 row-cols-sm-4 row-cols-md-6">
  {% for video in video_teleplay %}
    {% if video.title != "" %}
    <div class="col">
      {% if video.movie_douban_slug and video.movie_douban_slug != '' %}
        <a class="card" target="_blank" href="https://movie.douban.com/subject/{{video.movie_douban_slug}}/">
          {% if video.movie_douban_ico and video.movie_douban_ico != '' %}
          <img class="card-img-top lazyload" data-src="https://img3.doubanio.com/view/photo/s_ratio_poster/public/{{video.movie_douban_ico}}.webp" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% else %}
        <a class="card" target="_blank" href="{{video.url}}">
          {% if video.storageIco %}
            <img class="card-img-top lazyload" data-src="{{site.storageUrl.favicon}}/{{video.storageIco}}" alt=""/>
          {% else if video.ico %}
            <img class="card-img-top lazyload" data-src="{{video.ico}}" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% endif %}
    </div>
    {% endif %}
  {% endfor %}
</div>
{% endif %}

## 动漫

{% if site.data.entertainment.video.anime %}
{% assign video_anime = site.data.entertainment.video.anime %}

<div class="row row-cols-2 row-cols-sm-4 row-cols-md-6">
  {% for video in video_anime %}
    {% if video.title != "" %}
    <div class="col">
      {% if video.movie_douban_slug and video.movie_douban_slug != '' %}
        <a class="card" target="_blank" href="https://movie.douban.com/subject/{{video.movie_douban_slug}}/">
          {% if video.movie_douban_ico and video.movie_douban_ico != '' %}
          <img class="card-img-top lazyload" data-src="https://img3.doubanio.com/view/photo/s_ratio_poster/public/{{video.movie_douban_ico}}.webp" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% else %}
        <a class="card" target="_blank" href="{{video.url}}">
          {% if video.storageIco %}
            <img class="card-img-top lazyload" data-src="{{site.storageUrl.favicon}}/{{video.storageIco}}" alt=""/>
          {% else if video.ico %}
            <img class="card-img-top lazyload" data-src="{{video.ico}}" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% endif %}
    </div>
    {% endif %}
  {% endfor %}
</div>
{% endif %}

## 特摄片

{% if site.data.entertainment.video.tokusatsu %}
{% assign video_tokusatsu = site.data.entertainment.video.tokusatsu %}

<div class="row row-cols-2 row-cols-sm-4 row-cols-md-6">
  {% for video in video_tokusatsu %}
    {% if video.title != "" %}
    <div class="col">
      {% if video.movie_douban_slug and video.movie_douban_slug != '' %}
        <a class="card" target="_blank" href="https://movie.douban.com/subject/{{video.movie_douban_slug}}/">
          {% if video.movie_douban_ico and video.movie_douban_ico != '' %}
          <img class="card-img-top lazyload" data-src="https://img3.doubanio.com/view/photo/s_ratio_poster/public/{{video.movie_douban_ico}}.webp" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% else %}
        <a class="card" target="_blank" href="{{video.url}}">
          {% if video.storageIco %}
            <img class="card-img-top lazyload" data-src="{{site.storageUrl.favicon}}/{{video.storageIco}}" alt=""/>
          {% else if video.ico %}
            <img class="card-img-top lazyload" data-src="{{video.ico}}" alt=""/>
          {% endif %}
          <div class="card-body p-2">
            <h5 class="card-title text-truncate my-2">{{ video.titleCn }} {{ video.title }}</h5>
          </div>
        </a>
      {% endif %}
    </div>
    {% endif %}
  {% endfor %}
</div>
{% endif %} -->
<!--
## websites

**正版**

{% if site.data.entertainment.video.websites.original %}
{% assign video_original_websites = site.data.entertainment.video.websites.original %}

<ul>
  {% for website in video_original_websites %}
    {% if website.title != "" %}
    <li>
      <a target="_blank" href="{{website.url}}">
        {% if website.storageIco %}
          <img class="lazyload" data-src="{{site.storageUrl.favicon}}/{{website.storageIco}}" alt=""/>
        {% else if website.ico %}
          <img class="lazyload" data-src="{{website.ico}}" alt=""/>
        {% endif %}
        {{ website.title }}
      </a>
    </li>
    {% endif %}
  {% endfor %}
</ul>
{% endif %}

**其它**

{% if site.data.entertainment.video.websites.other %}
{% assign video_other_websites = site.data.entertainment.video.websites.other %}

<ul>
  {% for website in video_other_websites %}
    {% if website.title != "" %}
    <li>
      <a target="_blank" href="{{website.url}}">
        {% if website.storageIco %}
          <img class="lazyload" data-src="{{site.storageUrl.favicon}}/{{website.storageIco}}" alt=""/>
        {% else if website.ico %}
          <img class="lazyload" data-src="{{website.ico}}" alt=""/>
        {% endif %}
        {{ website.title }}
      </a>
    </li>
    {% endif %}
  {% endfor %}
</ul>
{% endif %} -->
