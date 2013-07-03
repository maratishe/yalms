# you need to run all the below things in a script

# convert video frames in to pngs
ffmpeg -i test.ogg -r 10 -f image2 -vcodec png %04d.png
# split PDF into pdfs for slides
pdftk slides.pdf burst output pages.%04d.pdf
# convert pdf of each slide into PNG
convert -density 600x600 -quality 100 pages.0001.pdf pages.0001.png
# convert each PNG from slides into the same size as the video frame -- otherwise, composite will fail
convert slides_Page_01.png -resize 1920x1080 slide.png
