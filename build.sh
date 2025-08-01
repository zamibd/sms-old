#!/bin/bash

# Directory to watch for changes (Dockerfile, docker-compose.yml, code files, etc.)
WATCH_DIR="./"

# File to store the previous build hash
HASH_FILE=".last_build_hash"

# Generate current hash from relevant files
CURRENT_HASH=$(find $WATCH_DIR -type f \( -name 'Dockerfile' -o -name 'docker-compose.yml' -o -name '*.php' -o -name '*.env' -o -name '*.js' -o -name '*.ts' \) -exec md5sum {} \; | sort | md5sum | awk '{ print $1 }')

# Load previous hash if it exists
if [ -f "$HASH_FILE" ]; then
    LAST_HASH=$(cat "$HASH_FILE")
else
    LAST_HASH=""
fi

# Compare current and previous hashes
if [ "$CURRENT_HASH" != "$LAST_HASH" ]; then
    echo "🔍 Changes detected. Rebuilding Docker images..."
    docker compose down
    docker compose up -d --build
    echo "$CURRENT_HASH" > "$HASH_FILE"
    echo "✅ Docker rebuilt and restarted successfully!"
else
    echo "ℹ️ No changes detected. Restarting without rebuild..."
    docker compose down
    docker compose up -d
    echo "✅ Docker restarted without rebuild!"
fi