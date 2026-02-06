#!/bin/bash

skip_maps=(
  'entry.umf'
  'intro.umf'
  'mf-WorldGamers.umf'
  'mf-thebigisland.umf'
  'mf-physics.umf'
)

modes=(
  'Rage.RageDeathmatch:DM'
  'Rage.RageTeamGame:TDM'
  'RageGame.RageCaptains:CAP'
  'RageGame.RageCTF:CTF'
  'RageGame.RageDomination:DOM'
  'RageGame.RageDetonation:DET'
  'RageGame.RageSafecracker:SC'
  'RageGame.TrailerGame:TRA'
  'Racing.MentalRace:MR'
  'MoBall.MoBallGame:MB'
  'arenaMode.arenaMode:ARENA'
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

skip_maps=${map%%-*} # get map extension for choosing game mode
skip_maps=${skip_maps^^}

mode=()
for entry in "${modes[@]}"; do
  prefix="${entry%%.*}"

  if [ -f "${prefix}.u" ]; then
    if [ "${entry##*:}" = "$skip_maps" ]; then
      mode=("${entry%%:*}")
      break
    else
      mode+=("${entry%%:*}")
    fi
  fi
done

modes=$(( RANDOM % ${#mode[@]} ))
mode="${mode[$modes]}"

mut=()
for entry in "${muts[@]}"; do
  prefix="${entry%%.*}"

  if [ -f "${prefix}.u" ]; then
    mut+=("$entry")
  fi
done

mut=$(IFS=','; echo "${mut[*]}")
command="wine UCC.exe server $map?game=$mode?mutator=$mut ini=MobileForces.ini log=server.log"

unset skip_maps map modes mode muts mut
rm -f server.log

until $command; do
  echo "Server exited with code $?, restarting!" >&2
  sleep 1
done
