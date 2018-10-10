# Micropub Client

Still searching for a better name, currently at [`https://microclient.jonnybarnes.uk`](https://microclient.jonnybarnes.uk).

Sign up with your domain and start posting away. One caveat, for media uploads, the webapp POSTs
directly to you media-endpoint, so beware of CORS restrictions.

## Changelog

### develop
  - Upgrade the underlying Laravel framework to v5.7
  - Add Nuno Maduro’s Collision package

### v0.1.3
  - Improve flex based layout
    - Header now uses `flex-direction` and `flex-wrap`
    - Flex is used to achieve a “sticky” footer
  - Improve uploading of pictures, in particular the file picker on the new ote form

### v0.1.2
  - Fix sending location data with micropub request (issue#1)

### v0.1.1
  - Slightly improve flex layout
  - Add basic footer

### v0.1
  - Initial relase
