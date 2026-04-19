!/bin/bash

echo -e "====\e[37;47m $device_name \e[0m Basic Info    ==================="
echo -e UserName: $user_name
echo -e IP-Addr : $device_addr
echo -e IP-Name : $device_name
echo -e IP-Soln : $device_soln
echo -e Commands: ssh $user_name@$device_addr
echo 

echo -e "====\e[37;47m $device_name \e[0m Applications  ==================="
ssh $user_name@$device_addr "cpolar version" 
ssh $user_name@$device_addr "docker -v" 
ssh $user_name@$device_addr "docker compose version" 
echo 

echo -e "====\e[37;47m $device_name \e[0m Softwares     ==================="
ssh $user_name@$device_addr "docker ps" 
echo 
