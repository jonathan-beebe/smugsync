#!/bin/bash

DIR="$( cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# find -L * -type d -exec "$DIR/.vim_dirtags.sh" {} \;

find -L * -type d \
-not -wholename '*.git*' \
-not -wholename '*assets*' \
-not -wholename '*gii*' \
-not -wholename '*framework/messages*' \
-not -wholename '*framework/i1cn*' \
-exec "$DIR/.vim_dirtags.sh" {} \;

ctags --file-scope=no -R

# ctags --file-scope=no -R -V -h ".php.inc" --languages=php --php-kinds=f --exclude=@.vim_tags_exclude --regex-PHP='/abstract class ([^ ]*)/\1/c/' --regex-PHP='/class ([^ ]*)/\1/c/' --regex-PHP='/interface ([^ ]*)/\1/c/' --regex-PHP='/(public |static |abstract |protected |private )+function ([^ (]*)/\2/f/'

