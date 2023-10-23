#!/bin/sh

command='wine ucc.exe server mf-Ghetto?game=RageGame.RageSafeCracker?mutator=vote.vote,voteMutWindow.windowMut ini=MobileForces.ini log=server.log'
until $command; do
  echo 'Server crashed with exit code $?, restarting!' >&2
  sleep 1
done
