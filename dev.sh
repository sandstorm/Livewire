#!/bin/bash
############################## DEV_SCRIPT_MARKER ##############################
# This script is used to document and run recurring tasks in development.     #
#                                                                             #
# You can run your tasks using the script `./dev some-task`.                  #
# You can install the Sandstorm Dev Script Runner and run your tasks from any #
# nested folder using `dev some-task`.                                        #
# https://github.com/sandstorm/Sandstorm.DevScriptRunner                      #
###############################################################################

source ./dev_utilities.sh

set -e

pwd=$(pwd)

######### TASKS #########

# install the laravel dependencies and the stuff needed for e2e tests
function install() {
  pushd Tests/Laravel
  composer install
  popd

  pushd Tests
  npm install
  popd
}

# start the Flow development server, and the Laravel application
function start() {
  trap terminate SIGINT
  terminate(){
    _log_green "Exiting all servers"
    pkill -SIGINT -P $$
    exit
  }

  start-flow &
  start-laravel &
  wait
}

function start-flow {
  $pwd/../../flow server:run
}

function start-laravel {
  $pwd/Tests/Laravel/artisan serve
}

# Update Livewire
function update_livewire_script() {
  mkdir -p Resources/Public/vendor
  curl -o Resources/Public/vendor/livewire.js https://raw.githubusercontent.com/livewire/livewire/v3.0.10/dist/livewire.js

  _log_green "Livewire downloaded"
}

_log_green "---------------------------- RUNNING TASK: $1 ----------------------------"

# THIS NEEDS TO BE LAST!!!
# this will run your tasks
"$@"
