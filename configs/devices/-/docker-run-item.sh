!/bin/bash

echo -e "====\e[37;47m $device_name \e[0m Basic Info ==================="
echo -e UserName: $user_name
echo -e IP-Addr : $device_addr
echo -e IP-Name : $device_name
echo -e IP-Soln : $device_soln
echo -e Commands: ssh $user_name@$device_addr
echo 

echo -e "====\e[37;47m $device_name \e[0m Softwares  ==================="
ssh $user_name@$device_addr "cpolar version" 
ssh $user_name@$device_addr "docker -v" 
ssh $user_name@$device_addr "docker compose version" 
echo 
# ssh $user_name@$device_addr "docker-compose version" 
# ssh $user_name@$device_addr "docker rm -f ;"
# D:\wwwroot\@Langnang\_configs\@docker\VM-UbuntuServer-24\docker-compoe.yml
# ssh $user_name@$device_addr "sudo mkdir -p /app; sudo chmod -R 777 /app;"
# rsync -avz /本地路径/文件名 用户名@服务器IP:/目标路径/
# ssh $user_name@$device_addr "echo \"$user_pass\" | sudo -S chmod -R 777 /app;"
# exit

# scp -r "D:/wwwroot/@Langnang/_configs/@docker/$device_name/docker-compose.yml" $user_name@$device_addr:/app/ 

ssh $user_name@$device_addr "echo \"$user_pass\" | sudo -S mkdir -p /app;"
ssh $user_name@$device_addr "echo \"$user_pass\" | sudo -S chmod -R 777 /app;"

# scp -r "D:/wwwroot/@Langnang/_configs/@docker/$device_name/nginx" $user_name@$device_addr:/app/
# for service in $(yq eval ' .services | to_entries | .[] | .key' "D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/compose/docker-compose.yml"); do
#     ssh $user_name@$device_addr "docker compose -f docker-compose.yml up -d --build '$service';" 
# done
# ? common
scp -r D:/wwwroot/@Langnang/_configs/devices/-$device_type/docker/ $user_name@$device_addr:/app/
# * docker compose -f /app/docker-common/compose/docker-compose.database.yml up -d
# ssh $user_name@$device_addr "docker compose -f /app/docker-common/compose/docker-compose.database.yml up -d;" 
# * docker compose -f /app/docker-common/compose/docker-compose.host.yml up -d
# ssh $user_name@$device_addr "docker compose -f /app/docker-common/compose/docker-compose.host.yml up -d;" 
# * docker compose -f /app/docker-common/compose/docker-compose.proxy.yml up -d
# ssh $user_name@$device_addr "docker compose -f /app/docker-common/compose/docker-compose.proxy.yml up -d;" 
# * docker compose -f /app/docker-common/compose/docker-compose.yml up -d
# ssh $user_name@$device_addr "docker compose -f /app/docker-common/compose/docker-compose.yml up -d;" 

# ? feature
scp -r D:/wwwroot/@Langnang/_configs/devices/$device_name/docker/ $user_name@$device_addr:/app/
# * docker compose -f /app/docker/compose/docker-compose.database.yml up -d
ssh $user_name@$device_addr "docker compose -f /app/docker/compose/docker-compose.database.yml up -d;" 
# * docker compose -f /app/docker/compose/docker-compose.solution.yml up -d
ssh $user_name@$device_addr "docker compose -f /app/docker/compose/docker-compose.solution.yml up -d;" 
# * docker compose -f /app/docker/compose/docker-compose.host.yml up -d
ssh $user_name@$device_addr "docker compose -f /app/docker/compose/docker-compose.host.yml up -d;" 
# * docker compose -f /app/docker/compose/docker-compose.proxy.yml up -d
ssh $user_name@$device_addr "docker compose -f /app/docker/compose/docker-compose.proxy.yml up -d;" 
# * docker compose -f /app/docker/compose/docker-compose.yml up -d
ssh $user_name@$device_addr "docker compose -f /app/docker/compose/docker-compose.yml up -d;" 

# start ssh $user_name@$device_addr "docker compose -f /app/$device_name/docker-compose.database.yml up -d;" 
# ssh $user_name@$device_addr "docker-compose -f /appdocker-compose.yml up -d --build;" 
ssh $user_name@$device_addr "docker restart compose-frpc-1;" 
ssh $user_name@$device_addr "docker restart compose-nginx-1;" 
# ssh $user_name@$device_addr "docker -v; echo;" 
# ssh $user_name@$device_addr "docker -v; echo;" 
# ssh $user_name@$device_addr "docker swarm leave; echo;" 
# ssh $user_name@$device_addr "docker ps; echo;" 
# ssh $user_name@$device_addr "docker ps -a; echo;" 
# ssh $user_name@$device_addr "docker swarm join --token SWMTKN-1-12t8zahe3z6atepwi4w0ziigi9h5jm2xjdpncnatlcb3mtoet7-9owk085a6vd4tt2py72guc1la 101.126.135.139:2377;"

#? hello-world
# ssh $user_name@$device_addr "docker rm -f hello-world;docker run --name hello-world hello-world;"
#? portainer-agent
# ssh $user_name@$device_addr "docker run -d --name portainer-agent -p 9001:9001 -v //var/run/docker.sock:/var/run/docker.sock -v //var/lib/docker/volumes:/var/lib/docker/volumes --restart unless-stopped portainer/agent;"
#? dpanel
# ssh $user_name@$device_addr "docker run -d --name dpanel --restart=always -p 80:80 -p 443:443 -p 8807:8080 -e APP_NAME=dpanel -v /var/run/docker.sock:/var/run/docker.sock -v /app/dpanel:/dpanel dpanel/dpanel:lite"
#? homer
# ssh $user_name@$device_addr "docker run -d --name homer -p 8580:8080 -v /data/homer/data:/www/assets --restart=always b4bz/homer:latest"
#? mysql

#? postgresql