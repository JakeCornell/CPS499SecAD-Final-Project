#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main(int argc, char * argv[]) {
    char buffer[126];
    size_t buffer_size = sizeof(buffer);
    strncpy(buffer,argv[1],buffer_size);
    printf("%s\n", buffer);
}

