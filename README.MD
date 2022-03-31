php bin/console c:c
git push heroku main

symfony server:start -d

php bin/console doctrine:migrations:migrate
rm -rf var/cache/ && yarn install && yarn watch
php bin/console assets:install --symlink public
yarn i
yarn watch


heroku config:set APP_ENV=prod

git push heroku main
heroku run bash --app stan-control


heroku logs
heroku logs --source app
heroku logs --tail --source app




heroku config:set NPM_CONFIG_PRODUCTION=false
heroku config:set YARN_PRODUCTION=false
heroku config:set NODE_MODULES_CACHE=false
heroku buildpacks:add --index 1 heroku/nodejs