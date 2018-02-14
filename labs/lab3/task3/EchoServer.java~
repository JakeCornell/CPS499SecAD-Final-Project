 

import java.net.*;
import java.io.*;
import java.util.ArrayList;

public class EchoServer {
    static ThreadList threadlist = new ThreadList();
    public static void main(String[] args) throws IOException {
        
        if (args.length != 1) {
            System.err.println("Usage: java EchoServer <port number>");
            System.exit(1);
        }
        
        int portNumber = Integer.parseInt(args[0]);
        
        try {
            ServerSocket serverSocket =
                new ServerSocket(Integer.parseInt(args[0]));
	    while(true){
            	System.out.println("EchoServer is running at port " + Integer.parseInt(args[0]));
            	Socket clientSocket = serverSocket.accept(); 
           	System.out.println("A client is connected ");
		EchoServerThread newthread = new EchoServerThread(threadlist, clientSocket);
		threadlist.addThread(newthread);
		newthread.start();
	    }
         } catch (IOException e) {
            System.out.println("Exception caught when trying to listen on port "
                + portNumber + " or listening for a connection");
            System.out.println(e.getMessage());
        }
    }
}

class EchoServerThread extends Thread{
	private Socket clientSocket = null;
	ThreadList threadlist = null;
	public EchoServerThread(Socket socket){
		clientSocket = socket;
	}
	public EchoServerThread(ThreadList threadlist, Socket socket){
		this.threadlist = threadlist;
		clientSocket = socket;
	}

	public void run(){
		System.out.println("A new thread for client is running");
		System.out.println("Inside Thread: Total Clients: " + threadlist.getNumberofThreads());
	try {
	 	
	    PrintWriter out =
                new PrintWriter(clientSocket.getOutputStream(), true);
            BufferedReader in = new BufferedReader(
                new InputStreamReader(clientSocket.getInputStream()));

            String inputLine;
            while ((inputLine = in.readLine()) != null) {
                System.out.println("received from client: " + inputLine);
                System.out.println("Echo back");
                out.println(inputLine);
            }
        } catch (IOException e) {
            
            System.out.println(e.getMessage());
        }
    }
}

class ThreadList{
	private ArrayList<EchoServerThread> threadlist = new ArrayList<EchoServerThread>(); //store the list of threads in this variable	
	public ThreadList(){		
	}
	public int getNumberofThreads(){
		return threadlist.size();	
	}
	public void addThread(EchoServerThread newthread){
		threadlist.add(newthread);	//add the newthread object to the threadlist	
	}
	public void removeThread(EchoServerThread thread){
		threadlist.remove(thread);	//remove the given thread from the threadlist		
	}
	public void sendToAll(String message){
			//ask each thread in the threadlist to send the given message to its client		
	}
}


