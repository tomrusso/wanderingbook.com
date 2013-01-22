#!/bin/bash
target_dir=~/www/test
src_dir=~/wb-src
bin_dir=~/bin

rm -rf $target_dir/*

cd $src_dir/php
for file in *.php
do
	cat top.html $file bottom.html | \
	python $bin_dir/replace.py %%%PRE%%% $file.pre | \
	python $bin_dir/replace.py %%%TITLE%%% $file.title | \
	python $bin_dir/replace.py %%%HEAD%%% $file.head | \
	python $bin_dir/replace.py %%%ONLOAD%%% $file.onload \
	> $target_dir/$file
done

cd $src_dir/css
cp *.css $target_dir

cd $src_dir/js
cp *.js $target_dir

cd $src_dir/php-final
cp *.php $target_dir

cd $src_dir
cp -r images $target_dir
