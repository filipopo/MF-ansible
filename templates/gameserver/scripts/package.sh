#!/bin/sh

output=${1:-..}
game=${2:-..}

updateFiles=(
  'Mobileforces.ini'
  'UpdateReadme.txt'
  'System/EffectsFix.u'
  'System/Rage.u'
  'System/Engine.u'
  'System/RageWeapons.u'
  'System/RageGame.u'
  'System/RageMenu.u'
  'Physics/piper.COL'
  'Physics/jeep.COL'
  'Physics/heli.COL'
  'Physics/handling.hnd2'
  'Physics/boat.COL'
  'Maps/mf-Ghetto.umf'
)

rupdateFiles=(
  'Textures/rage_warehouse.utx'
  'System/RageGfx.u'
  'System/RageEffects.u'
  'System/Fire.u'
  'System/Core.u'
  'Sounds/RagePlayerVoice.uax'
  'Sounds/Announcer.uax'
)

mkdir -p $output
cd $game

sed -e 's/AdminEmail=.*/AdminEmail=/' \
  -e 's/AdminPassword=.*/AdminPassword=/' \
  System/MobileForces.ini > Mobileforces.ini

zip -9 -FS "${output}/Update.zip" "${updateFiles[@]}"
zip -9 -FS "${output}/RUpdate.zip" "${updateFiles[@]}" "${rupdateFiles[@]}"
