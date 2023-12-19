import com.github.sarxos.webcam.Webcam;
import com.github.sarxos.webcam.WebcamResolution;
import com.github.sarxos.webcam.WebcamPanel;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.image.BufferedImage;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.ConnectException;
import java.net.Socket;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.JTextField;

public class Scanner {

    private static boolean running = true;
    private static boolean foundPic = false;
    private static String pattern;
    private static String adresseIp;
    private static int port;
    private static Socket socket;
    private static PrintWriter writer;
    private static BufferedReader reader;
    private static BufferedReader responseReader;

    public static void main(String[] args) {

        //Scan du QRCode pour recupérer le motif qui sera utilisé pour le client
        Webcam webcam = Webcam.getWebcams().get(0);
        if (webcam == null) {
            System.exit(1);
        }
        
        webcam.setViewSize(WebcamResolution.VGA.getSize());

        JFrame frame = new JFrame("Scanner");
        JTextField textfiled = new JTextField();
        textfiled.setBounds(10, 610, 530, 30);
        textfiled.setSize(new Dimension(530,30));
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        WebcamPanel panel = new WebcamPanel(webcam);
        JPanel mainPanel = new JPanel();
        mainPanel.setLayout(new GridLayout());
        panel.setFPSDisplayed(true);
        panel.setFPSLimited(true);
        panel.setFPSLimit(20);
        frame.setPreferredSize(new Dimension(550,600));
        mainPanel.add(panel);
        mainPanel.add(textfiled);
        frame.add(mainPanel);
        frame.pack();
        frame.setVisible(true);

        webcam.open();
        Thread captureThread = new Thread(() -> {
            while (running) {
                BufferedImage image = webcam.getImage();
                if(!foundPic){
                    if(QRcodeReader.Ref(image) != null){
                        running =false;
                        webcam.close();
                        pattern = QRcodeReader.Ref(image);
                        textfiled.setText(pattern);
                        foundPic = !foundPic;
                        System.out.println(pattern + " GHJ");
                        System.out.println("C'est trouvé\n");
                    }
                }
                try {
                    Thread.sleep(50);
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }
            }
        });
        
        captureThread.start();
        try {
            captureThread.join();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    
        //Partie échange réseaux
         try {
                try{
                    socket = new Socket(adresseIp, port);
                    socket.setSoTimeout(5000);
                }
                catch (ConnectException e){
                    System.out.println("Impossible de se connecter au serveur, veuillez vérifier l'adresse et le port du serveur, ou que le serveur est bien lancé.");
                    System.exit(1);
                }
                writer = new PrintWriter(socket.getOutputStream(), true);
                reader = new BufferedReader(new InputStreamReader(System.in));
                responseReader = new BufferedReader(new InputStreamReader(socket.getInputStream()));
                String ticketNumber, name;
                boolean condition;

                System.out.print("Entrez le numéro de billet : ");
                do {
                    ticketNumber = reader.readLine();
                    if (!(ticketNumber.toUpperCase().startsWith("rsrv") || ticketNumber.toUpperCase().startsWith("cmd")) || ticketNumber.length() != 15) {
                        System.out.println("Valeur incorrecte, Veuillez entrer un format de billet valide:");
                    }
                } while (!(ticketNumber.toUpperCase().startsWith("rsrv") || ticketNumber.toUpperCase().startsWith("cmd")) || ticketNumber.length() != 15);

                System.out.print("Entrez le nom : ");
                do{
                    name = reader.readLine();
                    condition = name.length() > 80 || name.contains(",") || name.contains("$") || name.contains("&");
                    if (condition) {
                        System.out.println("Veilliez entrer un nom valide, sans caractères spéciaux et de moins de 80 caractères:");
                    }
                }while (condition) ;

                String data = ticketNumber + ",$&" + name;
                writer.println(data);

                System.out.println("Données envoyées au serveur.");

                // Lire la réponse caractère par caractère jusqu'à rencontrer un caractère de fin de ligne '\n
                String response = responseReader.readLine();
                String[] responseParts = response.split(",\\$&");
                System.out.println(responseParts[0]);
                if (responseParts[0].equals("Reservation trouvee")) {
                    System.out.println("Numéro de billet : " + responseParts[1]);
                    System.out.println("Nom : " + responseParts[2]);
                    System.out.println("Prenom : " + responseParts[3]);
                    System.out.println("Nom de la table : " + responseParts[4]);
                    System.out.println("Date de la reservation : " + responseParts[5]);
                    System.out.println("Heure de la reservation : " + responseParts[6]);
                    System.out.println("Statut de la reservation : " + responseParts[7]);
                    if (responseParts[7].equals("non validée")) {
                        System.out.print("Voulez vous valider la réservation ? (1 pour confirmer, 0 pour annuler) : ");
                        String choice = reader.readLine();
                        writer.println(choice);
                        System.out.println("Choix envoyé au serveur.");
                        // Attendre la confirmation du serveur
                        String confirmation = responseReader.readLine();
                        System.out.println(confirmation);
                    }
                }

                else if (responseParts[0].equals("Commande trouvee")){
                    System.out.println("Numéro de billet : " + responseParts[1]);
                    System.out.println("Nom : " + responseParts[2]);
                    System.out.println("Prenom : " + responseParts[3]);
                    System.out.println("Date de la commande : " + responseParts[4]);
                    System.out.println("Heure de la commande : " + responseParts[5]);
                    System.out.println("Numero : " + responseParts[6]);
                    System.out.println("Statut de la commande : " + responseParts[7]);
                    if (responseParts[7].equals("non validée")) {
                        System.out.print("Voulez vous valider la commande ? (1 pour confirmer, 0 pour annuler) : ");
                        String choice = reader.readLine();
                        writer.println(choice);
                        System.out.println("Choix envoyé au serveur.");
                        // Attendre la confirmation du serveur
                        String confirmation = responseReader.readLine();
                        System.out.println(confirmation);
                    }
                }

                // Attendez que l'utilisateur appuie sur Entrée pour quitter
                System.out.print("Appuyez sur Entrée pour continuer...");
                reader.readLine();

            } 
            catch (IOException e) {
                System.out.println("Erreur lors de la communication avec le serveur : " + e.getMessage());
                System.exit(1);
            } 
            
            finally {
                try {
                    if (socket != null) {
                        socket.close();
                    }
                } catch (IOException ex) {
                    ex.printStackTrace();
            }
        }
    }



}
