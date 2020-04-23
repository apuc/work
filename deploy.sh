cd /var/www/work.art-craft.xyz/
#ls -la
echo $USER
echo "----git status----\n"
git status


echo "-----git pull-----\n"
#git add .
#git commit -m "merge"
git pull

echo "-----migrate-----\n"
php yii migrate --interactive=0

echo "-----minify-----\n"
php yii minify

cd /var/www/work.art-craft.xyz/frontend/web/vue
sh build.sh
