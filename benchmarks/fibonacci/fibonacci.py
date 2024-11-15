#!/usr/bin/env python3

import sys

# Function for nth fibonacci number
def fibonacci(n):
    a, b = 0, 1

    for i in range(0, n):
        a, b = b, (a + b)
        print(f"| [+] Counting {i+1}-nth number", end='\r', flush=True)
    print(end='\n')

# Driver Program
fibonacci(int(sys.argv[1]))
