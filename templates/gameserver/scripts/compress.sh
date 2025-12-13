#!/bin/bash
# Compresses game files for fastDL and only re-compresses when changes have been detected, saving time

# Set folder locations
fastdl="${1:-'../fast_download'}/"
game="${2:-..}/"

# Ensure the fastdl folder exists
mkdir -p $fastdl

# Copy/UCC compress/both extensions
declare -A arr=(
  ['Maps']='umf:b'
  ['Music']='umx:b'
  ['Physics']='COL:c,hnd2:c'
  ['Sounds']='uax:b'
  ['System']='int:c,u:b'
  ['Textures']='utx:b'
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
      sum_file="${fastdl}$(echo $file | awk -F / '{print $NF}').sha512"
      sha512sum -c --status $sum_file 2> /dev/null

      # If the sum is not matching (or doesn't exist) compress the file and update the sha sum
      if [ $? -ne 0 ]; then
        if [[ "$action" == @(u|b) ]]; then
          echo "Compressing $file"
          wine UCC.exe compress $file
          #sleep 0.1

          touch -r $file "${file}.uz"
          mv "${file}.uz" $fastdl
        fi

        if [[ "$action" == @(c|b) ]]; then
          echo "Copying $file"
          cp -p $file $fastdl
        fi

        sha512sum $file > $sum_file
        touch -r $file $sum_file
      fi
    done
  done
done

# Copy "first" hashes then the rest
first=(
  'EffectsFix.u.sha512'
  'Rage.u.sha512'
  'Engine.u.sha512'
  'RageWeapons.u.sha512'
)

cd $fastdl; cat "${first[@]}" > sha512.txt
first=$(IFS='|'; echo "${first[*]}")
cat $(ls -t *.sha512 | grep -Ev $first) >> sha512.txt

if [ -d .git ]; then
  git add -A
  if ! git diff --cached --quiet; then
    git commit -m "deploy"
    git push origin files
  fi
fi
