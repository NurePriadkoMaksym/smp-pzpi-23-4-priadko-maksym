#!/bin/bash

HEIGHT=$1
SNOW=$2

if [[ $# -ne 2 ]]; then
    echo "Для створення ялинки треба одночасно як висота дерева, так і шар снігу на ньому!" >&2
    exit 1
fi

if ! [[ "$HEIGHT" =~ ^[0-9]+$ && "$SNOW" =~ ^[0-9]+$ ]] || ((HEIGHT <= 0 || SNOW <= 0)); then
    echo "Висота дерева та шар снігу повинні бути більші за 0!" >&2
    exit 2
fi

if ((HEIGHT < 8 || SNOW < 7)); then
    echo "ПОМИЛКА! Неможливо побудувати ялинку!" >&2
    exit 3
fi

DIFF=$((HEIGHT - SNOW))
if ((DIFF != 0 && DIFF != 1 && DIFF != 2)); then
    echo "ПОМИЛКА! Неможливо побудувати ялинку!" >&2
    exit 4
fi

if ((HEIGHT % 2 == 1 && SNOW % 2 == 1 && DIFF == 0)); then
    echo "ПОМИЛКА! Неможливо побудувати ялинку!" >&2
    exit 5
fi

if ((HEIGHT % 2 == 0 && SNOW % 2 == 0 && DIFF == 2)); then
    echo "ПОМИЛКА! Неможливо побудувати ялинку!" >&2
    exit 6
fi

if ((HEIGHT % 2 == 0 && SNOW % 2 == 0 && DIFF == 2)); then
    CHECK_HEIGHT=$((HEIGHT - 1))
    if ((CHECK_HEIGHT < SNOW)); then
        echo "ПОМИЛКА! Неможливо побудувати ялинку!" >&2
        exit 7
    fi
fi

function draw_line() {
    local spaces=$1
    local chars=$2
    local symbol=$3

    count=0
    while [ $count -lt "$spaces" ]; do
        echo -n " "
        ((count++))
    done

    for ((i = 0; i < chars; i++)); do
        echo -n "$symbol"
    done
    echo
}

TIER_HEIGHT=$(((HEIGHT - 2) / 2))
MAX_WIDTH=$((SNOW - 2))
CURRENT_SYMBOL="*"

chars=1
while [ $chars -le $MAX_WIDTH ]; do
    spaces=$(( (SNOW - chars) / 2 ))
    draw_line "$spaces" "$chars" "$CURRENT_SYMBOL"

    if [ "$CURRENT_SYMBOL" == "*" ]; then
        CURRENT_SYMBOL="#"
    else
        CURRENT_SYMBOL="*"
    fi

    ((chars += 2))
done

if [ "$CURRENT_SYMBOL" == "*" ]; then
    CURRENT_SYMBOL="#"
else
    CURRENT_SYMBOL="*"
fi

for ((chars = 3; chars <= MAX_WIDTH; chars += 2)); do
    spaces=$(( (SNOW - chars) / 2 ))

    if [ "$CURRENT_SYMBOL" == "*" ]; then
        CURRENT_SYMBOL="#"
    else
        CURRENT_SYMBOL="*"
    fi

    draw_line "$spaces" "$chars" "$CURRENT_SYMBOL"
done

for i in 1 2; do
    spaces=$(( (SNOW - 3) / 2 ))
    draw_line "$spaces" 3 "#"
done

if ((SNOW % 2 == 0)); then
    SNOW=$((SNOW - 1))
fi

count=0
until [ $count -ge "$SNOW" ]; do
    echo -n "*"
    ((count++))
done
echo
