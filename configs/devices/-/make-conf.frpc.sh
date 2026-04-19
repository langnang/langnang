!/bin/bash

conf="\n
[common]\n
# server_addr为FRPS服务器IP地址\n
server_addr = 101.126.135.139\n
# server_port为服务端监听端口，bind_port\n
server_port = 7000\n
# 身份验证\n
token = langnang.com\n
# includes = ["/etc/frp/confd/*.toml"]\n
\n
webServer_addr = "127.0.0.1"#监听地址，默认为 127.0.0.1。\n
webServer_port = 7400 #【必填】监听端口。\n
webServer_user = "admin"#仪表盘用户名。\n
webServer_password = "admin1234"#仪表盘密码。\n
\n
"

echo $conf
echo $composeYml
for soft in $(yq eval ".devices.$device_name.softwares.frpc[]" $dockerConfigYml); do
    echo $soft

    soft_port=$(yq eval ".$soft.port" $softwareConfigYml)
    if [ "$soft_port" = "null" ];then soft_port=$(yq eval ".$soft" $softwareConfigYml); fi
    if [ "$soft_port" = "null" ];then continue; fi
    
    soft_code=$(yq eval ".$soft.code" $softwareConfigYml)
    
    soft_frpc=$(yq eval ".$soft.frpc" $softwareConfigYml)
    
    soft_slug=$(yq eval ".$soft.slug" $softwareConfigYml)
    if [ "$soft_slug" = "null" ];then soft_slug=$soft; fi
    
    soft_name=$(yq eval ".$soft.name" $softwareConfigYml)
    if [ "$soft_name" = "null" ];then soft_name=$soft_slug; fi
    
    soft_addr=$(yq eval ".$soft.addr" $softwareConfigYml)
    if [ "$soft_addr" = "null" ];then soft_addr=$soft_slug; fi
    
    soft_type=$(yq eval ".$soft.type" $softwareConfigYml)
    if [ "$soft_type" = "null" ];then soft_type=tcp; fi

conf+="[{{ .Envs.DEVICE_NAME }}::$soft_name]\n
type = $soft_type\n
local_ip = $soft_addr\n
local_port = $soft_port\n
remote_port = $soft_code{{.Envs.DEVICE_CODE}}\n
\n
"
done

echo -e $conf > "D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose/frpc/frpc.toml"
