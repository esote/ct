#!/bin/bash

for i in $(find /var/www/ -name '*.php');do php -l $i;done
