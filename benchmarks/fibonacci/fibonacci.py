#!/usr/bin/env python3

import sys

# Function for nth fibonacci number
def fibonacci(n):
    a, b = 0, 1

    for _ in range(0, n):
        a, b = b, (a + b)
    return a

# Driver Program
fibonacci(int(sys.argv[1]))
