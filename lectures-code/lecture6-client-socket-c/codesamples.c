//slide 18

struct hostent *server_he; //a host address entry
if ((server_he = gethostbyname(???)) == NULL) {  
	perror("error in gethostbyname");
        return 2;
}

//slide 20
//struct hostent *server_he; //declared previously, 

//to get from gethostbyname(..)

struct sockaddr_in serveraddr; //store the server’s addr

//prepare to copy: clear sockaddr_in structure

/* (In network programming, we often need to initialize a field, copy the contents of one field to another */ 

bzero((char *) &serveraddr, sizeof(serveraddr));

//set the family to AF_INET (IPv4)

serveraddr.sin_family = AF_INET;

//slide 21 & 22 

//copy the server’ address from gethostbyname(..),

//return in struct hostent (stored in *server_he)

bcopy((char *)server_he->h_addr, //the first host address

	   (char *)&serveraddr.sin_addr.s_addr, 

       server_he->h_length);

//set the port number

serveraddr.sin_port = htons(port);

//slide 25

#include <sys/types.h>

#include <sys/socket.h>

//connect: create a connection to the server

if (connect(sockfd, (struct sockaddr *) &serveraddr, sizeof(serveraddr)) < 0){ 
    perror("Cannot connect to the server");
	exit(0);
}else
	printf("Connected to the server");

//slide 26

	char *msg = "This is a test message from client";
	int bytes_sent;
	bytes_sent = send(sockfd,msg,strlen(msg),0); //comment out this line after testing properly to start code in the next slide


//slide 27

	char buffer[1024];
	printf("Enter your message:");
	bzero(buffer, 1024);
	fgets(buffer, 1024, stdin); //get from keyboard
	bytes_sent = send(sockfd, buffer, strlen(buffer), 0);


//slide 28	
	int byte_received;
	bzero(buffer, 1024);
	byte_received = recv(sockfd, buffer, 1024, 0);
	if (byte_received < 0) 
		  perror("ERROR reading from socket");

	printf("Message received: %s", buffer);
















