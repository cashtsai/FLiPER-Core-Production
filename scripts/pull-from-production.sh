#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"

require_command git
require_command rsync
require_command ssh

require_clean_git

PRODUCTION_SSH="${FLIPER_PRODUCTION_SSH:-bitnami@ec2-18-183-67-197.ap-northeast-1.compute.amazonaws.com}"
PRODUCTION_KEY="${FLIPER_PRODUCTION_KEY:-/Users/shanzhang/Public/key/higher-tyo.pem}"
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
