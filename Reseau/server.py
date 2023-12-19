import socket
import requetes as req
import sys
import time

# Fonction pour écrire dans les logs
def write_to_logs(operation, client_address, ticket_number, id_scanner):
    if operation == 1:
        operation = "Reservation"
    elif operation == 2:
        operation = "Commande"
    with open("logs.txt", "a", encoding="utf-8") as file:
        timestamp = time.strftime("%Y-%m-%d %H:%M:%S")
        log_entry = f">>> {client_address[0]}:{client_address[1]} - {timestamp} - Operation: {operation} - Ticket: {ticket_number}, ID_scanner: {id_scanner}\n"
        file.write(log_entry)

# Fonction pour écrire dans les logs des anomalies
def write_to_suspect_logs(client_address, anomaly):
    with open("suspect.txt", "a", encoding="utf-8") as file:
        timestamp = time.strftime("%Y-%m-%d %H:%M:%S")
        log_entry = f">>> {client_address[0]}:{client_address[1]} - {timestamp} - anomaly detected: {anomaly}\n"
        file.write(log_entry)

# Vérification des arguments en ligne de commande
if len(sys.argv) == 2:
    try:
        port = int(sys.argv[1])
    except ValueError:
        print("Le port doit être un entier, utilisation du port par défaut 59960\n")
        port = 59960
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    try :
        server_socket.bind(('0.0.0.0', port))
    except socket.error :
        try :
            print("Erreur lors du bind du socket, le port est déja utilisé, utilisation du port par défaut 59960\n")
            port = 59960
            server_socket.bind(('0.0.0.0', port))
        except socket.error :
            print("Erreur lors du bind du socket, le port par défaut ", port, "est déja utilisés lui aussi veuillez choisir un autre port\n")
            exit()
else :
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    port = 59960
    server_socket.bind(('0.0.0.0', port))

server_socket.listen(1)
anomaly = None

