#!/bin/sh

output=${1:-$PWD/..}
game=${2:-$PWD/..}

updateFiles=(
  'Mobileforces.ini'
  'Maps/mf-Ghetto.umf'
  'Physics/piper.COL'
  'Physics/jeep.COL'
  'Physics/heli.COL'
  'Physics/handling.hnd2'
  'Physics/boat.COL'
  'System/EffectsFix.u'
  'System/Rage.u'
  'System/Engine.u'
  'System/RageWeapons.u'
  'System/RageGame.u'
  'System/RageMenu.u'
)

ENupdateFiles=(
  'System/RageGfx.u'
  'System/RageEffects.u'
  'System/Fire.u'
  'System/Core.u'
  'Textures/rage_warehouse.utx'
)

RUupdateFiles=(
  'Sounds/RagePlayerVoice.uax'
  'Sounds/Announcer.uax'
)

defaultFiles=(
  'Maps/entry.umf'
  'Maps/intro.umf'
  'Maps/mf-airport.umf'
  'Maps/mf-Carpark.umf'
  'Maps/mf-dockyard.umf'
  'Maps/mf-Ghetto.umf'
  'Maps/mf-Hydroworks.umf'
  'Maps/mf-Polar.umf'
  'Maps/mf-Rail_Quarry.umf'
  'Maps/mf-sawmill.umf'
  'Maps/mf-warehouse.umf'
  'Maps/mf-waterfront.umf'
  'Maps/mf-western.umf'
  'Music/Ambient01.umx'
  'Music/Ambient02.umx'
  'Music/Ambient03.umx'
  'Music/Frontend.umx'
  'Music/Victory.umx'
  'Physics/Apc.COL'
  'Physics/Armadillo.COL'
  'Physics/ball.COL'
  'Physics/biplane.COL'
  'Physics/Buggy.COL'
  'Physics/Cobra.COL'
  'Physics/humvee.COL'
  'Physics/Trailer.COL'
  'Physics/truck.COL'
  'Physics/WheelL.COL'
  'Physics/WheelR.COL'
  'Physics/handling.hnd2'
  'Sounds/Announcer.uax'
  'Sounds/ArmadilloSFX.uax'
  'Sounds/BuggySFX.uax'
  'Sounds/CTFSFX.uax'
  'Sounds/DetSFX.uax'
  'Sounds/DominationSFX.uax'
  'Sounds/footstepSFX.uax'
  'Sounds/GibsSFX.uax'
  'Sounds/HumveeSFX.uax'
  'Sounds/levelSFX.uax'
  'Sounds/MiscSFX.uax'
  'Sounds/oneshotSFX.uax'
  'Sounds/RageMenuSFX.uax'
  'Sounds/RagePlayerSounds.uax'
  'Sounds/RagePlayerVoice.uax'
  'Sounds/SafeCrackerSFX.uax'
  'Sounds/TrailerSFX.uax'
  'Sounds/TruckSFX.uax'
  'Sounds/VehicleFragSFX.uax'
  'Sounds/WallHitSFX.uax'
  'Sounds/WeaponSFX_AdrenalineShot.uax'
  'Sounds/WeaponSFX_Grenades.uax'
  'Sounds/WeaponSFX_HeavyMachineGun.uax'
  'Sounds/WeaponSFX_Knife.uax'
  'Sounds/WeaponSFX_MachineGun.uax'
  'Sounds/WeaponSFX_Pistol.uax'
  'Sounds/WeaponSFX_RocketLauncher.uax'
  'Sounds/WeaponSFX_Shotgun.uax'
  'Sounds/WeaponSFX_SniperRifle.uax'
  'Sounds/WeaponSFX_TripBombs.uax'
  'Sounds/WheelSFX.uax'
  'System/Core.int'
  'System/Core.u'
  'System/D3DDrv.int'
  'System/Editor.int'
  'System/Editor.u'
  'System/Engine.int'
  'System/Engine.u'
  'System/Fire.u'
  'System/Galaxy.int'
  'System/IpDrv.int'
  'System/IpDrv.u'
  'System/IpServer.int'
  'System/IpServer.u'
  'System/License.int'
  'System/Manifest.int'
  'System/MobileForcesEd.int'
  'System/MobileForces.int'
  'System/RageBrowser.int'
  'System/RageBrowser.u'
  'System/RageEffects.u'
  'System/RageGame.int'
  'System/RageGame.u'
  'System/RageGfx.int'
  'System/RageGfx.u'
  'System/Rage.int'
  'System/Rage.u'
  'System/RageMenu.int'
  'System/RageMenu.u'
  'System/RageWeapons.int'
  'System/RageWeapons.u'
  'System/Setup.int'
  'System/Startup.int'
  'System/UBrowser.int'
  'System/UBrowser.u'
  'System/UWindow.u'
  'System/Window.int'
  'System/WinDrv.int'
  'Textures/car_park.utx'
  'Textures/Dam.utx'
  'Textures/DemoScreens.utx'
  'Textures/icebase.utx'
  'Textures/MobileForceFonts.utx'
  'Textures/rage_airport.utx'
  'Textures/rage_dock.utx'
  'Textures/rage_generic.utx'
  'Textures/rage_lumberyard.utx'
  'Textures/rage_marina.utx'
  'Textures/RagePlayerGfx.utx'
  'Textures/rage_pueblo.utx'
  'Textures/RageRobotGfx.utx'
  'Textures/RageScreenShots.utx'
  'Textures/rage_snow.utx'
  'Textures/rage_urban.utx'
  'Textures/rage_warehouse.utx'
  'Textures/Steve-DM1.utx'
  'Textures/train.utx'
)

customFiles=(
  '*.umf'
  '*.umx'
  '*.COL'
  '*.hnd2'
  '*.uax'
  '*.int'
  '*.u'
  '*.utx'
)

mkdir -p $output
cd $game

sed -e 's/AdminEmail=.*/AdminEmail=/' \
  -e 's/AdminPassword=.*/AdminPassword=/' \
  System/MobileForces.ini > Mobileforces.ini

zip -9 -u "${output}/Update.zip" "${updateFiles[@]}"
zip -9 -u "${output}/RUupdate.zip" "${updateFiles[@]}" "${ENupdateFiles[@]}"

zip -9 -FS -r "${output}/Addons.zip" . \
  -x "${updateFiles[@]}" "${defaultFiles[@]}" \
  -i "${customFiles[@]}"

zip -9 -u -j "${output}/Update.zip" Docs/update/UpdateReadme.txt
zip -9 -u -j "${output}/RUupdate.zip" Docs/ru-update/UpdateReadme.txt

cd "$game/../MobileForcesRU"
zip -9 -u "${output}/RUupdate.zip" "${RUupdateFiles[@]}"
