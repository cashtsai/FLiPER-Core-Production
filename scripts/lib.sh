#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

PLUGIN_DIRS=(
  "fliper-core"
)

THEME_DIRS=(
  "flipermag"
)

require_clean_git() {
  if [[ "${FLIPER_ALLOW_DIRTY:-0}" == "1" ]]; then
    return
  fi

  if [[ -n "$(git -C "$ROOT_DIR" status --porcelain)" ]]; then
    echo "Working tree is dirty. Commit changes first, or set FLIPER_ALLOW_DIRTY=1." >&2
    git -C "$ROOT_DIR" status --short >&2
    exit 1
  fi
}

require_command() {
  if ! command -v "$1" >/dev/null 2>&1; then
    echo "Missing required command: $1" >&2
    exit 1
  fi
}

remote_lint_plugins() {
  local ssh_cmd="$1"
  local rsync_rsh="$2"
  local remote_host="$3"
  local remote_php="$4"
  local env_name="$5"
  local remote_tmp="/tmp/fliper-plugin-lint-${env_name}-$(date +%Y%m%d%H%M%S)"

  $ssh_cmd "rm -rf '$remote_tmp' && mkdir -p '$remote_tmp'"
  for plugin in "${PLUGIN_DIRS[@]}"; do
    rsync -az --delete -e "$rsync_rsh" --exclude='.git' --exclude='.DS_Store' "$ROOT_DIR/$plugin/" "$remote_host:$remote_tmp/$plugin/"
  done

  if [[ -n "${FLIPER_REMOTE_LINT_COMMAND:-}" ]]; then
    local lint_command="${FLIPER_REMOTE_LINT_COMMAND//__PATH__/$remote_tmp}"
    lint_command="${lint_command//__ENV__/$env_name}"
    $ssh_cmd "$lint_command && rm -rf '$remote_tmp'"
  else
    $ssh_cmd "find '$remote_tmp' -name '*.php' -print0 | xargs -0 -n1 '$remote_php' -l >/tmp/fliper-plugin-lint-${env_name}.log && rm -rf '$remote_tmp'"
  fi
}

remote_lint_all() {
  local ssh_cmd="$1"
  local rsync_rsh="$2"
  local remote_host="$3"
  local remote_php="$4"
  local env_name="$5"
  local remote_tmp="/tmp/fliper-code-lint-${env_name}-$(date +%Y%m%d%H%M%S)"

  $ssh_cmd "rm -rf '$remote_tmp' && mkdir -p '$remote_tmp/plugins' '$remote_tmp/themes'"
  for plugin in "${PLUGIN_DIRS[@]}"; do
    rsync -az --delete -e "$rsync_rsh" --exclude='.git' --exclude='.DS_Store' "$ROOT_DIR/$plugin/" "$remote_host:$remote_tmp/plugins/$plugin/"
  done
  for theme in "${THEME_DIRS[@]}"; do
    rsync -az --delete -e "$rsync_rsh" --exclude='.git' --exclude='.DS_Store' "$ROOT_DIR/$theme/" "$remote_host:$remote_tmp/themes/$theme/"
  done

  if [[ -n "${FLIPER_REMOTE_LINT_COMMAND:-}" ]]; then
    local lint_command="${FLIPER_REMOTE_LINT_COMMAND//__PATH__/$remote_tmp}"
    lint_command="${lint_command//__ENV__/$env_name}"
    $ssh_cmd "$lint_command && rm -rf '$remote_tmp'"
  else
    $ssh_cmd "find '$remote_tmp' -name '*.php' -print0 | xargs -0 -n1 '$remote_php' -l >/tmp/fliper-code-lint-${env_name}.log && rm -rf '$remote_tmp'"
  fi
}

deploy_plugins() {
  local ssh_cmd="$1"
  local rsync_rsh="$2"
  local remote_host="$3"
  local remote_php="$4"
  local remote_plugins_path="$5"
  local env_name="$6"
  local backup_path="/tmp/fliper-plugin-backup-${env_name}-$(date +%Y%m%d%H%M%S).tgz"

  remote_lint_plugins "$ssh_cmd" "$rsync_rsh" "$remote_host" "$remote_php" "$env_name"

  $ssh_cmd "tar -czf '$backup_path' -C '$remote_plugins_path' ${PLUGIN_DIRS[*]} 2>/dev/null || true"

  for plugin in "${PLUGIN_DIRS[@]}"; do
    rsync -az --delete -e "$rsync_rsh" --exclude='.git' --exclude='.DS_Store' "$ROOT_DIR/$plugin/" "$remote_host:$remote_plugins_path/$plugin/"
  done

  echo "Deployed ${PLUGIN_DIRS[*]} to $env_name."
  echo "Remote backup, if source folders existed: $backup_path"
}

