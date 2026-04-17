
basedir=$(cd $(dirname $0); pwd -P)

curl -fsSL https://get.docker.com -o $basedir/install-docker.sh

# 
#? 
feat_(){}

# c57c5cfc9afa77b5
#! Cannot connect to the Docker daemon at unix:///var/run/docker.sock. Is the docker daemon running?
fix_c57c5cfc9afa77b5(){}

# 657a484f296fad88
#! Job for docker.service failed because the control process exited with error code.
#! See "systemctl status docker.service" and "journalctl -xe" for details.
fix_657a484f296fad88(){}