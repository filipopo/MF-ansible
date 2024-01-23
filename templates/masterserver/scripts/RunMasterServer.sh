#!/bin/sh

command='wine UCC.exe masterserver'
until $command; do
  echo "Server crashed with exit code $?, restarting!" >&2
  sleep 1
done
