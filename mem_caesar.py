import sys

def error_die(message):
    sys.stderr.write(message)
    sys.stderr.write("\n")
    sys.exit(-1)


if len(sys.argv) < 2:
    error_die('Usage: ./caesar.php N')

N = sys.argv[1];

if not N.isdigit() and (N[0:1] != '-' or not N[1:].isdigit()) :
    error_die("{} should be numeric".format(N))

CHUNK_SIZE = 1024
N = int(N)

cache = {}
low_bounds = ['a', 'z']
up_bounds = ['A', 'Z']
diff = ord('Z') - ord('A') + 1;
ord_low_bounds = [ord('a'), ord('z')]
ord_up_bounds = [ord('A'), ord('Z')]

while True:
    input = sys.stdin.read(CHUNK_SIZE)
    if len(input) == 0:
        break
    buffer = []
    for c in input:
        r = cache.get(c)
        if r == None:
            r = c
            if c >= low_bounds[0] and c <= low_bounds[1]:
                x = ord(c) + N
                if x > ord_low_bounds[1]:
                    x -= diff;
                if x < ord_low_bounds[0]:
                    x += diff;
                r = chr(x)

            if c >= up_bounds[0] and c <= up_bounds[1]:
                x = ord(c) + N;
                if x > ord_up_bounds[1]:
                    x -= diff;
                if x < ord_up_bounds[0]:
                    x += diff;

                r = chr(x)
            cache[c] = r

        buffer.append(r)
    sys.stdout.write("".join(buffer))
