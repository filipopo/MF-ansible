#!/bin/sh

output=${1:-pwd/..}
game=${2:-pwd/..}

updateFiles=(
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

mkdir -p $output
cd $game
zip -9 -r "${output}/Update.zip" "${updateFiles[@]}"

sed -e 's/AdminEmail=.*/AdminEmail=/' \
  -e 's/AdminPassword=.*/AdminPassword=/' \
  System/MobileForces.ini > "${output}/Mobileforces.ini"

cd $output
zip -9 -u Update.zip Mobileforces.ini
cp Update.zip RUpdate.zip

updateFiles=(
  'Textures/rage_warehouse.utx'
  'System/RageGfx.u'
  'System/RageEffects.u'
  'System/Fire.u'
  'System/Core.u'
  'Sounds/RagePlayerVoice.uax'
  'Sounds/Announcer.uax'
)

cd $game
zip -9 -u "${output}/RUpdate.zip" "${updateFiles[@]}"
