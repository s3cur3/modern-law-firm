#!/bin/sh


PAID="modern-law-firm-premium.zip"
FREE="modern-law-firm.zip"

scp -P 2222 $PAID tyler@conversioninsights.net:/downloads/themes/$PAID
scp -P 2222 $FREE tyler@conversioninsights.net:/downloads/themes/$FREE

PAID_METADATA="mlf_version_metadata.json"
FREE_METADATA="mlf-premium_version_metadata.json"

scp -P 2222 $PAID_METADATA tyler@conversioninsights.net:/downloads/themes/$PAID_METADATA
scp -P 2222 $FREE_METADATA tyler@conversioninsights.net:/downloads/themes/$FREE_METADATA
