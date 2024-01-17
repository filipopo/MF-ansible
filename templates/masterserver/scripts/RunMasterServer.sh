#!/bin/sh

command='./ucc-bin masterserver'
until $command; do
  echo "Server crashed with exit code $?, restarting!" >&2
  sleep 1
done
