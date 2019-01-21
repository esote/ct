#!/bin/bash

journalctl `which sshd` -a --no-pager | grep Failed | tail -n ${1:-2}
date
