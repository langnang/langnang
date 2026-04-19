# !/bin/bash

# lsblk
# lsblk -f
# feat_lsblk(){}

# # fdisk
# sudo fdisk -l
# feat_(){}
# ln -s /sbin/fdisk /usr/kerberos/bin

# 使用 lsblk 命令查看文件系统类型

# lsblk 命令是一个命令行工具，它显示了系统中所有已挂载卷的信息。这个工具通过读取 udev 数据库和 sysfs 文件系统来获取硬盘信息。它可以从块设备中提取标签（LABEL）、UUID 和文件系统类型，并在终端中显示出来。要查看更多已挂载卷的详细信息，可以使用 -f 参数，这样可以显示文件系统类型、LABEL 和 UUID 等更多详细信息。

# lsblk
# lsblk -f

# 使用 fdisk 命令查看文件系统信息

# fdisk 是 Linux 中的一个命令行工具，主要用于创建和管理磁盘分区。使用 -l 参数，可以列出磁盘驱动器的详细信息，如磁盘的类型、大小、型号、扇区大小和其他附加信息。

# sudo fdisk -l

# 使用 hwinfo 命令查看硬盘硬件信息

# hwinfo 是一款功能强大的工具，它提供了系统中硬盘的详细硬件信息。使用 --disk 参数，可以获取当前系统连接的所有磁盘驱动器的硬件信息。

# hwinfo --disk

# 使用 lshw 命令查看硬盘类型

# lshw 是一个强大的命令行工具，它能够提取出硬件配置的详细信息，包括硬盘的详细信息。使用 -class disk 参数，可以输出硬盘的详细信息，例如描述、产品类型、供应商、总线信息、版本和大小。

# sudo lshw -class disk

# while [ $# -gt 0 ]; do
#     case "$1" in
# 		--set_hostname)
#             set_hostname
# 			# shift
# 			;;
# 		--set_ssh)
# 			set_ssh
# 			;;
# 		--mirror)
# 			mirror="$2"
# 			shift
# 			;;
# 		--version)
# 			VERSION="${2#v}"
# 			shift
# 			;;
# 		--setup-repo)
# 			REPO_ONLY=1
# 			shift
# 			;;
# 		--*)
# 			echo "Illegal option $1"
# 			;;
# 	esac
# 	shift $(( $# > 0 ? 1 : 0 ))
# done
feat_ssh(){
    echo "│  ├─ SSH"
    # echo "│  │  ├─ Vern: "$(ssh $USER_NAME@$DEVICE_ADDR 'ssh -V;')
    echo "│  │  ├─ Vern: "
    unset ssh_vern
    echo "│  ├─ OpenSSL"
    echo "│  │  ├─ Vern: "$(ssh $USER_NAME@$DEVICE_ADDR "openssl version;")
}
feat_docker(){
    echo "│  ├─ Docker"
    echo "│  │  ├─ Vern: "$(ssh $USER_NAME@$DEVICE_ADDR "docker -v;")
    echo "│  ├─ Docker Compose"
    echo "│  │  ├─ Vern: "$(ssh $USER_NAME@$DEVICE_ADDR "docker compose version;")
}
feat_commands(){
    echo "│  ├─ Commands"
    echo "│  │  ├─ SSH: ssh $USER_NAME@$DEVICE_ADDR"

}
main(){
    echo "├─ Information:."
    feat_ssh
    feat_docker
    feat_commands
    # for device in $(yq eval '.devices | to_entries | .[] | .key' $configYml); do
    #     # feat_ssh $device
    # done
    # ssh $USER_NAME@$DEVICE_ADDR "echo '$user_pass' | hostname;"
    # ssh $USER_NAME@$DEVICE_ADDR "echo '$user_pass' | hostnamectl;"

    # # hostnamectl

    # echo main
}

main