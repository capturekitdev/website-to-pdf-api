#!/usr/bin/env bash
# Website to PDF API – cURL example
# Usage: CAPTUREKIT_API_KEY=your-key bash pdf.sh
set -euo pipefail

curl -sS -G "https://api.capturekit.dev/v1/capture" \
  -H "x-api-key: ${CAPTUREKIT_API_KEY}" \
  --data-urlencode url=https://github.com/seaweedfs/seaweedfs \
  --data-urlencode format=pdf \
  -o page.pdf

echo "Saved page.pdf"
