!/bin/bash

root_user=
root_pass=

user_name=administrator
user_pass=root

device_addr=192.168.194.135
device_name=VM-Ubuntu-24
device_soln=

cpolar_version=3.3.12

docker_version=28.4.0

# ssh administrator@192.168.194.135 
cp -r D:/wwwroot/@Langnang/_configs/softwares/homer/assets/custom.css D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose/homer/custom.css

. D:/wwwroot/@Langnang/_configs/applications/docker/main-item.sh


docker compose -f /mnt/hgfs/-Linux/docker/compose/docker-compose.yml up -d
docker compose -f /mnt/hgfs/VM-Ubuntu-24/docker/compose/docker-compose.yml up -d

. D:/wwwroot/@Langnang/_configs/devices/main.sh --name=VM-Ubuntu-24
