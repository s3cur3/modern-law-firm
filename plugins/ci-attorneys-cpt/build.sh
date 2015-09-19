#!/bin/sh

find plugin-updates -name '.*' -type f -delete
find lib -name '.*' -type f -delete


ZIP="ci-attorneys-cpt.zip"
PHP_FILE="ci-attorneys-cpt.php"
DIRECTORY="ci-attorneys-cpt"


echo "\n\n\nNuking existing ZIP"
rm ${ZIP}
echo "\n\n\nCreating build directory"
mkdir ${DIRECTORY}
echo "\n\n\nCopying files to build directory"
cp -r lib plugin-updates ${PHP_FILE} ${DIRECTORY}
echo "\n\n\nZipping build directory"
zip -r ${ZIP} ${DIRECTORY}
echo "\n\n\nNuking build directory"
rm -r ${DIRECTORY}