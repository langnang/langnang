# SurveyKing

## Install

### Install for Docker

```shell
# 一键启动，默认使用的是内置的 h2 数据库
docker run -d -p 1991:1991 surveyking/surveyking

# 挂载数据库文件、上传附件、日志文件
docker run -d -p 1991:1991 -v ${PWD}/db:/app/db -v ${PWD}/files:/app/files -v ${PWD}/logs:/app/logs surveyking/surveyking

# 由于 dockerhub 国内无法访问，可以使用阿里云镜像库
docker run -d -p 1991:1991 registry.cn-hangzhou.aliyuncs.com/surveyking/surveyking:latest

# 使用外置 mysql 数据库
docker run -e PROFILE=mysql \
           -v ${PWD}/logs:/app/logs \
           -v ${PWD}/files:/app/files \
           -e MYSQL_USER=surveyking \
           -e MYSQL_PASS=surveyking \
           -e DB_URL='jdbc:mysql://172.17.0.1:3306/surveyking?rewriteBatchedStatements=true&useUnicode=true&characterEncoding=UTF-8' \
           -p 1991:1991 \
           surveyking/surveyking
```

@[code](./docker-compose.yml)
