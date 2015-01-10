#!/bin/bash

if [ ! -d ZendSkeletonApplication ]
then
    git clone https://github.com/zendframework/ZendSkeletonApplication.git;
    cd ZendSkeletonApplication;
else
    cd ZendSkeletonApplication;
    git reset --hard origin/master;
fi;

composer install --no-dev;

cp ../files/application.config.php.dist config/application.config.php;
cp ../files/*.local.php ../files/*.global.php config/autoload 2>/dev/null;

cd module;
rm LdcEventListenerConfig 2>/dev/null;
ln -s ../../../ LdcEventListenerConfig 2>/dev/null;
rm ExampleModule 2>/dev/null;
ln -s ../../ExampleModule;
cd - >/dev/null;

php -S 0.0.0.0:8080 -t public

