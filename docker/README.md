# Docker image modes

The same Compose configuration supports a local source build and the published
`eusonlito/gps-tracker` image. Both modes use the same containers, `.env` file,
and persistent volumes.

## Build locally

```bash
./docker/build.sh
./docker/run.sh
```

This pulls only the MySQL and Redis images, then builds `gpstracker-app` from
the current checkout.

## Use the published image

```bash
./docker/pull.sh
./docker/run.sh
```

This pulls `eusonlito/gps-tracker` and the service images without rebuilding
the application. Public images do not require a local Docker Hub login.

Existing installations keep their generated `docker/docker-compose.yml` and
local customizations. The versioned compatibility file supplies the application
image and build context automatically, including for older image-only or
build-only configurations.

## Publish to Docker Hub

1. Create the public Docker Hub repository `eusonlito/gps-tracker`.
2. Create a Docker Hub access token with read and write permissions.
3. Add `DOCKERHUB_USERNAME` and `DOCKERHUB_TOKEN` as GitHub Actions repository
   secrets.
4. Publish a GitHub Release with a Docker-compatible tag such as `v1.0.0`.

The `Docker Build and Publish` workflow publishes the release tag for AMD64
and ARM64. A non-prerelease release also updates `latest`.
