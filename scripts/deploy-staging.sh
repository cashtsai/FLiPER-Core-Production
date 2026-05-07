#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"

require_command git
require_command rsync
require_command ssh

require_clean_git

STAGING_SSH="${FLIPER_STAGING_SSH:-cashtsai@100.90.163.86}"
STAGING_PHP="${FLIPER_STAGING_PHP:-php}"
STAGING_PLUGINS_PATH="${FLIPER_STAGING_PLUGINS_PATH:-/home/cashtsai/apps/shared/fliper/wordpress/wp-content/plugins}"
STAGING_THEMES_PATH="${FLIPER_STAGING_THEMES_PATH:-/home/cashtsai/apps/shared/fliper/wordpress/wp-content/themes}"
export FLIPER_REMOTE_LINT_COMMAND="${FLIPER_STAGING_REMOTE_LINT_COMMAND:-docker run --rm -v __PATH__:/lint:ro wordpress:php8.4-apache sh -c 'find /lint -name \"*.php\" -print0 | xargs -0 -n1 php -l >/tmp/fliper-plugin-lint-__ENV__.log'}"

deploy_code "ssh $STAGING_SSH" "ssh" "$STAGING_SSH" "$STAGING_PHP" "$STAGING_PLUGINS_PATH" "$STAGING_THEMES_PATH" "staging"
