# SQLStudio

## Install

### Install for Docker

```shell

```

```yml
services:
  app:
    image: yueranzs/sqlstudio:1.0.2
    container_name: sqlstudio_server
    ports:
      - 0:18888
    volumes:
      - ./log:/apps/usr/sqlstudio/linux/log
      - ./data:/apps/usr/sqlstudio/linux/data
    restart: unless-stopped
```
