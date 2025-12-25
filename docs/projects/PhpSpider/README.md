# PhpSpider

```mermaid
flowchart TB

  Start((爬虫开始运行)) --> on_start --> on_status_code --> is_anti_spider --> on_download_page
  subgraph selectCollectUrls
    direction LR
    select_collect_urls_of_spider
  end
  on_start <--> selectCollectUrls
  on_download_page --> |URL属于入口页| on_scan_page --> on_fetch_url
  on_download_page --> |URL属于列表页| on_list_page --> on_fetch_url
  on_download_page --> |URL属于内容页| on_content_page
  subgraph extractContentPage
    direction TB
    on_download_attached_page --> on_handle_img --> on_extract_field --> on_extract_page
  end
  on_content_page --> extractContentPage
  on_extract_page --> on_fetch_url
  subgraph isUrlCollected
    direction TB
    exists_url_collected
  end
  on_fetch_url <--> isUrlCollected
  on_fetch_url --> on_add_url --> on_status_code
```

```txt
on_extract_page End[结束] -->

on_start --> selectCollectUrlsOfSpider --> add_url --> on_start
```

## 表结构设计

### `table::phpspider_contents`

| Name         | Type | Nullable | Index | Default | Comment |
| ------------ | ---- | -------- | ----- | ------- | ------- |
| id           |      |          |       |         |         |
| slug         |      |          |       |         |         |
| name         |      |          |       |         |         |
| max_depth    |      |          |       |         |         |
| max_fields   |      |          |       |         |         |
| domains      |      |          |       |         |         |
| export_table |      |          |       |         |         |
|              |      |          |       |         |         |
|              |      |          |       |         |         |

### `table::phpspider_fields`

| Name | Type | Nullable | Index | Default | Comment |
| ---- | ---- | -------- | ----- | ------- | ------- |
|      |      |          |       |         |         |
|      |      |          |       |         |         |

### `table::phpspider_logs`

| Name | Type | Nullable | Index | Default | Comment |
| ---- | ---- | -------- | ----- | ------- | ------- |
|      |      |          |       |         |         |
|      |      |          |       |         |         |

### `table::phpspider_collect_urls`

| Name       | Type | Nullable | Index | Default | Comment |
| ---------- | ---- | -------- | ----- | ------- | ------- |
| content_id |      |          |       |         |         |
| name       |      |          |       |         |         |
| selector   |      |          |       |         |         |
|            |      |          |       |         |         |
|            |      |          |       |         |         |
