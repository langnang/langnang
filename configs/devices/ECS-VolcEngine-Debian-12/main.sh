# !/bin/bash

# . D:/wwwroot/@Langnang/_configs/devices/docker-run.sh


. D:/wwwroot/@Langnang/_configs/devices/-/vars.sh

. D:/wwwroot/@Langnang/_configs/devices/-/helpers.sh

# . D:/wwwroot/@Langnang/_configs/devices/-/conf.sh

. D:/wwwroot/@Langnang/_configs/devices/-/info.sh

. D:/wwwroot/@Langnang/_configs/devices/-/utils.sh feat-homer feat-nginx

# . D:/wwwroot/@Langnang/_configs/devices/-/deploy.sh $DEVICE_NAME

exist_hgfs
if [[ "$?" = "0" ]]; then
    echo "目录不存在"
    
else
    echo "目录存在"
fi


scp -r D:/wwwroot/@Langnang/_configs/devices/$DEVICE_NAME/docker/ $USER_NAME@$DEVICE_ADDR:/app/

ssh $USER_NAME@$DEVICE_ADDR "docker compose -f /app/docker/compose/docker-compose.yml up -d;" 

ssh $USER_NAME@$DEVICE_ADDR "docker restart compose-nginx-1;" 
# echo $device
# echo $device_name

# . D:/wwwroot/@Langnang/_configs/devices/docker-run.sh $device_name

# root_name=
# root_pass=

# user_name=root
# user_pass=chenLL!995

# device_addr=101.126.135.139
# device_type=
# device_soln=

# cpolar_version=3.3.12

# docker_version=28.5.0

# ssh root@101.126.135.139

# . D:/wwwroot/@Langnang/_configs/devices/docker-echo.sh

# cp -r D:/wwwroot/@Langnang/_configs/softwares/homer/assets/custom.css D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose/homer/custom.css

# . D:/wwwroot/@Langnang/_configs/devices/docker-run-item.sh


# - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/docker-compose.yml root@101.126.135.139:/app/
# - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/docker-compose.host.yml root@101.126.135.139:/app/
# # - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/frpc root@101.126.135.139:/app/
# - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/frps root@101.126.135.139:/app/
# - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/homer root@101.126.135.139:/app/
# - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/nginx root@101.126.135.139:/app/
# # - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/portainer root@101.126.135.139:/app/
# # - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/smartping root@101.126.135.139:/app/
# # - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/vaultwarden root@101.126.135.139:/app/
# - scp -r D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/prometheus root@101.126.135.139:/app/
# - ssh root@101.126.135.139 "cd /app; docker compose -f docker-compose.yml up -d --build;"
# - ssh root@101.126.135.139 "cd /app; docker compose -f docker-compose.host.yml up -d  --build;"
# - ssh root@101.126.135.139 "cd /app; docker restart app-frps-1;"
# # - docker-compose -f 'D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/docker-compose.yml' up -d --build
# # - docker-compose -f 'D:/wwwroot/@Langnang/_configs/@docker/esc-debian-12/docker-compose.host.yml' up -d --build
# # - docker restart esc-debian-12-nginx-1


# Linux VolcEngine-ECS-Debian-12 6.1.0-40-amd64 #1 SMP PREEMPT_DYNAMIC Debian 6.1.153-1 (2025-09-20) x86_64

# The programs included with the Debian GNU/Linux system are free software;
# the exact distribution terms for each program are described in the
# individual files in /usr/share/doc/*/copyright.

# Debian GNU/Linux comes with ABSOLUTELY NO WARRANTY, to the extent
# permitted by applicable law.