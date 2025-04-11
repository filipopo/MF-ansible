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

muts=(
  'vote.Vote'
  'voteMutWindow.WindowMut'
  'voteHUD.VoteHUD'
  'mutPack.AddWeaps'
  'mutPack.ChangeBotInv'
  'mutPack.ReplaceVehicles'
  'mutPack.AddVehicles'
  'mutPack.Commands'
  'mutPack.ChangeDefProperties'
  'mutPack.ChangeDamage'
)

index=$(( RANDOM % ${#map[@]} ))
map="${map[$index]}"

index=$(( RANDOM % ${#mode[@]} ))
mode="${mode[$index]}"

mut=()
for entry in "${muts[@]}"; do
  prefix="${entry%%.*}"

  if [ -f "${prefix}.u" ]; then
    mut+=("$entry")
  fi
done

mut=$(IFS=','; echo "${mut[*]}")
rm -f server.log

command="wine UCC.exe server $map?game=$mode?mutator=$mut ini=MobileForces.ini log=server.log"
until $command; do
  echo "Server crashed with exit code $?, restarting!" >&2
  sleep 1
done
