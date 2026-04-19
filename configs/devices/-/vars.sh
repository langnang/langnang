# !/bin/bash

# uname -a

configYml=D:/wwwroot/@Langnang/_configs/devices/config.yml

device=$(basename $(cd "$(dirname $0)";pwd))

envINI=D:/wwwroot/@Langnang/_configs/devices/$device/docker/compose/.env

echo "$device:."

# sed -n '/\[common\]/,/\[/{s/^DEVICE_NAME\s*=\s*//p}' $envINI
# sed -n '{s/^DEVICE_NAME\s*=\s*//p}' $envINI
# sed -n '{s/^DEVICE_NAME\s*=\s*//p}' $envINI

feat_root(){
    echo "│  ├─ Root: "
    # root_code=$(yq eval ".devices.$device.root.code" $configYml)
    ROOT_CODE=$(sed -n '{s/^ROOT_CODE\s*=\s*//p}' $envINI)
    echo "│  │  ├─ Code: $ROOT_CODE"
    # root_name=$(yq eval ".devices.$device.root.name" $configYml)
    ROOT_NAME=$(sed -n '{s/^ROOT_NAME\s*=\s*//p}' $envINI)
    echo "│  │  ├─ Name: $ROOT_NAME"
    # root_pass=$(yq eval ".devices.$device.root.pass" $configYml)
    ROOT_PASS=$(sed -n '{s/^ROOT_PASS\s*=\s*//p}' $envINI)
    echo "│  │  └─ Pass: $ROOT_PASS"
}

feat_user(){
    echo "│  ├─ User: "
    # user_code=$(yq eval ".devices.$device.user.code" $configYml)
    USER_CODE=$(sed -n '{s/^USER_CODE\s*=\s*//p}' $envINI)
    echo "│  │  ├─ Code: $USER_CODE"
    # user_name=$(yq eval ".devices.$device.user.name" $configYml)
    USER_NAME=$(sed -n '{s/^USER_NAME\s*=\s*//p}' $envINI)
    echo "│  │  ├─ Name: $USER_NAME"
    # user_pass=$(yq eval ".devices.$device.user.pass" $configYml)
    USER_PASS=$(sed -n '{s/^USER_PASS\s*=\s*//p}' $envINI)
    echo "│  │  └─ Pass: $USER_PASS"
}

feat_device(){
    echo "   └─ Device: "
    # device_code=$(yq eval ".devices.$device.device.code" $configYml)
    DEVICE_CODE=$(sed -n '{s/^DEVICE_CODE\s*=\s*//p}' $envINI)
    echo "      ├─ Code: $DEVICE_CODE"
    # device_addr=$(yq eval ".devices.$device.device.addr" $configYml)
    DEVICE_ADDR=$(sed -n '{s/^DEVICE_ADDR\s*=\s*//p}' $envINI)
    echo "      ├─ Addr: $DEVICE_ADDR"
    # device_type=$(yq eval ".devices.$device.device.type" $configYml)
    DEVICE_TYPE=$(sed -n '{s/^DEVICE_TYPE\s*=\s*//p}' $envINI)
    echo "      ├─ Type: $DEVICE_TYPE"
    # device_name=$(yq eval ".devices.$device.device.name" $configYml)
    DEVICE_NAME=$(sed -n '{s/^DEVICE_NAME\s*=\s*//p}' $envINI)
    echo "      ├─ Name: $DEVICE_NAME"
    # device_netk=$(yq eval ".devices.$device.device.netk" $configYml)
    DEVICE_NETK=$(sed -n '{s/^DEVICE_NETK\s*=\s*//p}' $envINI)
    echo "      ├─ Netk: $DEVICE_NETK"
    # device_soln=$(yq eval ".devices.$device.device.soln" $configYml)
    DEVICE_SOLN=$(sed -n '{s/^DEVICE_SOLN\s*=\s*//p}' $envINI)
    echo "      ├─ Soln: $DEVICE_SOLN"
    # device_desc=$(yq eval ".devices.$device.device.desc" $configYml)
    DEVICE_DESC=$(sed -n '{s/^DEVICE_DESC\s*=\s*//p}' $envINI)
    echo "      └─ Desc: $DEVICE_DESC"
}

# cpolar_version=$(yq eval ".devices.$device.applications.cpolar.version" $configYml)

# docker_version=$(yq eval ".devices.$device.applications.docker.version" $configYml)

main(){
    echo "├─ Variables:."
    feat_root
    feat_user
    feat_device
}

main