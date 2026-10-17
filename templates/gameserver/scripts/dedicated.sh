#!/bin/bash

skip_maps=(
  'entry.umf'
  'intro.umf'
)

# Game class: map prefix, and 1 if it may also start on maps without that prefix
declare -A modes=(
  ['Rage.RageDeathMatch']='DM:1'
  ['Rage.RageTeamGame']='TDM:1'
  ['RageGame.RageCaptains']='CAP:1'
  ['RageGame.RageCTF']='CTF:1'
  ['RageGame.RageDomination']='DOM:1'
  ['RageGame.RageDetonation']='DET:1'
  ['RageGame.RageSafeCracker']='SC:1'
  ['RageGame.TrailerGame']='TRA:1'
  ['trailerGameV2.trailerGameV2']='TRA:1'
  ['Racing.MentalRace']='MR:1'
  ['MoBall.MoBallGame']='MB:1'
  ['arenaMode.arenaMode']='ARENA:1'
  ['ZombieGame.ZombieGame']='ZM:1'
  ['TugGame.TugGame']='TG:1'
  ['CoopMode.CoopMode']='COOP:1'
  ['KOH.KOHGame']='KOH:1'
  ['battleRoyale.battleRoyale']='BR:0'
  ['KnifeFight.KnifeFightGame']='DM:0'
  ['Swars.ShotgunWarsGame']='DM:1'
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

map_prefix=${map%%-*} # map prefix chooses the game mode
map_prefix=${map_prefix^^}

# Installed modes made for this map, otherwise the installed ones fit for any map
mode=()
fallback=()
for entry in "${!modes[@]}"; do
  if [ -f "${entry%%.*}.u" ]; then
    if [ "${modes[$entry]%:*}" = "$map_prefix" ]; then
      mode+=("$entry")
    elif [ "${modes[$entry]#*:}" = 1 ]; then
      fallback+=("$entry")
    fi
  fi
done

if [ ${#mode[@]} -eq 0 ]; then
  mode=("${fallback[@]}")
fi
mode="${mode[RANDOM % ${#mode[@]}]}"

mut=()
for entry in "${muts[@]}"; do
  prefix="${entry%%.*}"

  if [ -f "${prefix}.u" ]; then
    mut+=("$entry")
  fi
done

mut=$(IFS=','; echo "${mut[*]}")
command="wine UCC.exe server $map?game=$mode?mutator=$mut ini=MobileForces.ini log=server.log"

unset skip_maps map map_prefix modes fallback mode muts mut
rm -f server.log

until $command; do
  echo "Server exited with code $?, restarting!" >&2
  sleep 1
done
