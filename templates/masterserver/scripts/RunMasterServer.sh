#!/bin/sh

command='./ucc-bin-amd64 masterserver'
until $command; do
  echo 'Server crashed with exit code $?, restarting!' >&2
  sleep 1
done
