#!/bin/bash

# Function to start Symfony server in a given directory
stop_symfony_server() {
  local dir=$1
  echo "Stopping Symfony server in directory: $dir"
  cd $dir
  symfony server:stop
  cd - > /dev/null
}

# Start servers in the specified order
stop_symfony_server "orchestrator"
stop_symfony_server "structure"
stop_symfony_server "scolarite"

echo "All servers stopped."
