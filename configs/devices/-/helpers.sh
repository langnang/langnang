# !/bin/bash

is_linux(){
    return false
}

is_windows(){
    return false
}

has_hgfs(){
    return false
}

exist_hgfs(){
    exists=$(ssh $USER_NAME@$DEVICE_ADDR '[ -d /mnt/hgfs ]')
    # echo $exists
    if [ ! $exists ]; then
        # echo 目录不存在 
        unset exists
        return 0
    else
        # echo 目录存在 
        unset exists
        return 1
    fi
}

exist_hgfs_device_type(){
    return false
}