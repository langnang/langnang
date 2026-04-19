# !/bin/bash

feat_docker(){
    echo "│  ├─ Homer"
}
feat_cpolar(){
    echo "│  ├─ Homer"
}

feat_homer(){
    echo "│  ├─ Homer"
    cp -r D:/wwwroot/@Langnang/_configs/softwares/homer/assets/custom.css D:/wwwroot/@Langnang/_configs/devices/$DEVICE_NAME/docker/compose/homer/custom.css
}
feat_nginx(){
    echo "│  ├─ Nginx"
}
feat_frpc(){
    echo "│  ├─ FrpC"
}
feat_frps(){
    echo "│  ├─ FrpS"
}
# feat_ssh(){
#     device_name=$1
#     # device_name=$(basename $(cd "$(dirname $0)";pwd))
#     device_addr=$(yq eval ".devices.$device_name.device.addr" $configYml)
#     device_type=$(yq eval ".devices.$device_name.device.type" $configYml)

#     root_name=$(yq eval ".devices.$device_name.root.name" $configYml)
#     root_pass=$(yq eval ".devices.$device_name.root.pass" $configYml)

#     user_name=$(yq eval ".devices.$device_name.user.name" $configYml)
#     user_pass=$(yq eval ".devices.$device_name.user.pass" $configYml)

#     echo sudo mv /app/ /mnt/hgfs/$device_name/
#     echo sudo cp -r /app/ /mnt/hgfs/$device_name/
#     echo sudo rsync -a /app/ /mnt/hgfs/$device_name/
#     echo sudo rm -r /app/
#     echo docker compose -f /mnt/hgfs/-$device_type/docker/compose/docker-compose.yml up -d 
#     echo docker compose -f /mnt/hgfs/$device_name/docker/compose/docker-compose.yml up -d 
#     echo 
#     # if [ -n "$device_addr" ] && [ -n "$user_name" ] && [ -n "$user_pass" ] && [ "$device_type" = "LinuxServer" ]; then
#     #     echo $device_name
#     #     echo $device_addr
#     #     echo $user_name
#     #     # ssh $user_name@$device_addr
#     # fi
# }

echo "├─ Utils:"
while [ $# -gt 0 ]; do
    case "$1" in
        feat-homer) feat_homer ;;
        feat-nginx) feat_nginx ;;
        feat-frpc)  feat_frpc  ;;
        feat-frps)  feat_frps  ;;
        --mirror)
            mirror="$2"
            shift
            ;;
        --version)
            VERSION="${2#v}"
            shift
            ;;
        --setup-repo)
            REPO_ONLY=1
            shift
            ;;
        feat-*|fix-*)
            echo "Illegal option $1"
            ;;
    esac
    shift $(( $# > 0 ? 1 : 0 ))
done

# main(){}

# main