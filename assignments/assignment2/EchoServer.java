import java.net.*;
import java.io.*;
import java.util.ArrayList;
import java.util.*;
import java.io.BufferedReader;
import java.util.regex.Pattern;
import java.util.regex.Matcher;
import java.util.Scanner;

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
	private PrintWriter out = null;
	private ThreadList threadlist = null;
	private String username = "";
	private String password;
	private BufferedReader in = null;
	private static HashSet<String> list = new HashSet<String>();

	

	public EchoServerThread(Socket socket){
		clientSocket = socket;
	}
	public EchoServerThread(ThreadList threadlist, Socket socket){
		this.threadlist = threadlist;
		clientSocket = socket;
	}

	// Checks to make sure login is valid
	private boolean checkLogin(String username, String password){
		boolean validUsername = (username != null) && username.matches("[A-Za-z0-9_]+");
		boolean validPassword = (password != null) && password.matches("[A-Za-z0-9_]+");
		
	try{
		if (validUsername == true){
			return true;
		}else{	
			this.send("Please choose a valid username");
			threadlist.sendToAll("To All: A client exists, the number of connected client:" + (threadlist.getNumberofThreads()-1));
			threadlist.removeThread(this);
			clientSocket.close();
			
		}
		
		if (validPassword == true){
			return true;
		}else{	
			this.send("Please choose a valid password");
			threadlist.sendToAll("To All: A client exists, the number of connected client:" + (threadlist.getNumberofThreads()-1));
			threadlist.removeThread(this);
			clientSocket.close();
			
		}
		
	}catch (IOException e) {
            System.out.println(e.getMessage());
        }

	return false;	
	}

	public void run(){
		System.out.println("A new thread for client is running");
		System.out.println("Inside Thread: Total Clients: " + threadlist.getNumberofThreads());
	try {
	    	
	    /*PrintWriter*/ out =
                new PrintWriter(clientSocket.getOutputStream(), true);
	    	
            BufferedReader in = new BufferedReader(
                new InputStreamReader(clientSocket.getInputStream()));

		// Get a username and password
            String inputLine;
	    this.send("Please enter a username: ");
	    if((inputLine = in.readLine()) != null){
		username = inputLine;
		if((password = in.readLine()) != null){
			if(checkLogin(username, password)){
				this.send("Welcome " + username);
				list.add(username);
				this.send("Here is a list of commands:");
				this.send("<LIST> , <ALL> , <PM>");
			}
		}
		
	    }
            while ((inputLine = in.readLine()) != null) {
                System.out.println("received from client: " + inputLine);
                System.out.println("Echo back");
                //out.println(inputLine);
		// get a list of users
		if(inputLine.equals("<LIST>")){
			out.println(list.toString());
		}
		//send a message to all
		if(inputLine.equals("<ALL>")){
			Scanner input = new Scanner(System.in);
			String mess = input.next();
			threadlist.sendToAll("To All:"+ mess);
		}
		// private message another user
		if(inputLine.equals("<PM>")){
			Scanner input2 = new Scanner(System.in);
			String mess2 = input2.next();
                	if(list.equals(username)){
				this.send(inputLine);
			}
			
		}
		// exit the client
		if(inputLine.equals("<exit>")){
			threadlist.sendToAll("To All: A client exists, the number of connected client:" + (threadlist.getNumberofThreads()-1));
			threadlist.removeThread(this);
			clientSocket.close();
		}
	    }
        } catch (IOException e) {          
            System.out.println(e.getMessage());
        }
	
	}
	public void send(String message){
	    if(out != null){
		out.println(message);
	    }
        }

    } 


class ThreadList{
	private ArrayList<EchoServerThread> threadlist = new ArrayList<EchoServerThread>(); //store the list of threads in this variable
	
	public ThreadList(){		
	}
	public synchronized int getNumberofThreads(){
		return threadlist.size();	
	}
	public synchronized void addThread(EchoServerThread newthread){
		threadlist.add(newthread);	//add the newthread object to the threadlist	
	}
	public synchronized void removeThread(EchoServerThread thread){
		threadlist.remove(thread);	//remove the given thread from the threadlist		
	}
	public synchronized void sendToAll(String message){
		Iterator<EchoServerThread> threadlistIterator = threadlist.iterator();
            	while (threadlistIterator.hasNext()) {
                	EchoServerThread thread = threadlistIterator.next();
                	thread.send(message);
		}
		//ask each thread in the threadlist to send the given message to its client		
	}
}
