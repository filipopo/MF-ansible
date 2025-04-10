#!/bin/bash

map=(
  'mf-airport'
  'mf-Carpark'
  'mf-dockyard'
  'mf-Ghetto'
  'mf-Hydroworks'
  'mf-Polar'
  'mf-Rail_Quarry'
  'mf-sawmill'
  'mf-warehouse'
  'mf-waterfront'
  'mf-western'
)

mode=(
  'Rage.RageDeathmatch'
  'Rage.RageTeamGame'
  'RageGame.RageCaptains'
  'RageGame.RageCTF'
  'RageGame.RageDomination'
  'RageGame.RageDetonation'
  'RageGame.RageSafecracker'
  'RageGame.TrailerGame'
)

index=$(( RANDOM % ${#map[@]} ))
map="${map[$index]}"

index=$(( RANDOM % ${#mode[@]} ))
mode="${mode[$index]}"

rm -f server.log
command="wine UCC.exe server \
  $map?game=$mode?mutator=Vote.Vote,VoteMutWindow.WindowMut,VoteHUD.VoteHUD,MutPack.AddWeaps,MutPack.ChangeBotInv,MutPack.ReplaceVehicles,MutPack.AddVehicles,MutPack.Commands,MutPack.ChangeDefProperties,MutPack.ChangeDamage \
  ini=MobileForces.ini log=server.log"

until $command; do
  echo "Server crashed with exit code $?, restarting!" >&2
  sleep 1
done
