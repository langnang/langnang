# !/bin/bash


feat_ssh(){
     # SSH
    # SSH 免密登录
    # 使用密码登录到目标服务器：

    # 在服务器上创建 .ssh 目录并设置权限：
    mkdir -p ~/.ssh
    chmod 700 ~/.ssh

    # 编辑或创建 authorized_keys 文件，将公钥内容粘贴进去：
    # vi ~/.ssh/authorized_keys
    # Desktop + Laptop
    echo -e "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQDbIinj4Q2Z7bv0jIgknnGp9MFyHOvutuNEQNBKTsUagVpw3kSBX7cX2QPHOfuqSNhqYUsqwCNahM9v+LQDRUw7g3hKej81QRfRXf8mLqtbyUhDDOQvIVqTkh1yiReLDRuCJZW0F+5AuxEWkmNvSlXqra2RYMcKND/oHEHV0eCuPGK2VX30FNy0N10i8t2FYNGYd1y4NYUhBmD4+y9r0brzxzntgCcxMxw5TUx2UGbAq/kBjSFQLeEC25O54I+2ErvXfcEwv9q5mDGa54llrUXtWf9HXy8JJjD1XrUbQe7ryLHnLZfTi70OEakb5twIR0fRvZcxhT1EBT7fKFpknM1J+c7C+6YXeRaQ64MaG20YTnPn383zSUqpVANPDoAQfU6gwzhJEzaDyhBCYX3+MkJn77G8F4Aa3LEkaWet9Th4jE5/PIQPgqFna6OlkobqKZYqh/gHizYX5ePCHz4EjTK/7++73+IhHNENOGNbwg5bOHXOwXVYZdxmzgS7mbw2mWM= administrator@DESKTOP-BT4Q1PG\nssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQDPnLS2uocic1ThK5EPeSfVLxYnkuSlp7dGUJzGSlOco6eeeyurzGBpBZbVAMDD3dcdJSmjRxSdyvFB3987tw5dFD200u5IvTUbFKRUJON+jxbRZrv6Y72CzIh9q8rXsMWkOCw6GgDx8N8VzZ7Qf35bIb/3btWA7ZER+1g+a5t4qyv4RXqeBNUQgp9Up5CZbRlfXpjm88GwZMDSIONDqlBwR7npJlaN3wv8FwFyMqNQXegeqARcqW7UCmfMtwKtpj/3zKtEOWVwSvlZU2flDaJLgb/gsFaLc7lTe1ycH1Otu+61kWoYY6VK678gIAObk6s4/vA9sWf2H4W3DH6qj9+aFlGUC3H16QfFxYcszzgcTcY+58pucWgjyDpnmqSMMizU00I8oF3hkyP6KkWpoCB4oaK/MWpxN4HsIRQ0gEbhpHHA/C713gTVyyBIRPD0e0kRNz3fsYhJzzVGQBOLd98kiSA2/nYc77DLlmdRVNofFjBEGa7vmd0i62u/4CxKfEU= langnang.chen@outlook.com\n" >  ~/.ssh/authorized_keys
    #! -bash: /root/.ssh/authorized_keys: Operation not permitted
    #? chattr -ia ~/.ssh/authorized_keys
    #? chmod 400 ~/.ssh/authorized_keys
    #? chattr +ia ~/.ssh/authorized_keys
    # 设置文件权限：
    chmod 600 ~/.ssh/authorized_keys
}

feat_hostname(){
    echo set_hostname
    # 设置新主机名 使用以下命令替换为新的主机名：
    # sudo hostnamectl set-hostname 新主机名

    # ssh $user_name@$device_addr "echo \"$user_pass\" | sudo -S chmod -R 777 /app;"
}