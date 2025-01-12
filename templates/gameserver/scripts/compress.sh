#!/bin/bash
# Compresses game files for fastDL and only re-compresses when changes have been detected, saving time

# Set folder locations
fastdl="${1:-'../fast_download'}/"
game="${2:-..}/"

# Ensure the fastdl folder exists
mkdir -p $fastdl

# Copy/UCC compress/both extensions
declare -A arr=(
  ['Maps']='umf:u'
  ['Music']='umx:u'
  ['Physics']='COL:c,hnd2:c'
  ['Sounds']='uax:u'
  ['System']='int:c,u:b'
  ['Textures']='utx:u,usx:u'
)

# Go through each folder
for folder in "${!arr[@]}"; do
  # Extract extension-action pairs
  IFS=',' read -ra extensions <<< "${arr[$folder]}"

  for ext_action in "${extensions[@]}"; do
    # Split extension and action
    IFS=':' read -r extension action <<< $ext_action

    # Iterate over files with the current extension in the folder
    for file in ${game}${folder}/*.${extension}; do
      # Skip if no files match
      [ -e $file ] || continue

      # Get the sha sum of the saved compressed file and compare it to the current version
      sum_file="${fastdl}$(echo $file | awk -F / '{print $NF}').sha"
      shasum -a 512 -c -s $sum_file 2> /dev/null

      # If the sum is not matching (or doesn't exist) compress the file and update the sha sum
      if [ $? -ne 0 ]; then
        if [[ "$action" == @(u|b) ]]; then
          echo "Compressing $file"
          wine UCC.exe compress $file
          #sleep 0.1

          touch "${file}.uz" -r $file
          mv "${file}.uz" $fastdl
        fi

        if [[ "$action" == @(c|b) ]]; then
          echo "Copying $file"
          cp -p $file $fastdl
        fi

        shasum -a 512 $file > $sum_file
        touch $sum_file -r $file

        shasum -a 256 $file > "${sum_file}256"
        touch "${sum_file}256" -r $file
      fi
    done
  done
done

# Copy "first" hashes then the rest
first=(
  'EffectsFix.u.sha256'
  'Rage.u.sha256'
  'Engine.u.sha256'
  'RageWeapons.u.sha256'
)

cd $fastdl; cat "${first[@]}" > shasums.txt
arr=$(IFS='|'; echo "${first[*]}")
cat $(ls -t *.sha256 | grep -Ev $first) >> shasums.txt
