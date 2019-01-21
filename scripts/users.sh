#!/bin/bash

netstat -plan | grep :443 | wc -l
