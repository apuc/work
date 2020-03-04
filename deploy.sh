cd ../../
#ls -la
git status
git pull origin master
php yii migrate --interactive=0
cd frontend/web/vue
sh build.sh