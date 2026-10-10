#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"

require_command git
require_command rsync
require_command ssh

require_clean_git

# Same stale defaults as deploy-production.sh had: another user's home
# directory and the retired public EC2 DNS name.
PRODUCTION_SSH="${FLIPER_PRODUCTION_SSH:-bitnami@100.87.74.24}"
PRODUCTION_KEY="${FLIPER_PRODUCTION_KEY:-$HOME/Public/key/higher-tyo.pem}"
PRODUCTION_PLUGINS_PATH="${FLIPER_PRODUCTION_PLUGINS_PATH:-/bitnami/wordpress/wp-content/plugins}"
PRODUCTION_THEMES_PATH="${FLIPER_PRODUCTION_THEMES_PATH:-/bitnami/wordpress/wp-content/themes}"
PRODUCTION_SSH_CMD="ssh -i $PRODUCTION_KEY $PRODUCTION_SSH"
PRODUCTION_RSYNC_RSH="ssh -i $PRODUCTION_KEY"

for plugin in "${PLUGIN_DIRS[@]}"; do
  rsync -az --delete -e "$PRODUCTION_RSYNC_RSH" --exclude='.git' --exclude='.DS_Store' "$PRODUCTION_SSH:$PRODUCTION_PLUGINS_PATH/$plugin/" "$ROOT_DIR/$plugin/"
done
for theme in "${THEME_DIRS[@]}"; do
  rsync -az --delete -e "$PRODUCTION_RSYNC_RSH" --exclude='.git' --exclude='.DS_Store' "$PRODUCTION_SSH:$PRODUCTION_THEMES_PATH/$theme/" "$ROOT_DIR/$theme/"
done

echo "Pulled plugins: ${PLUGIN_DIRS[*]} and themes: ${THEME_DIRS[*]} from production."
git -C "$ROOT_DIR" status --short
