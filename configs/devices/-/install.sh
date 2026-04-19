#!/bin/sh
# set -e


feat_yq(){
    YQ=$(yq --version)
    echo $YQ
    # sudo apt-get install yq
}

feat_cpolar(){
    main(){
        echo cpolar
    }
    main
}

# fix_cpolar_(){}

feat_docker(){
    main(){
        echo docker
    }
    main
}
# fix_docker_(){}
main(){
    feat_yq
    feat_cpolar
    feat_docker
}

main