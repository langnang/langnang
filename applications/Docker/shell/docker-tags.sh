作者：冰冷雨夜
链接：https://www.zhihu.com/question/264593155/answer/1401813845
来源：知乎
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。

#!/bin/bash

function usage() {
    cat << HELP

dockertags  --  list all tags for a Docker image on a remote registry.

EXAMPLE:
    - list all tags for ubuntu:
       dockertags ubuntu

    - list all php tags containing apache:
       dockertags php apache

HELP
}

if [ $# -lt 1 ]; then
    usage
    exit
fi

image="$1"
tags=`wget -q https://registry.hub.docker.com/v1/repositories/${image}/tags -O -  | sed -e 's/[][]//g' -e 's/"//g' -e 's/ //g' | tr '}' '\n'  | awk -F: '{print $3}'`

if [ -n "$2" ]
then
    tags=` echo "${tags}" | grep "$2" `
fi

echo "${tags}"