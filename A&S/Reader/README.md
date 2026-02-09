# Software

## Install

### Install for Docker

```shell

```

```yml
services:
  reader:
    image: hectorqin/reader
    container_name: reader
    ports:
      - 0:8080
    volumes:
      - ./logs:/logs
      - ./storage:/storage
    restart: unless-stopped
    networks:
      - software-network
networks:
  software-network:
    external: true
```
