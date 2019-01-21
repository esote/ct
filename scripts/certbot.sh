#!/bin/bash

certbot --dns-digitalocean -i apache -d "*.example.com" -d example.com --server https://acme-v02.api.letsencrypt.org/directory --dns-digitalocean-credentials ~/digitalocean_api.ini --expand --rsa-key-size 4096 --staple-ocsp --must-staple
