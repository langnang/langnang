# Software

## Install

### Install for Docker

```shell

```

```yml
services:
  plex:
    image: plexinc/pms-docker:latest # 使用官方 Plex 镜像
    container_name: plex # 容器名称
    environment:
      - PLEX_CLAIM=<plex_token> # 替换为从 https://www.plex.tv/claim 获取的令牌
      - TZ=Asia/Shanghai # 设置时区
      - PUID=1000 # 用户 ID
      - PGID=1000 # 组 ID
    ports:
      - "32400:32400/tcp" # Plex Web 界面端口
    volumes:
      - ./config:/config # 配置文件目录
      - ./transcode:/transcode # 转码文件目录
      - ./media:/data # 媒体文件目录
    restart: unless-stopped # 自动重启策略
    networks:
      - software-network
networks:
  software-network:
    external: true
```
