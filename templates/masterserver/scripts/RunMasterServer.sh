#!/bin/sh

until ./MasterServer-Qt5; do
  echo "Server crashed with exit code $?, restarting!" >&2
  sleep 1
done
