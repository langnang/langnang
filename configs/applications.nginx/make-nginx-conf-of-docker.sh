# !/bin/bash
# 将当前目录存储在变量中
# DIR=$(pwd)

# # 指定要遍历的目录
# DIR="D:\wwwroot\@Langnang\_configs\@docker"

# # 使用 find 查找所有文件并通过 while 循环处理
# find "$DIR" -type f | while IFS= read -r file; do
# echo "Processing $file"
# # 在这里添加对每个文件的操作
# done

# softwares=""

# echo "检查Docker......"
# docker -v
#     if [ $? -eq  0 ]; then
#        	echo "检查到Docker已安装!"
#     else
#         echo "安装docker环境..."
#         # curl -sSL https://get.daocloud.io/docker | sh
#         # echo "安装docker环境...安装完成!"
#     fi


# case "$OSTYPE" in
#     linux*)
#         echo "当前操作系统是 Linux"
#     ;;
#     darwin*)
#         echo "当前操作系统是 MacOS"
#     ;;
#     msys*|cygwin*)
#         echo "当前操作系统是 Windows"
#     ;;
#     *)
#         echo "未知操作系统: $OSTYPE"
#     ;;
# esac



defaultOptionYml="D:\wwwroot\@Langnang\_configs\@docker\docker.yml"

echo $defaultOptionYml

# # 读取并解析 YAML 文件
# cat "$defaultOptionYml" | while IFS=: read -r key value; do
# # 去除多余的空格
# key=$(echo "$key" | xargs)
# value=$(echo "$value" | xargs)
# echo "$key = $value"
# done
function make_default_conf(){
    container=$1
    port=$2
    suffix=$3

    if [  $port = "null" ] ; then
        echo "# 未配置容器 $container 的暴露端口 \n"
    elif [ $container = "nginx" ] ; then
        # return $container
        echo ""
    else
        echo "upstream $container { server $container:$port; } \n"
    fi

}

function make_port80_conf(){
    container=$1
    port=$2
    suffix=$3
    if [  "$suffix" = "null" ] ; then
        suffix=""
    fi

    if [  $port = "null" ] ; then
        echo "\t# 未配置容器 $container 的暴露端口 \n"
    elif [ $container = "nginx" ] ; then
        # return $container
        echo ""
    # elif [ $container = "homer" ] ; then
    #     # return $container
    #     echo ""
    else
        echo "\tlocation /$container/     {\n      
            \t\tproxy_pass http://$container/$suffix;\n
            \t\tproxy_set_header Host \$host;\n
            \t\tproxy_set_header X-Real-IP \$remote_addr;\n
            \t\tproxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;\n
            \t\tproxy_set_header X-Forwarded-Proto \$scheme;\n
            \t\tproxy_set_header Upgrade \$http_upgrade;\n
            \t\tproxy_set_header Connection \$connection_upgrade;\n         
        \t}\n"
    fi
}

# yq eval '._desktop.softwares' $defaultOptionYml # 输出 "John Doe"

