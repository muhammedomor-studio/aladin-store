# Aladin Custom E-commerce (Render)

Premium, responsive Bengali storefront using the Aladin API backend.

## Deploy
1. Upload these project files to your GitHub repository.
2. Create/Deploy a Render Web Service from the repository using Docker.
3. Set Render environment variables:
   - `API_BASE_URL=https://aladin-e-commerce-api.onrender.com`
   - `ADMIN_PASSWORD` (choose a strong password)
   - `SYNC_SECRET` (long random secret)
   - `SITE_URL=https://YOUR-SERVICE.onrender.com` (used for social previews)
4. In GitHub repository Settings → Secrets and variables → Actions, add:
   - `STORE_SYNC_URL` = `https://YOUR-SERVICE.onrender.com` (no trailing slash needed)
5. Ensure GitHub Actions is enabled. The workflow `.github/workflows/keep-render-awake.yml` runs on a schedule and can also be started manually from Actions.

## Render Free sleep note
Render Free web services generally spin down after about 15 minutes without inbound traffic. The GitHub Actions workflow pings BOTH the storefront (using `STORE_SYNC_URL`) and API backend (`https://aladin-e-commerce-api.onrender.com/`) every 9 minutes to reduce cold starts. GitHub scheduled workflows are best-effort and can be delayed; this is not a guaranteed 24/7 uptime solution. For guaranteed always-on service, use a paid always-on hosting plan.

## Admin
Open `/admin` and sign in with `ADMIN_PASSWORD`.

## Product synchronization
The product sync workflow is configured separately in `.github/workflows/sync.yml`. Review its secrets and schedule before enabling it. Do not expose API tokens in frontend files.
