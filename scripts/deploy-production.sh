#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/lib.sh"

require_command git
require_command ssh
require_command scp
require_command tar

require_clean_git
require_pushed

# These defaults were stale in two ways that made the script a misleading
# record of how deploys actually happen: the key path pointed into another
# user's home (/Users/shanzhang) and the host was the retired public EC2 DNS
# name. Every real deploy must therefore have relied on env overrides.
PRODUCTION_SSH="${FLIPER_PRODUCTION_SSH:-bitnami@100.87.74.24}"
PRODUCTION_KEY="${FLIPER_PRODUCTION_KEY:-$HOME/Public/key/higher-tyo.pem}"
PRODUCTION_PHP="${FLIPER_PRODUCTION_PHP:-/opt/bitnami/php/bin/php}"
PRODUCTION_PLUGINS_PATH="${FLIPER_PRODUCTION_PLUGINS_PATH:-/bitnami/wordpress/wp-content/plugins}"
PRODUCTION_THEMES_PATH="${FLIPER_PRODUCTION_THEMES_PATH:-/bitnami/wordpress/wp-content/themes}"
if [[ "$PRODUCTION_SSH" == *"13.112.197.66"* || "$PRODUCTION_SSH" == *"ec2-18-183-67-197"* ]]; then
  echo "Refusing production deployment over a retired public SSH address: $PRODUCTION_SSH" >&2
  echo "Use the Tailscale address 100.87.74.24 or the fliper-aws SSH alias." >&2
  exit 1
fi

if [[ ! -f "$PRODUCTION_KEY" ]]; then
  echo "SSH key not found: $PRODUCTION_KEY" >&2
  echo "Set FLIPER_PRODUCTION_KEY to the correct path." >&2
  exit 1
fi

PRODUCTION_SSH_CMD="ssh -i $PRODUCTION_KEY $PRODUCTION_SSH"
PRODUCTION_SCP_CMD="scp -i $PRODUCTION_KEY"
export FLIPER_REMOTE_DEPLOY_SUDO=1
export FLIPER_REMOTE_DEPLOY_OWNER="${FLIPER_PRODUCTION_OWNER:-bitnami:daemon}"

deploy_code_with_archive "$PRODUCTION_SSH_CMD" "$PRODUCTION_SCP_CMD" "$PRODUCTION_SSH" "$PRODUCTION_PHP" "$PRODUCTION_PLUGINS_PATH" "$PRODUCTION_THEMES_PATH" "production"

$PRODUCTION_SSH_CMD "/opt/bitnami/wp-cli/bin/wp cache flush --path=/opt/bitnami/wordpress >/dev/null 2>&1 || true"

# Restart php-fpm unconditionally. This used to be opt-in, which is why
# deployed-but-not-live theme changes are indistinguishable from never-deployed
# ones: opcache keeps serving the previous PHP until the pool restarts, so a
# deploy without the restart silently has no effect. Opt out only when you know
# the payload contains no PHP.
if [[ "${FLIPER_RESTART_PHP_FPM:-1}" == "1" ]]; then
  $PRODUCTION_SSH_CMD "sudo /opt/bitnami/ctlscript.sh restart php-fpm"
else
  echo "WARNING: skipped php-fpm restart; opcache may keep serving the previous PHP." >&2
fi
