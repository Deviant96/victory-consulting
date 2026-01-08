#!/bin/bash
# View Laravel logs

LOG_FILE="storage/logs/laravel.log"

if [ -f "$LOG_FILE" ]; then
    echo "📋 Displaying latest Laravel logs (last 50 lines)..."
    echo "================================================"
    tail -n 50 "$LOG_FILE"
else
    echo "⚠️  No log file found at $LOG_FILE"
fi
