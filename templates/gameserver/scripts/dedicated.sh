#!/bin/bash

skip_map=(
  'entry.umf'
  'intro.umf'
  'mf-WorldGamers.umf'
  'mf-thebigisland.umf'
  'mf-physics.umf'
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

skip_map=$(IFS='|'; echo "${skip_map[*]:-^$}")
map=$(ls ../Maps/*.umf | grep -Ev $skip_map | shuf -n 1 | xargs basename)

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
command="wine UCC.exe server $map?game=$mode?mutator=$mut ini=MobileForces.ini log=server.log"

unset skip_map map mode index muts mut
rm -f server.log

until $command; do
  echo "Server exited with code $?, restarting!" >&2
  sleep 1
done
