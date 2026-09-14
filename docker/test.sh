#!/bin/bash

set -e

test_dir="$(mktemp -d)"
trap 'find "$test_dir" -depth -delete' EXIT

export DOCKER_TEST_LOG="$test_dir/commands.log"

cat > "$test_dir/sudo" <<'EOF'
#!/bin/bash
printf '%s\n' "$*" >> "$DOCKER_TEST_LOG"
EOF
chmod +x "$test_dir/sudo"

PATH="$test_dir:$PATH" bash docker/build.sh
PATH="$test_dir:$PATH" bash docker/pull.sh
PATH="$test_dir:$PATH" bash docker/run.sh

grep '^docker compose ' "$DOCKER_TEST_LOG" > "$test_dir/compose.log"

cat > "$test_dir/expected.log" <<'EOF'
docker compose -f docker/docker-compose.yml -f docker/docker-compose.compatibility.yml pull gpstracker-mysql gpstracker-redis
docker compose -f docker/docker-compose.yml -f docker/docker-compose.compatibility.yml build gpstracker-app
docker compose -f docker/docker-compose.yml -f docker/docker-compose.compatibility.yml pull
docker compose -f docker/docker-compose.yml -f docker/docker-compose.compatibility.yml stop
docker compose -f docker/docker-compose.yml -f docker/docker-compose.compatibility.yml up -d --no-build --pull never
EOF

diff -u "$test_dir/expected.log" "$test_dir/compose.log"

if [ "$(grep -c '^rm -rf bootstrap/cache/' "$DOCKER_TEST_LOG")" -ne 1 ]; then
    echo "Expected bootstrap cache cleanup only in local build mode" >&2
    exit 1
fi
