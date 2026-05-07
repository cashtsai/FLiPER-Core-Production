# Deployment

GitHub is the source of truth for `fliper-core` and the `flipermag` theme.

## Normal Flow

1. Edit code in this repository.
2. Commit and push to GitHub.
3. Deploy to staging:

   ```bash
   scripts/deploy-staging.sh
   ```

4. Verify staging.
5. Deploy the same commit to production:

   ```bash
   scripts/deploy-production.sh
   ```

Staging uses `rsync`. Production uses a tarball upload because the Bitnami EC2 host does not currently provide remote `rsync`. Production also uses `sudo` during extraction because some historical plugin/theme files are owned by `root`.

## Emergency Production Hotfix

Avoid direct production edits when possible. If production must be patched directly, pull the live plugin code back immediately:

```bash
scripts/pull-from-production.sh
git diff
git add fliper-core flipermag
git commit -m "Sync production hotfix"
git push
```

## Site Secrets

Secrets must live in site configuration, not Git.

`fliper-core` expects these constants in `wp-config.php` or another non-committed config file:

```php
define( 'FLIPER_LEGACY_API_TOKEN', '...' );
define( 'FLIPER_FB_APP_ID', '...' );
define( 'FLIPER_FB_APP_SECRET', '...' );
```

`FLIPER_FB_APP_TOKEN` may be used instead of `FLIPER_FB_APP_ID` and `FLIPER_FB_APP_SECRET` if the direct `app_id|app_secret` value is preferred.

## Useful Overrides

```bash
FLIPER_ALLOW_DIRTY=1 scripts/deploy-staging.sh
FLIPER_RESTART_PHP_FPM=1 scripts/deploy-production.sh
```

Environment-specific host/path overrides are available:

```bash
FLIPER_STAGING_SSH=...
FLIPER_STAGING_PLUGINS_PATH=...
FLIPER_STAGING_THEMES_PATH=...
FLIPER_STAGING_REMOTE_LINT_COMMAND=...
FLIPER_PRODUCTION_SSH=...
FLIPER_PRODUCTION_KEY=...
FLIPER_PRODUCTION_PLUGINS_PATH=...
FLIPER_PRODUCTION_THEMES_PATH=...
FLIPER_PRODUCTION_OWNER=...
```

Custom lint commands can use `__PATH__` for the uploaded temporary plugin path and `__ENV__` for the environment name.
