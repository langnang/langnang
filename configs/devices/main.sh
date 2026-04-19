# !bin/bash


dockerConfigYml="D:/wwwroot/@Langnang/_configs/devices/config.yml"


# for device in $(yq eval '.devices | to_entries | .[] | .key' $dockerConfigYml); do
#     echo $device
# done

# echo $(yq eval '.devices | to_entries | .[] | .key' $dockerConfigYml)

PS3="请选择设备(其它退出): "

select device in $(yq eval '.devices | to_entries | .[] | .key' $dockerConfigYml); 
do
    echo $device
    if [ -z "$device" ]; then exit 0; fi

    ROOT_NAME=$(yq eval ".devices.$device.root.name" $dockerConfigYml)
    ROOT_PASS=$(yq eval ".devices.$device.root.pass" $dockerConfigYml)

    USER_NAME=$(yq eval ".devices.$device.user.name" $dockerConfigYml)
    USER_PASS=$(yq eval ".devices.$device.user.pass" $dockerConfigYml)

    DEVICE_ADDR=$(yq eval ".devices.$device.device.addr" $dockerConfigYml)
    DEVICE_TYPE=$(yq eval ".devices.$device.device.type" $dockerConfigYml)
    DEVICE_NAME=$(yq eval ".devices.$device.device.name" $dockerConfigYml)
    DEVICE_NETK=$(yq eval ".devices.$device.device.netk" $dockerConfigYml)
    DEVICE_SOLN=$(yq eval ".devices.$device.device.soln" $dockerConfigYml)

    PS3="$device $DEVICE_ADDR 请选择操作(其它退出): "
    select action in $(yq eval '.actions | to_entries | .[] | .key' $dockerConfigYml); 
    do
        echo $action
        if [ -z "$action" ]; then exit 0; fi

        for i in $(seq 0 $(yq eval ".actions.$action | length - 1" $dockerConfigYml)); 
        do

            # echo $i
            echo ssh $USER_NAME@$DEVICE_ADDR
            command=$(yq eval ".actions.$action.commands[$i]" $dockerConfigYml)
            command=${command//\$ROOT_NAME/$ROOT_NAME}
            command=${command//\$ROOT_PASS/$ROOT_PASS}
            command=${command//\$USER_NAME/$USER_NAME}
            command=${command//\$USER_PASS/$USER_PASS}
            command=${command//\$DEVICE_ADDR/$DEVICE_ADDR}
            command=${command//\$DEVICE_TYPE/$DEVICE_TYPE}
            command=${command//\$DEVICE_NAME/$DEVICE_NAME}
            command=${command//\$DEVICE_NETK/$DEVICE_NETK}
            command=${command//\$DEVICE_SOLN/$DEVICE_SOLN}
            # echo "$command"
            ssh $USER_NAME@$DEVICE_ADDR "$command;"
        done

    done
# case $choice in
# 磁盘) fdisk -l; break;;
# 文件系统) df -h; break;;
# CPU) uptime; break;;
# 内存) free -m; break;;
# 退出) exit 0;;
# *) echo "错误选项";;
# esac
done