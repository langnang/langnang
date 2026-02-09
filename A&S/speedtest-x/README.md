# Software

## Install

### Install for Docker

```shell

```

```yml
services:
  speedtest-x:
    container_name: speedtest-x
    ports:
      - 0:80
    image: badapple9/speedtest-x
    restart: unless-stopped
    networks:
      - software-network
networks:
  software-network:
    external: true
```
