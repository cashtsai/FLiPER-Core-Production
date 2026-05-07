# FLiPER Production

Public source repository for FLiPER's production WordPress theme and core runtime plugin.

## Included

- `fliper-core/`: FLiPER core runtime features, including legacy APIs, favorites, notifications, login helpers, and shared site behavior.
- `flipermag/`: FLiPER front-end theme.

## Not Included

Internal editorial automation, AI-assisted publishing tools, service credentials, and private workflow integrations are kept in a separate private repository.

## Secrets

Do not commit production secrets, access tokens, app secrets, `.env` files, or local backup files.

`fliper-core` reads sensitive values from WordPress constants:

```php
define( 'FLIPER_LEGACY_API_TOKEN', '...' );
define( 'FLIPER_FB_APP_ID', '...' );
define( 'FLIPER_FB_APP_SECRET', '...' );
// Optional direct override:
define( 'FLIPER_FB_APP_TOKEN', 'app_id|app_secret' );
```

See [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) for deployment notes.
