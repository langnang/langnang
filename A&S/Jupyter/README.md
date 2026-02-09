<!-- @format -->

# Jupyter

[官网](http://jupyter.org/) | [Awesome](https://github.com/ml-tooling/best-of-jupyter)![](https://img.shields.io/github/license/ml-tooling/best-of-jupyter)![](https://img.shields.io/github/stars/ml-tooling/best-of-jupyter)

## Install

### Install for Docker

```shell

```

```yml
services:
  jupyter:
    image: jupyter/datascience-notebook:latest
    container_name: jupyter-lab
    ports:
      - '0:8888'
    volumes:
      - ./work:/home/jovyan/work
    restart: unless-stopped
    networks:
      - software-network
networks:
  software-network:
    external: true
```
