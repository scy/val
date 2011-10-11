#!/bin/sh

# Find repo root.
cdup="$(git rev-parse --show-cdup)"
# If repo root is in another cast^Wdirectory, go there.
[ -n "$cdup" ] && cd "$cdup"

# Show all TODOs and FIXMEs from our code plus the TODO.txt.
grep --color=auto -Rn -C1 'TODO\|FIXME' app/ www/ && echo --; cat TODO.txt 2>/dev/null

# If we went somewhere else, go back.
[ -n "$cdup" ] && cd - >/dev/null
