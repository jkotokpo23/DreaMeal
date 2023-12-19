import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.ConnectException;
import java.net.Socket;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.io.PrintWriter;
import java.io.File;
import java.io.IOException;

public class Client {
    public static void ecrire_logs_client(String id_scanner, String num_billet, String resultat) {
        String filePath = "logs_client.txt";
        try {
            File file = new File(filePath);
            if (!file.exists()) {
                file.createNewFile();
            }

            try (BufferedWriter writer = new BufferedWriter(new FileWriter(file, true))) {
                LocalDateTime now = LocalDateTime.now();
                DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
                String dateHeure = now.format(formatter);

                String ligne =">>> " + dateHeure + " -id_scanner: " + id_scanner + ", num_billet: " + num_billet + ", resultat: " + resultat;
                writer.write(ligne);
                writer.newLine();
            } catch (IOException e) {
                System.out.println("Erreur lors de l'écriture dans le fichier logs_client.txt : " + e.getMessage());
            }
        } catch (IOException e) {
            System.out.println("Erreur lors de la création du fichier logs_client.txt : " + e.getMessage());
        }
    }
    
    public static void main(String[] args) {
        try{
            if (args.length == 2){
                Socket socket = null;
                PrintWriter writer = null;
                BufferedReader reader = null;
                BufferedReader responseReader = null;

                try {
                    try{
                        socket = new Socket(args[0], Integer.parseInt(args[1]));
                        socket.setSoTimeout(10000);
                    }
                    catch (ConnectException e){
                        System.out.println("Impossible de se connecter au serveur, veuillez vérifier l'adresse et le port du serveur, ou que le serveur est bien lancé.");
                        System.exit(1);
                    }
                    writer = new PrintWriter(socket.getOutputStream(), true);
                    reader = new BufferedReader(new InputStreamReader(System.in));
                    responseReader = new BufferedReader(new InputStreamReader(socket.getInputStream()));
                    String ticketNumber, id_scanner;
                    boolean condition;


                    System.out.print("Entrez l'identifiant du scanner : ");

                    do {
                        id_scanner = reader.readLine();
                        condition = !id_scanner.matches("(?i)scan\\d{6}");
                        if (condition) {
                            System.out.println("Veuillez entrer un identidiant de scanner valide.");
                        }
                    } while (condition);


                    System.out.print("Entrez le numéro de billet : ");
                    do {
                        ticketNumber = reader.readLine();
                        if (!(ticketNumber.toUpperCase().startsWith("RES") || ticketNumber.toUpperCase().startsWith("CMD")) || !ticketNumber.substring(3).matches("\\d{12}")) {
                            System.out.println("Valeur incorrecte, Veuillez entrer un format de billet valide:");
                        }
                    } while (!(ticketNumber.toUpperCase().startsWith("RES") || ticketNumber.toUpperCase().startsWith("CMD")) || !ticketNumber.substring(3).matches("\\d{12}"));


                    String data = ticketNumber + ",$&" + id_scanner;
                    writer.println(data);

                    System.out.println("Données envoyées au serveur.");

                    // Lire la réponse caractère par caractère jusqu'à rencontrer un caractère de fin de ligne '\n
                    String response = responseReader.readLine();
                    String[] responseParts = response.split(",\\$&");
                    System.out.println(responseParts[0]);
                    if (responseParts[0].equals("Réservation trouvee") || responseParts[0].equals("Réservation expirée")) {
                        System.out.println("Numéro de billet : " + responseParts[1]);
                        System.out.println("Nom : " + responseParts[2]);
                        System.out.println("Prenom : " + responseParts[3]);
                        System.out.println("Nom de la table : " + responseParts[4]);
                        System.out.println("Date de la réservationn : " + responseParts[5]);
                        System.out.println("Heure de la réservation : " + responseParts[6]);
                        System.out.println("Statut de la réservation : " + responseParts[7]);
                        if (responseParts[7].equals("non validée") && responseParts[0].equals("Réservation trouvee")) {
                            System.out.print("Voulez vous valider la réservation ? (1 pour confirmer, 0 pour annuler) : ");
                            String choice = reader.readLine();
                            writer.println(choice);
                            System.out.println("Choix envoyé au serveur.");
                            // Attendre la confirmation du serveur
                            String confirmation = responseReader.readLine();
                            System.out.println(confirmation);
                            if (confirmation.equals("Reservation validee")) {
                               ecrire_logs_client(id_scanner, ticketNumber, confirmation);
                                
                            }
                        }
                    }

                    else if (responseParts[0].equals("Commande trouvée") || responseParts[0].equals("Commande expirée")){
                        System.out.println("Numéro de billet : " + responseParts[1]);
                        System.out.println("Nom : " + responseParts[2]);
                        System.out.println("Prenom : " + responseParts[3]);
                        System.out.println("Date de la commande : " + responseParts[4]);
                        System.out.println("Heure de la commande : " + responseParts[5]);
                        System.out.println("Numero : " + responseParts[6]);
                        System.out.println("Statut de la commande : " + responseParts[7]);
                        if (responseParts[7].equals("non validée") && responseParts[0].equals("Commande trouvée")) {
                            System.out.print("Voulez vous valider la commande ? (1 pour confirmer, 0 pour annuler) : ");
                            String choice = reader.readLine();
                            writer.println(choice);
                            System.out.println("Choix envoyé au serveur.");
                            // Attendre la confirmation du serveur
                            String confirmation = responseReader.readLine();
                            System.out.println(confirmation);
                            if (confirmation.equals("Commande validee")) {
                               ecrire_logs_client(id_scanner, ticketNumber, confirmation);
                                
                            }
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

            else { System.out.println("Syntaxe du script : java client <adresse du serveur> <port du serveur>");}
        }
        catch (Exception e){
            System.out.println("Interruption clavier détectée, fermeture du client.");
        }
    }
}
