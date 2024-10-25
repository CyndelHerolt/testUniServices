#!/bin/bash

# Function to start Symfony server in a given directory
start_symfony_server() {
  local dir=$1
  echo "Starting Symfony server in directory: $dir"
  cd $dir
  symfony server:start -d
  cd - > /dev/null
}

# Start servers in the specified order
start_symfony_server "orchestrator"
start_symfony_server "structure"
start_symfony_server "scolarite"

echo "All servers started."
