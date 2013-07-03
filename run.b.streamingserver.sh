ffmpeg -loglevel debug -i http://192.168.88.1:8181/graph -acodec copy -vcodec copy /marat/test.ogg

# optionally, you can have ffmpeg pass the stream to ffserver which then streams it to everyone over the web
#ffserver -f /marat/screen.streaming/stream.conf
#ffmpeg -loglevel debug -i http://131.206.29.205:8181/graph -acodec copy -vcodec copy http://127.0.0.1:8090/feed1.ffm
