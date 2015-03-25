#!/bin/bash


startDay=$(echo "$(date +%s) + 10*24*60*60" | bc)
endDay=$(echo "$(date +%s) + 14*24*60*60" | bc)

curl -X POST -d "eventName=CURL Event" -d "start=$startDay" -d "end=$endDay" -d "destination=8" -d "kitID=3" -d "userID=2" -d "shipping=0" -d "shipped=0" -d "received=0"  "192.168.56.101:8000/bookings"
