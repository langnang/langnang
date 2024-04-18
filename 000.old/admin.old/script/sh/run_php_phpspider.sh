#!/bin/bash

for file in $(ls ./../php/phpspider)
do 
    if [ "${file##*.}" = "json" ]; then
        
        name=${file%%.*}
        
        screen_name=$"PhpSpider.$name"
        
        if ! screen -list | grep -q $screen_name; then
            screen -dmS $screen_name
        fi
        
        cmd=$"php /www/wwwroot/langnnang/script/php/phpspider/index.php start $name insert";
        
        screen -x -S $screen_name -p 0 -X stuff "$cmd"
        screen -x -S $screen_name -p 0 -X stuff $'\n'
    fi
done

