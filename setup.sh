#!/bin/bash
wp-env run cli wp theme delete twentyten twentyeleven twentytwelve twentythirteen twentyfourteen twentyfifteen twentysixteen twentyseventeen twentynineteen twentytwenty twentytwentyone twentytwentytwo twentytwentythree twentytwentyfour; \
  wp-env run cli wp plugin deactivate --all --exclude=am-lottieplayer