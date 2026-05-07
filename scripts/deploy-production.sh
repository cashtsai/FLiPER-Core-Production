#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"

require_command git
require_command ssh
require_command scp
require_command tar

require_clean_git

PRODUCTION_SSH="${FLIPER_PRODUCTION_SSH:-bitnami@ec2-18-183-67-197.ap-northeast-1.compute.amazonaws.com}"
PRODUCTION_KEY="${FLIPER_PRODUCTION_KEY:-/Users/shanzhang/Public/key/higher-tyo.pem}"
PRODUCTION_PHP="${FLIPER_PRODUCTION_PHP:-/opt/bitnami/php/bin/php}"
PRODUCTION_PLUGINS_PATH="${FLIPER_PRODUCTION_PLUGINS_PATH:-/bitnami/wordpress/wp-content/plugins}"
PRODUCTION_THEMES_PATH="${FLIPER_PRODUCTION_THEMES_PATH:-/bitnami/wordpress/wp-content/themes}"
PRODUCTION_SSH_CMD="ssh -i $PRODUCTION_KEY $PRODUCTION_SSH"
PRODUCTION_SCP_CMD="scp -i $PRODUCTION_KEY"
export FLIPER_REMOTE_DEPLOY_SUDO=1
export FLIPER_REMOTE_DEPLOY_OWNER="${FLIPER_PRODUCTION_OWNER:-bitnami:daemon}"

deploy_code_with_archive "$PRODUCTION_SSH_CMD" "$PRODUCTION_SCP_CMD" "$PRODUCTION_SSH" "$PRODUCTION_PHP" "$PRODUCTION_PLUGINS_PATH" "$PRODUCTION_THEMES_PATH" "production"

$PRODUCTION_SSH_CMD "/opt/bitnami/wp-cli/bin/wp cache flush --path=/opt/bitnami/wordpress >/dev/null 2>&1 || true"

if [[ "${FLIPER_RESTART_PHP_FPM:-0}" == "1" ]]; then
  $PRODUCTION_SSH_CMD "sudo /opt/bitnami/ctlscript.sh restart php-fpm"
fi
