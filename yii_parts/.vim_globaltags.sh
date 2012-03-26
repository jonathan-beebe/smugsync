#!/bin/bash

DIR="$( cd -P "$( dirname "${BASH_SOURCE[0]}"  )" && pwd  )"

# find -L * -type d -exec "$DIR/.vim_dirtags.sh" {} \;

find -L * -type d \
-not -wholename '*.git*' \
-not -wholename '*assets*' \
-not -wholename '*gii*' \
-not -name 'logs' \
-not -wholename 'yii-*' \
-not -wholename '*framework/messages*' \
-not -wholename '*framework/i18n*' \
-exec "$DIR/.vim_dirtags.sh" {} \;

ctags --file-scope=no -R \
--exclude=.git \
--exclude=*.min* \
--exclude=*yii-* \
--exclude=*gii* \
--exclude=*assets* \
--exclude=*framework/messages* \
--exclude=*framework/yiilite.php \
--exclude=*framework/vendors* \
--exclude=*framework/i18n* \
--langdef=js \
--langmap=js:.js \
--regex-js='/([A-Za-z0-9._$]+)[ \t ]*[:=][ \t ]*\{/\1/,object/' \
--regex-js='/([A-Za-z0-9._$()]+)[ \t ]*[:=][ \t ]*function[ \t ]*\(/\1/,function/' \
--regex-js='/function[ \t ]+([A-Za-z0-9._$]+)[ \t ]*([^)])/\1/,function/' \
--regex-js='/([A-Za-z0-9._$]+)[ \t ]*[:=][ \t ]*\[/\1/,array/' \
--regex-js='/([A-Za-z0-9._$]+).prototype.([A-Za-z0-9._$]+) =/\2/,function/' \
--regex-js='/([A-Za-z0-9_$]+) = new Class/\1/,function/'

