#!/bin/bash

# execute with . ~/scripts/clear_hist.sh

cat /dev/null > /root/.bash_history && history -c && logout
