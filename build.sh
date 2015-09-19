#!/bin/sh

find assets -name '.*' -type f -delete
find docs -name '.*' -type f -delete
find inc -name '.*' -type f -delete
find lang -name '.*' -type f -delete
find lib -name '.*' -type f -delete
find templates -name '.*' -type f -delete

grunt

ZIP="modern-law-firm-premium.zip"
echo "\n\n\nNuking existing ZIP"
rm ${ZIP}
DIRECTORY="modern-law-firm-premium"
echo "\n\n\nCreating build directory"
mkdir $DIRECTORY
echo "\n\n\nCopying files to build directory"
cp -r assets docs inc lang lib templates style.css README.md screenshot.png 404.php base-template-landing.php base.php functions.php index.php options.php page.php single-modern-law-attorney.php single-modern-law-practice.php single.php template-attorneys.php template-blog.php template-landing.php $DIRECTORY
echo "\n\n\nZipping build directory"
zip -r ${ZIP} ${DIRECTORY}
echo "\n\n\nNuking build directory"
rm -r ${DIRECTORY}