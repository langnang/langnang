!/bin/bash

root_name=
root_pass=

user_name=
user_pass=

device_addr=
device_type=
device_name=HOST-Win10-Desktop
device_soln=

cpolar_version=3.3.12

docker_version=28.5.0

# cp -r D:/wwwroot/@Langnang/_configs/devices/-/docker/compose/frpc/frpc.toml D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose/frpc/frpc.toml


# cp -r D:/wwwroot/@Langnang/_configs/softwares/homer/assets/custom.css D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose/homer/custom.css

cp -r D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose D:/Programs/DockerApps/compose

# cp -r D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose/frpc/frpc.toml D:/Programs/DockerApps/compose/frpc/frpc.toml

docker compose -f D:/Programs/DockerApps/compose/docker-compose.yml up -d

# docker restart compose-frpc-1
# docker restart compose-nginx-1