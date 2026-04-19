!/bin/sh

root_name=
root_pass=

user_name=administrator
user_pass=root

device_addr=192.168.194.166
device_type=LinuxServer
device_name=VM-UbuntuServer-18
device_soln=

cpolar_version=3.3.12

docker_version=20.10.21


# ssh administrator@192.168.194.166
# cp -r D:\\wwwroot\\@Langnang\\_configs\\softwares\\homer\\assets\\custom.css D:\\wwwroot\\@Langnang\\_configs\\devices\\VM-UbuntuServer\\docker\\compose\\homer\\custom.css

# scp -r D:/wwwroot/@Langnang/_configs/devices/VM-UbuntuServer/docker/ $user_name@$device_addr:/app/

. D:\\wwwroot\\@Langnang\\_configs\\applications\\docker\\main-item.sh

# Welcome to Ubuntu 18.04.4 LTS (GNU/Linux 4.15.0-213-generic x86_64)       

#  * Documentation:  https://help.ubuntu.com
#  * Management:     https://landscape.canonical.com
#  * Support:        https://ubuntu.com/advantage

#   System information as of Wed Oct 22 07:22:36 UTC 2025

#   System load:  0.0                Processes:              167
#   Usage of /:   33.5% of 19.51GB   Users logged in:        0
#   Memory usage: 9%                 IP address for ens33:   192.168.194.149
#   Swap usage:   0%                 IP address for docker0: 172.17.0.1     


#  * Canonical Livepatch is available for installation.
#    - Reduce system reboots and improve kernel security. Activate at:
#      https://ubuntu.com/livepatch

# 74 packages can be updated.
# 1 update is a security update.

# New release '20.04.6 LTS' available.
# Run 'do-release-upgrade' to upgrade to it.

# scp -r D:/wwwroot/@Langnang/_configs/@docker/$device_name/ $user_name@$device_addr:/app/
