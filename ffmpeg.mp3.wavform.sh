#!/bin/bash
echo "*******************************"
echo "Begin render wavform";
echo "*******************************"

cd /home/user/path/to/mp3/

for i in *.mp3; do
	ffmpeg -y -i "$i" -filter_complex "compand,showwavespic=s=1200x120:colors=b2b2b2ff:" -frames:v 1  "${i%.mp3}.wavform.png";
	sleep 1;
done


echo "end"

exit
