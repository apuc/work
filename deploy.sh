cd ../../
ls -la
git pull origin master
php yii migrate --interactive=0
cd frontend/web/vue
sh build.sh