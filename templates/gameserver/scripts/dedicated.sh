#!/bin/bash

skip_maps=(
  'entry.umf'
  'intro.umf'
  'mf-WorldGamers.umf'
  'mf-thebigisland.umf'
  'mf-physics.umf'
)

modes=(
  'Rage.RageDeathmatch'
  'Rage.RageTeamGame'
  'RageGame.RageCaptains'
  'RageGame.RageCTF'
  'RageGame.RageDomination'
  'RageGame.RageDetonation'
  'RageGame.RageSafecracker'
  'RageGame.TrailerGame'
  'Racing.MentalRace'
  'MoBall.MoBallGame'
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

skip_maps=$(IFS='|'; echo "${skip_maps[*]:-^$}")
map=$(ls ../Maps/*.umf | grep -Ev $skip_maps | shuf -n 1 | xargs basename)

mode=()
for entry in "${modes[@]}"; do
  prefix="${entry%%.*}"

  if [ -f "${prefix}.u" ]; then
    mode+=("$entry")
  fi
done

mut=()
for entry in "${muts[@]}"; do
  prefix="${entry%%.*}"

  if [ -f "${prefix}.u" ]; then
    mut+=("$entry")
  fi
done

mode="${mode[$(( RANDOM % ${#mode[@]} ))]}"
mut=$(IFS=','; echo "${mut[*]}")
command="wine UCC.exe server $map?game=$mode?mutator=$mut ini=MobileForces.ini log=server.log"

unset skip_maps map modes mode muts mut
rm -f server.log

until $command; do
  echo "Server exited with code $?, restarting!" >&2
  sleep 1
done
