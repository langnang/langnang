# !/bin/sh
# sh -c "docker compose -f /mnt/hgfs/\-/docker/compose/docker-compose.yml up -d"
# echo off
# configYml="./config.yml"

# # hostname
# # echo $?
# device_name=$(cat /etc/hostname)

# echo $device_name

# /mnt/hgfs/$device_name/main.sh

# echo "123测试"
# # cd /mnt/hgfs/-/
# # sh /mnt/hgfs/-/main.sh
# # VM-CentOS-8 
# # VM-FedoraServer-42 
# # VM-fnOS-37 
# # devices="VM-Debian-13 VM-Ubuntu-24 VM-UbuntuServer-18 VM-UbuntuServer-22 VM-UbuntuServer-24 VolcEngine-ECS-Debian-12"

# # for device in $devices
# # do 
# #     . D:/wwwroot/@Langnang/_configs/@docker/$device/main.sh
# # done

# # feat_info(){}

# # main(){
#     # for device in $(yq eval '.devices | to_entries | .[] | .key' $configYml); do
#     #     echo $device
#     # done
# # }

# # main