deploy_code() {
  local ssh_cmd="$1"
  local rsync_rsh="$2"
  local remote_host="$3"
  local remote_php="$4"
  local remote_plugins_path="$5"
  local remote_themes_path="$6"
  local env_name="$7"
  local backup_path="/tmp/fliper-code-backup-${env_name}-$(date +%Y%m%d%H%M%S).tgz"

  remote_lint_all "$ssh_cmd" "$rsync_rsh" "$remote_host" "$remote_php" "$env_name"

  $ssh_cmd "tar -czf '$backup_path' -C '$remote_plugins_path' ${PLUGIN_DIRS[*]} -C '$remote_themes_path' ${THEME_DIRS[*]} 2>/dev/null || true"

  for plugin in "${PLUGIN_DIRS[@]}"; do
    rsync -az --delete -e "$rsync_rsh" --exclude='.git' --exclude='.DS_Store' "$ROOT_DIR/$plugin/" "$remote_host:$remote_plugins_path/$plugin/"
  done
  for theme in "${THEME_DIRS[@]}"; do
    rsync -az --delete -e "$rsync_rsh" --exclude='.git' --exclude='.DS_Store' "$ROOT_DIR/$theme/" "$remote_host:$remote_themes_path/$theme/"
  done

  echo "Deployed plugins: ${PLUGIN_DIRS[*]} and themes: ${THEME_DIRS[*]} to $env_name."
  echo "Remote backup, if source folders existed: $backup_path"
}

deploy_code_with_archive() {
  local ssh_cmd="$1"
  local scp_cmd="$2"
  local remote_host="$3"
  local remote_php="$4"
  local remote_plugins_path="$5"
  local remote_themes_path="$6"
  local env_name="$7"
  local timestamp
  local archive
  local remote_archive
  local remote_tmp
  local backup_path
  local remote_sudo=""
  local remote_owner="${FLIPER_REMOTE_DEPLOY_OWNER:-}"

  if [[ "${FLIPER_REMOTE_DEPLOY_SUDO:-0}" == "1" ]]; then
    remote_sudo="sudo "
  fi

  timestamp="$(date +%Y%m%d%H%M%S)"
  archive="/tmp/fliper-code-deploy-${env_name}-${timestamp}.tgz"
  remote_archive="/tmp/fliper-code-deploy-${env_name}-${timestamp}.tgz"
  remote_tmp="/tmp/fliper-code-lint-${env_name}-${timestamp}"
  backup_path="/tmp/fliper-code-backup-${env_name}-${timestamp}.tgz"

  (
    cd "$ROOT_DIR"
    COPYFILE_DISABLE=1 tar --no-xattrs -czf "$archive" --exclude='.git' --exclude='.DS_Store' \
      "${PLUGIN_DIRS[@]}" "${THEME_DIRS[@]}"
  )

  $scp_cmd "$archive" "$remote_host:$remote_archive"
  $ssh_cmd "rm -rf '$remote_tmp' && mkdir -p '$remote_tmp' && tar -xzf '$remote_archive' -C '$remote_tmp' && find '$remote_tmp' -name '*.php' -print0 | xargs -0 -n1 '$remote_php' -l >/tmp/fliper-code-lint-${env_name}.log"
  $ssh_cmd "${remote_sudo}tar -czf '$backup_path' -C '$remote_plugins_path' ${PLUGIN_DIRS[*]} -C '$remote_themes_path' ${THEME_DIRS[*]} 2>/dev/null || true"

  for plugin in "${PLUGIN_DIRS[@]}"; do
    $ssh_cmd "${remote_sudo}rm -rf '$remote_plugins_path/$plugin' && ${remote_sudo}tar -xzf '$remote_archive' -C '$remote_plugins_path' '$plugin'"
  done
  for theme in "${THEME_DIRS[@]}"; do
    $ssh_cmd "${remote_sudo}rm -rf '$remote_themes_path/$theme' && ${remote_sudo}tar -xzf '$remote_archive' -C '$remote_themes_path' '$theme'"
  done

  if [[ -n "$remote_owner" ]]; then
    for plugin in "${PLUGIN_DIRS[@]}"; do
      $ssh_cmd "${remote_sudo}chown -R '$remote_owner' '$remote_plugins_path/$plugin'"
    done
    for theme in "${THEME_DIRS[@]}"; do
      $ssh_cmd "${remote_sudo}chown -R '$remote_owner' '$remote_themes_path/$theme'"
    done
  fi

  $ssh_cmd "rm -rf '$remote_tmp' '$remote_archive'"
  rm -f "$archive"

  echo "Deployed plugins: ${PLUGIN_DIRS[*]} and themes: ${THEME_DIRS[*]} to $env_name."
  echo "Remote backup, if source folders existed: $backup_path"
}
