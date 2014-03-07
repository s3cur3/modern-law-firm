#!/bin/sh

find assets -name '.*' -type f -delete
find docs -name '.*' -type f -delete
find inc -name '.*' -type f -delete
find lang -name '.*' -type f -delete
find lib -name '.*' -type f -delete
find templates -name '.*' -type f -delete

echo "\n\n\nCreating build directory"
mkdir modern-law-firm
echo "\n\n\nCopying files to build directory"
cp -r assets docs inc lang lib templates style.css README.md screenshot.png 404.php base-template-landing.php base.php functions.php index.php options.php page.php single-modern-law-attorney.php single.php template-attorneys.php template-blog.php template-landing.php modern-law-firm
echo "\n\n\nZipping build directory"
zip -r modern-law-firm.zip modern-law-firm
echo "\n\n\nNuking build directory"
rm -r modern-law-firm