#!/usr/bin/env bash

sed -i "s%href=/%href=/vue/dist/%g" "dist/index.html"
sed -i "s%src=/%src=/vue/dist/%g" "dist/index.html"
sed -i "s%content=/%content=/vue/dist/%g" "dist/index.html"
sed -i "s%href=\"/%href=\"/vue/dist/%g" "dist/index.html"

echo "\nDone\n"