convert -density 600x600 -quality 100 pages.0001.pdf pages.0001.png
pdftk slides.pdf burst output pages.%04d.pdf

composite slide.png 0047.png -compose difference diff.png
compare -verbose -metric PSNR slide.png 0047.png diff.png
convert slides_Page_01.png -resize 1920x1080 slide.png
ffmpeg -i test.ogg -r 10 -f image2 -vcodec png %04d.png


vlc screen:// :screen-fps=10 :screen-caching=10 --sout '#transcode{venc=theora,quality:10,scale=1.0,fps=10}:http{mux=ogg,dst=:8181/graph}'
ffmpeg -loglevel debug -i http://192.168.88.1:8181/graph -acodec copy -vcodec copy /marat/test.ogg
ffserver -f /marat/screen.streaming/stream.conf


ffmpeg -loglevel debug -i http://131.206.29.205:8181/graph -acodec copy -vcodec copy http://127.0.0.1:8090/feed1.ffm
vlc screen:// :screen-fps=30 :screen-caching=10 --sout '#transcode{vcodec=theora,quality:scale=1,width=800,height=600,acodec=none}:http{mux=ogg,dst=:8181/graph}'
vlc screen:// :screen-fps=30 :screen-caching=100 --sout '#transcode{vcodec=mp4v,vb=4096,acodec=mpga,ab=256,scale=1,width=1280,height=800}:udp{dst=131.206.29.204,port=1234,access=udp,mux=ts}'
vlc screen:// :screen-fps=30 :screen-caching=100 --sout '#transcode{venc=theora,quality:10,scale=0.75,fps=12}:udp{dst=131.206.29.204,port=1234,access=udp,mux=ogg}'


ffmpeg -i udp://127.0.0.1:1234 /web/stream.ffm

/usr/local/ffmpeg/bin/ffmpeg -i http://localhost:8080 -vcodec mpeg2video -b xxxk -acodec mp3 -ab 192k -f mpegts /web/stream.ts


/usr/local/ffmpeg/bin/ffmpeg -i rtp://127.0.0.1:5004 /web/stream.ffm
/usr/local/ffmpeg/bin/ffmpeg -i udp://133.9.67.162:1234 -acodec libmp3lame -ac 1 -vcodec libx264 -s 320x240 -level 30 /web/stream.mp4
/usr/local/ffmpeg/bin/ffserver -d -f /marat/stream.conf

ffmpeg -loglevel debug -i udp://127.0.0.1:1234


? :sout=#transcode{vcodec=h264,vb=800,scale=1,acodec=mpga,ab=128,channels=2,samplerate=44100}:std{access=udp{ttl=1},mux=ts,dst=133.9.67.162:1234} :sout-keep
? :sout=#transcode{vcodec=theo,vb=800,fps=30,scale=1,width=800,height=600,acodec=vorb,ab=128,channels=2,samplerate=44100}:std{access=udp{ttl=1},dst=133.9.67.162:1234} :sout-keep

:sout=#transcode{vcodec=h264,vb=800,fps=30,scale=1,width=1280,height=800,acodec=vorb,ab=128,channels=2,samplerate=44100}:std{access=udp{ttl=1},mux=ts,dst=133.9.67.162:1234} :sout-keep

vlc screen:// :screen-fps=30 :screen-caching=100 --sout '#transcode{vcodec=mp4v,vb=4096,acodec=mpga,ab=256,scale=1,width=1280,height=800}:rtp{dst=192.168.1.2,port=1234,access=udp,mux=ts}'

 vlc screen:// --screen-fps=12 --screen-mouse-image=e:/home/.icon/cursor.png \
  --no-sout-audio --sout \
  "#transcode{venc=x264,quality:100,scale=1,fps=12}:duplicate{dst=std{access=file,mux=mp4,dst=desktop.avi}}}"

$ vlc screen:// --screen-mouse-image cursor.png --screen-fps=12 \
  --screen-width=1680 --screen-height=1050 --no-sout-audio --sout \
  "#transcode{venc=theora,quality:10,scale=0.75,fps=12}:duplicate{dst=std{access=file,mux=ogg,dst=desktop.ogg}}}"



ffmpeg -ac 2 -i pulse -f x11grab -r 25 -s 1440x900 -i :0.0 -acodec libmp3lame -ar 44100 -b 128k -vcodec libx264 -vpre lossless_ultrafast -threads 0 -f flv - | vlc -I dummy - --sout '#transcode{vcodec=h264,vb=3500,acodec=mp3,ab=128,channels=2,samplerate=44100}:udp{dst=133.9.67.162,port=5000,access=udp,mux=ts}'

/usr/local/cpffmpeg/bin/ffmpeg -loglevel debug -i udp://@127.0.0.1:1234 -vcodec libtheora -acodec libvorbis http://127.0.0.1:8090/feed1.ffm
/usr/local/cpffmpeg/bin/ffmpeg -loglevel debug -i udp://@127.0.0.1:1234 -vcodec libtheora -acodec copy http://127.0.0.1:8090/feed1.ffm


