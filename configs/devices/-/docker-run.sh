!/bin/bash

device_name=$(basename $(cd "$(dirname $0)";pwd))

dockerConfigYml="D:/wwwroot/@Langnang/_configs/devices/docker.yml"
softwareConfigYml="D:/wwwroot/@Langnang/_configs/devices/softwares.yml"

for device in $(yq eval '.devices | to_entries | .[] | .key' $dockerConfigYml); do
    if [ "$device_name" = "devices" ] || [ "$device_name" = "$device" ];then
        echo $device

        root_name=$(yq eval ".devices.$device.root.name" $dockerConfigYml)
        root_pass=$(yq eval ".devices.$device.root.pass" $dockerConfigYml)

        user_name=$(yq eval ".devices.$device.user.name" $dockerConfigYml)
        user_pass=$(yq eval ".devices.$device.user.pass" $dockerConfigYml)

        device_addr=$(yq eval ".devices.$device.device.addr" $dockerConfigYml)
        device_type=$(yq eval ".devices.$device.device.type" $dockerConfigYml)
        device_name=$(yq eval ".devices.$device.device.name" $dockerConfigYml)
        device_netk=$(yq eval ".devices.$device.device.netk" $dockerConfigYml)
        device_soln=$(yq eval ".devices.$device.device.soln" $dockerConfigYml)

        cpolar_version=$(yq eval ".devices.$device.applications.cpolar.version" $dockerConfigYml)

        docker_version=$(yq eval ".devices.$device.applications.docker.version" $dockerConfigYml)

        # . D:/wwwroot/@Langnang/_configs/devices/docker-echo.sh

        for composeYml in $(find "D:/wwwroot/@Langnang/_configs/devices/$device" -name 'docker-compose*.yml'); do
            echo $composeYml
            for service in $(yq eval '.services | to_entries | .[] | .key' $composeYml); do
                echo $service
                if [ "$service" = "frpc" ];then
                    . D:/wwwroot/@Langnang/_configs/devices/make-conf.frpc.sh
                elif [ "$service" = "nginx" ];then
                    echo
                    # . D:/wwwroot/@Langnang/_configs/devices/make-conf.nginx.sh
                elif [ "$service" = "homer" ];then
                    echo
                    # . D:/wwwroot/@Langnang/_configs/devices/make-conf.homer.sh
                fi
            done

        done

    fi
done
