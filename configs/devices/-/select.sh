!/bin/bash
PS3="请选择任务(5退出): "
while true; do
select choice in 磁盘 文件系统 CPU 内存 退出; do
case $choice in
磁盘) fdisk -l; break;;
文件系统) df -h; break;;
CPU) uptime; break;;
内存) free -m; break;;
退出) exit 0;;
*) echo "错误选项";;
esac
done
echo "-----------------------------"
done