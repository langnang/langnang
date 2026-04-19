

curl -L https://www.cpolar.com/static/downloads/install-release-cpolar.sh | sudo bash

cpolar version

# 设置开机自启
sudo systemctl enable cpolar

# 启动服务
sudo systemctl start cpolar

# 查看服务状态
sudo systemctl status cpolar