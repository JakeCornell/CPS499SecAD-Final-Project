/* include libraries */
#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netdb.h>
#include <string.h>

struct hostent *gethostbyname(const char *name);

int main(int argc, char *argv[]){
    printf("This is a simple TCP client application developed by Jake Cornell for Lab 2 in Secure Application Development - Spring 2018\n");
	if (argc != 3){
		printf("Usage: %s <servername> <port>\n", argv[0]);
		exit(0);
	}
	//printf("Servername= %s, port= %s\n", argv[1], argv[2]);
	char *servername = argv[1];
	int port = atoi(argv[2]);
	printf("Servername= %s, port= %d\n", servername, port);

	int sockfd = socket(AF_INET, SOCK_STREAM, 0);
	if (sockfd < 0){
		perror("ERROR opening socket");
		exit(1);
	}

	printf("A socket is opened\n");
	
	struct hostent *server_he; // a host entry
	if ((server_he = gethostbyname(servername)) == NULL) {
		perror("error in gethostbyname");
		exit(2);
	}
	
	struct sockaddr_in serveraddr; //store the server's addr

	bzero((char *) &serveraddr, sizeof(serveraddr));
	serveraddr.sin_family = AF_INET;
	bcopy((char *)server_he->h_addr, (char *)&serveraddr.sin_addr.s_addr, server_he->h_length);
	
	serveraddr.sin_port = htons(port);

	//API:
	//int connect(int sockfd, struct  sockaddr *server_addr, int addrlen);
	int connected = connect(sockfd, (struct sockaddr *) &serveraddr, sizeof(serveraddr));

	if (connected < 0){
		perror("Cannot connect to the server");
		exit(3);
	}else
		printf("Connected to the server %s at port %d\n",servername, port);

	char *msg = "This is just a test message from the client";
	int byte_sent; // = send(sockfd, msg, strlen(msg), 0);

	char buffer[1024];
	printf("Enter your message: ");
	bzero(buffer, 1024);
	fgets(buffer, 1024, stdin); // This prevents buffer overflow

	sprintf(buffer, "GET / HTTP/1.1\r\n Host: %s\r\n\r\n", servername);
	byte_sent = send(sockfd, buffer, strlen(buffer), 0);	

	bzero(buffer, 1024);
	int byte_received = recv(sockfd, buffer, 1024, 0);
	if(byte_received < 0){
		printf("Error in reading");
		exit(4);
	}
	printf("Received from server: %s", buffer);
	
close(sockfd); 
}
