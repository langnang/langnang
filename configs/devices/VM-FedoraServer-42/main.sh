root_name=
root_pass=

user_name=administrator
user_pass=root

device_addr=192.168.194.155
device_type=LinuxServer
device_name=VM-FedoraServer-42
device_soln=

cpolar_version=3.3.12

docker_version=28.2.2


. D:\\wwwroot\\@Langnang\\_configs\\devices\\info.sh --set_hostname --set_hostname

# ssh administrator@192.168.194.155

# ssh $user_name@$device_addr "docker rm -f 4d21be5a87ee_dpanel f3c77fba2aa6_nginx ae2e0e98f5bf_homer d5fbccda3f89_portainer-agent 5a857ed72520_hello-world;" 

# ssh $user_name@$device_addr "echo \"$user_pass\" | sudo -S mkdir -p /app;"
# ssh $user_name@$device_addr "echo \"$user_pass\" | sudo -S chmod -R 777 /app;"

# scp -r "D:/wwwroot/@Langnang/_configs/@docker/$device_name" $user_name@$device_addr:/app
# cp -r D:/wwwroot/@Langnang/_configs/softwares/homer/assets/custom.css D:/wwwroot/@Langnang/_configs/devices/VM-UbuntuServer/docker/compose/homer/custom.css

# scp -r D:/wwwroot/@Langnang/_configs/devices/VM-UbuntuServer/docker/ $user_name@$device_addr:/app/

# . D:/wwwroot/@Langnang/_configs/applications/docker/main-item.sh


# Welcome to Ubuntu 24.04 LTS (GNU/Linux 6.8.0-85-generic x86_64)

#  * Documentation:  https://help.ubuntu.com
#  * Management:     https://landscape.canonical.com
#  * Support:        https://ubuntu.com/pro

#  System information as of Thu Oct 23 04:49:05 PM UTC 2025

#   System load:  0.15              Processes:              241
#   Usage of /:   64.8% of 9.75GB   Users logged in:        1
#   Memory usage: 21%               IPv4 address for ens33: 192.168.194.133
#   Swap usage:   0%

#  * Strictly confined Kubernetes makes edge and IoT secure. Learn how MicroK8s
#    just raised the bar for easy, resilient and secure K8s cluster deployment.

#    https://ubuntu.com/engage/secure-kubernetes-at-the-edge

# Expanded Security Maintenance for Applications is not enabled.

# 174 updates can be applied immediately.
# 3 of these updates are standard security updates.
# To see these additional updates run: apt list --upgradable

# Enable ESM Apps to receive additional future security updates.
# See https://ubuntu.com/esm or run: sudo pro status