while True:
    try:
        print(f"Serveur en attente de connexions sur le port {port}...")

        client_socket, client_address = server_socket.accept()
        print(f"Connexion établie avec {client_address}")

        # définit la durée d'attente avant le timeout de 30 secondes
        client_socket.settimeout(30)
        operation = None
        ticket_number  = None
        id_scanner = None

        data = client_socket.recv(1024).decode('utf-8').rstrip('\n').strip()
        parts = data.split(',$&')

        if len(parts) == 2:
            ticket_number = parts[0].upper()
            id_scanner = parts[1].upper()
            operation = req.verif_coherence(ticket_number, id_scanner)
            if operation != 0:
                if req.verif_scanner(id_scanner) :
                    if operation == 1:
                        print(f"ID de scanner reçu : {id_scanner}")
                        print(f"Numero de billet recu : {ticket_number}")

                        traitement = req.verif_info_res(ticket_number)
                        if traitement == 0:
                            response = "Réservation trouvee,$&"
                            print("Réservation trouvee")
                            infos = req.get_res_info(ticket_number)
                            if infos[6] is None:
                                infos[6] = "non validée"
                            elif infos[6] == True:
                                infos[6] = "validée"
                            else:
                                infos[6] = "annulée"
                            response = response + str(infos[0]) + ",$&" + str(infos[1]) + ",$&" + str(infos[2]) + ",$&" + str(infos[3]) + ",$&" + str(infos[4]) + ",$&" + str(infos[5]) + ",$&" + str(infos[6]) + "\n"
                            client_socket.send(response.encode('utf-8'))
                            if infos[6] == "non validée":
                                print("Donnees recues valides, en attente du choix...")
                                choice = client_socket.recv(1024).decode('utf-8').rstrip('\n').strip()
                                print("Reponse recue du client : " + choice)

                                if choice == "1":
                                    req.confirm_res(ticket_number)
                                    print("Reservation validee")
                                    client_socket.sendall('Reservation validee\n'.encode('utf-8'))
                                else:
                                    print("Reservation non validee")
                                    client_socket.sendall('Reservation non validee\n'.encode('utf-8'))
                        elif traitement == 1:
                            response = "Réservation expirée,$&"
                            infos = req.get_res_info(ticket_number)
                            if infos[6] is None:
                                infos[6] = "non validée"
                            elif infos[6] == True:
                                infos[6] = "validée"
                            else:
                                infos[6] = "annulée"
                            response = response + str(infos[0]) + ",$&" + str(infos[1]) + ",$&" + str(infos[2]) + ",$&" + str(infos[3]) + ",$&" + str(infos[4]) + ",$&" + str(infos[5]) + ",$&" + str(infos[6]) + "\n"
                            client_socket.send(response.encode('utf-8'))
                            print("Réservation expirée")
                        elif traitement == 2:
                            client_socket.sendall('Donnees non valides\n'.encode('utf-8'))
                            print("Donnees recues invalides")
                    elif operation == 2:
                        print(f"Numero de commande recu : {ticket_number}")
                        print(f"Nom recu : {id_scanner}")

                        traitement = req.verif_info_com(ticket_number)
                        if traitement == 0:
                            response = "Commande trouvée,$&"
                            print("Commande trouvée")
                            infos = req.get_com_info(ticket_number)
                            if infos[6] is None:
                                infos[6] = "non validée"
                            elif infos[6] == True:
                                infos[6] = "validée"
                            else:
                                infos[6] = "annulée"
                            response = response + str(infos[0]) + ",$&" + str(infos[1]) + ",$&" + str(infos[2]) + ",$&" + str(infos[3]) + ",$&" + str(infos[4]) + ",$&" + str(infos[5]) + ",$&" + str(infos[6]) + "\n"
                            client_socket.sendall(response.encode('utf-8'))
                            if infos[6] == "non validée":
                                print("Donnees recues valides, en attente du choix...")
                                choice = client_socket.recv(1024).decode('utf-8').rstrip('\n').strip()
                                print("Reponse recue du client : " + choice)

                                if choice == "1":
                                    req.confirm_com(ticket_number)
                                    print("Commande validee")
                                    client_socket.sendall('Commande validee \n'.encode('utf-8'))
                                else:
                                    print("Commande non validee")
                                    client_socket.sendall('Commande non validee\n'.encode('utf-8'))
                        elif traitement == 1:
                            response = "Commande expirée,$&"
                            print("Commande expirée")
                            infos = req.get_com_info(ticket_number)
                            if infos[6] is None:
                                infos[6] = "non validée"
                            elif infos[6] == True:
                                infos[6] = "validée"
                            else:
                                infos[6] = "annulée"
                            response = response + str(infos[0]) + ",$&" + str(infos[1]) + ",$&" + str(infos[2]) + ",$&" + str(infos[3]) + ",$&" + str(infos[4]) + ",$&" + str(infos[5]) + ",$&" + str(infos[6]) + "\n"
                            client_socket.sendall(response.encode('utf-8'))
                        elif traitement == 2:
                            client_socket.sendall('Donnees non valides\n'.encode('utf-8'))
                            print("Donnees recues invalides")
                else:
                    client_socket.sendall('ID de scanner invalide\n'.encode('utf-8'))
                    anomaly = "ID de scanner invalide"
                    print("ID de scanner invalide, opération annulée")
            else:
                client_socket.sendall('Donnees incoherentes\n'.encode('utf-8'))
                anomaly = "Donnees incoherentes"
                print("Donnees recues incohérentes, opération annulée")
        else:
            client_socket.sendall('Format de donnees recues invalide\n'.encode('utf-8'))
            print("Format de donnees recues invalide, opération annulée")
            anomaly = "Format de donnees recues invalide"

    except socket.timeout:
        client_socket.close()
        print("Le client n'a pas répondu dans les 30 secondes, connexion fermée.")
    
    except ConnectionAbortedError:
        client_socket.close()
        print("Le client a arrêté la connexion.")
        anomaly = "Le client a arrêté la connexion."

    except Exception as e:
        client_socket.close()
        print("Erreur connexion stoppée avec le client !", e)
        anomaly = "Erreur innatendue, connexion stoppée avec le client !"

    finally:
        client_socket.close()
        if anomaly is None:
            write_to_logs(operation, client_address, ticket_number, id_scanner)
        else:
            write_to_suspect_logs(client_address, anomaly)
            anomaly = None