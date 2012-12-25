#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>
#include <string.h>

#define CHUNK_SIZE 1024
#define BYTES 256

int is_numeric(char *s) {
    char first = *s;
    if (first != '-' && !isdigit(first)) return 0;
    s++;
    while (*s) {
        if (!isdigit(*s)) return 0;
        s++;
    }
    return 1;
}

int main(int argc, char **argv) {
    if (argc < 2) {
        fputs("Usage: ./caesar.php N", stderr);
        return -1;
    }
    char *S = argv[1];

    if (!is_numeric(S)) {
        fputs(S, stderr);
        fputs(" should be numeric\n", stderr);
        return -1;
    }
    
    char N = atoi(S);
    int read = 0;
    int i;
    char up_bounds[2] = {'A', 'Z'};
    char low_bounds[2] = {'a', 'z'};
    char diff = 'Z' - 'A' + 1;
    char cache[BYTES];
    char buffer[CHUNK_SIZE+1];

    memset(cache, 0, BYTES);

    while ( (read = fread(buffer, sizeof(char), CHUNK_SIZE, stdin)) > 0 ) {
        i = 0;
        while ( i < read ) {
            char current = buffer[i],
                 result;
            if (!cache[current]) {
                result = current;
                if (result >= low_bounds[0] && result <= low_bounds[1]) {
                    result += N;
                    if (result > low_bounds[1]) {
                        result -= diff;
                    }
                    if (result < low_bounds[0]) {
                        result += diff;
                    }
                }

                if (result >= up_bounds[0] && result <= up_bounds[1]) {
                    result += N;
                    if (result > up_bounds[1]) {
                        result -= diff;
                    }
                    if (result < up_bounds[0]) {
                        result += diff;
                    }
                }
                cache[current] = result;
            }
            else {
                result = cache[current];
            }
            buffer[i++] = result;

        }

        buffer[i] = 0;

        fwrite(buffer, sizeof(char), read, stdout);
    }

    return 0;
}