for stack in $(yq eval '.stacks[]' $defaultOptionYml); do
    echo $stack;
    # stackYml=$(find "D:\wwwroot\@Langnang\_configs\@docker\\$stack" -name 'docker-compose*.yml' -print)

    # stackName="network_software"
    # stackYml="D:\wwwroot\@Langnang\_configs\@docker\\$stack\\docker-compose.yml"
    # echo $stackYml;

    stackContainers=()

    default_conf="";
    port80_conf="server {\n 
    \tlisten       80;\n
    \tlisten       [::]:80;\n
    \tserver_name  localhost;\n
    \n
    \tport_in_redirect off;\n
    \tabsolute_redirect off;\n
    \n
    \tlocation / {\n
    \t    \tadd_header 'Access-Control-Allow-Origin' '*';\n
    \t    \tadd_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';\n
    \t    \tadd_header 'Access-Control-Allow-Headers' 'DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Authorization';\n
    \n
    \t    \tproxy_pass http://homer/;\n
    \t    \t# root   /usr/share/nginx/html;\n
    \t   \tindex  index.html index.htm;\n
    \t}\n";

    for stackYml in $(find "D:\wwwroot\@Langnang\_configs\@docker\\$stack" -name 'docker-compose*.yml'); do
        echo $stackYml;
        # 遍历 docker-compose.yml
        for container in $(yq eval ' .services | to_entries | .[] | .key' $stackYml); do
            # echo $container
            suffix=$(yq eval ".softwares.$container.suffix" $defaultOptionYml);
            # echo $suffix
            port=$(yq eval ".softwares.$container.port" $defaultOptionYml);
            # echo $port
            if [ "$port" = "" ];then
                port=$(yq eval ".softwares.$container" $defaultOptionYml);
            fi
            if [[ ! " ${stackContainers[@]} " =~ " ${container} " ]]; then
                # echo "${container} exists in array"
                # echo
            # else
                # echo "${container} does not exist in array"
                stackContainers+=("$container")
                default_conf+=$(make_default_conf $container $port $suffix)
                port80_conf+=$(make_port80_conf $container $port $suffix)
            fi
        done
    done


    # 遍历 .yml
    for container in $(yq eval ".$stack.append_softwares[]" $defaultOptionYml); do
        # echo $container
        suffix=$(yq eval ".softwares.$container.suffix" $defaultOptionYml);
        echo $suffix
        port=$(yq eval ".softwares.$container" $defaultOptionYml);
        echo $port
        if [[ ! " ${stackContainers[@]} " =~ " ${container} " ]]; then
            # echo "${container} exists in array"
            # echo
            # return 0
        # else
            # echo "${container} does not exist in array"
            stackContainers+=("$container")
            default_conf+=$(make_default_conf $container $port $suffix)
            port80_conf+=$(make_port80_conf $container $port $suffix)
        fi
    done

    # echo ${stackContainers[@]}
    default_conf+="\ninclude /etc/nginx/conf.d/80.conf;"

    port80_conf+="\n
        \n\terror_page 500 502 503 504 /50x.html;
        \n\tlocation = /50x.html {
        \n\t    \troot /usr/share/nginx/html;
        \n\t}
    \n}"

    echo -e $default_conf > "D:\wwwroot\@Langnang\_configs\@docker\\$stack\nginx\conf.d\default.conf"

    # echo $default_conf;

    echo -e $port80_conf > "D:\wwwroot\@Langnang\_configs\@docker\\$stack\nginx\conf.d\80.conf";



    # yq eval ".$stack.commands[0]" $defaultOptionYml
    # docker restart network_software-nginx-1
    # eval "docker restart network_software-nginx-1"
    for i in $(seq 0 $(yq eval ".$stack.commands | length - 1" $defaultOptionYml)); do

        # echo $i
        command=$(yq eval ".$stack.commands[$i]" $defaultOptionYml)
        eval "$command"
    done
done


# default_conf="";
# 80_conf="";

# stackName="network_software"
# stackComposeYml="D:\wwwroot\@Langnang\_configs\@docker\\$stackName\\docker-compose.yml"

# for i in $(seq 0 $(yq eval '.network_software.softwares | length - 1' $defaultOptionYml)); do

# done

# yq eval '.containers[] | .name, .networks[]' $defaultOptionYml
# yq eval '.stacks[]' $defaultOptionYml



# for i in $(seq 0 $(yq eval '.network_software.softwares | length - 1' $defaultOptionYml)); do
#     echo $i
#     server=$(yq eval ".network_software.softwares[$i]" $defaultOptionYml);
#     echo $server
#     port=$(yq eval ".softwares.$server" $defaultOptionYml);
#     echo $port
#     # if [ $server = "nginx" ] ; then
#     #     echo "Linux"
#     # elif [ $server = "homer" ] ; then
#     #     echo "FreeBSD"
#     # elif [ $SYSTEM = "Solaris" ] ; then
#     #     echo "Solaris"
#     # else
#     #     echo  "What?"
#     # fi
#     if [ $server = "nginx" ] ; then
#         echo $server
#     else
#         default_conf+="upstream $server { server $server:$port; }\n"
#     fi

# done

# default_conf+="\ninclude /etc/nginx/conf.d/80.conf;"

# echo $default_conf;

# echo $80_conf;
