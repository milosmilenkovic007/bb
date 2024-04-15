#!/bin/bash
_name="swish-qr"
_port="8080"
if [[ "$1" != "up" && "$1" != "down" ]]
then
        echo "Syntax $0 up/down"
        exit 1
fi
[[ "$1" == "up" ]]   && docker run --rm --publish ${_port}:80 --name ${_name} --detach $(docker build -q .)
[[ "$1" == "down" ]] && docker stop ${_name}
