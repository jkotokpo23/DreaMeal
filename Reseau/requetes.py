import psycopg2
from datetime import datetime, timedelta


db_host = "postgresql-letsgo.alwaysdata.net"
db_port = 5432
db_name = "letsgo_bd_reseau"
db_user = "letsgo"
db_password = "Projet_bd_res"

import psycopg2
from datetime import datetime, timedelta

def verif_scanner(id_scanner):
    try:
        conn = psycopg2.connect(
            host=db_host,
            port=db_port,
            dbname=db_name,
            user=db_user,
            password=db_password
        )
        cursor = conn.cursor()
        query = """
            SELECT
                id_scanner
            FROM
                scanner
            WHERE
                id_scanner = %s;
        """
        cursor.execute(query, (id_scanner,))
        scanner_info = cursor.fetchone()

        if scanner_info:
            return True
        else:
            return False
    except (Exception, psycopg2.DatabaseError) as error:
        print("Erreur lors de la validation des données:", error)
    finally:
        if conn:
            conn.close()

    return False

def verif_info_res(num_billet):
    try:
        conn = psycopg2.connect(
            host=db_host,
            port=db_port,
            dbname=db_name,
            user=db_user,
            password=db_password
        )

        cursor = conn.cursor()
        query = """
            SELECT
                r.date_reserv,
                r.heure_reserv
            FROM
                reservation r
            JOIN
                utilisateur u ON r.id_user = u.id_user
            WHERE
                r.id_reserv = %s;
        """
        cursor.execute(query, (num_billet,))
        reservation_info = cursor.fetchone()

        if reservation_info:
            # Extraire la date et l'heure de la réservation
            date_reservation, heure_reservation = reservation_info[0], reservation_info[1]

            # La date actuelle
            now_date = datetime.now().date()

            # La différence entre la date actuelle et la date de la réservation
            diff_date = date_reservation - now_date

            # L'heure actuelle
            now_time = datetime.now().time()

            # La différence entre l'heure actuelle et l'heure de la réservation
            diff_time = datetime.combine(datetime.min, now_time) - datetime.combine(datetime.min, heure_reservation)

            # On accepte un intervalle de 20 minutes pour l'heure (retard ou avance)
            if diff_date.days == 0 and abs(diff_time.total_seconds()) <= 20 * 60:
                return 0
            else:
                return 1
        else:
            return 2
    except (Exception, psycopg2.DatabaseError) as error:
        print("Erreur lors de la validation des données:", error)
    finally:
        if conn:
            conn.close()

    return 2


def confirm_res(num_billet):
    try:
        conn = psycopg2.connect(
            host=db_host,
            port=db_port,
            dbname=db_name,
            user=db_user,
            password=db_password
        )

        cursor = conn.cursor()
        cursor.execute("UPDATE reservation SET statut = true WHERE id_reserv = %s;", (num_billet,))
        conn.commit()

    except (Exception, psycopg2.DatabaseError) as error:
        print("Erreur lors de la mise à jour des données :", error)

    finally:
        if conn:
            conn.close()




def verif_info_com (num_com):
    try:
        conn = psycopg2.connect(
            host=db_host,
            port=db_port,
            dbname=db_name,
            user=db_user,
            password=db_password
        )

        cursor = conn.cursor()
        query = """
            SELECT
                c.date_com,
                c.heure_com
            FROM
                commande c
            JOIN
                utilisateur u ON c.id_user = u.id_user
            WHERE
                c.id_commande = %s;
        """
        cursor.execute(query, (num_com,))
        commande_info = cursor.fetchone()
        if commande_info:
            # Extraire la date et l'heure de la réservation
            date_com, heure_com = commande_info[0], commande_info[1]

            # La date actuelle
            now_date = datetime.now().date()

            # La différence entre la date actuelle et la date de la réservation
            diff_date = date_com - now_date

            # L'heure actuelle
            now_time = datetime.now().time()

            # La différence entre l'heure actuelle et l'heure de la réservation
            diff_time = datetime.combine(datetime.min, now_time) - datetime.combine(datetime.min, heure_com)

            # On accepte un intervalle de 20 minutes pour l'heure (retard ou avance)
            if diff_date.days == 0 and abs(diff_time.total_seconds()) <= 20 * 60:
                return 0
            else:
                return 1
        else:
            return 2
    except (Exception, psycopg2.DatabaseError) as error:
        print("Erreur lors de la validation des données:", error)
    finally:
        if conn:
            conn.close()

    return 2



def confirm_com(num_billet):
    try:
        conn = psycopg2.connect(
            host=db_host,
            port=db_port,
            dbname=db_name,
            user=db_user,
            password=db_password
        )

        cursor = conn.cursor()
        cursor.execute("UPDATE commande SET statut = true WHERE id_commande = %s;", (num_billet,))
        conn.commit()

    except (Exception, psycopg2.DatabaseError) as error:
        print("Erreur lors de la mise à jour des données :", error)

    finally:
        if conn:
            conn.close()

def verif_coherence(num_billet, id_scanner):
    if isinstance(num_billet, str) and len(num_billet) == 15:
        if num_billet.upper().startswith("RES") and num_billet[3:].isdigit():
            if isinstance(id_scanner, str) and len(id_scanner) == 10:
                if id_scanner.upper().startswith("SCAN") and id_scanner[4:].isdigit():
                    return 1
        elif num_billet.upper().startswith("CMD") and num_billet[3:].isdigit():
            return 2
    return 0


def get_res_info(num_billet):
    try:
        conn = psycopg2.connect(
            host=db_host,
            port=db_port,
            dbname=db_name,
            user=db_user,
            password=db_password
        )

        cursor = conn.cursor()
        query = """
            SELECT
                r.id_reserv,
                u.nom,
                u.prenom,
                t.nom_table,
                r.date_reserv,
                r.heure_reserv,
                r.statut
            FROM
                reservation r
            JOIN
                tablerestau t ON r.id_table = t.id_table
            JOIN
                utilisateur u ON r.id_user = u.id_user
            WHERE
                r.id_reserv = %s;
        """
        cursor.execute(query, (num_billet,))
        reservation_info = cursor.fetchone()

        if reservation_info:
            table_info = list(reservation_info)
            return table_info
        else:
            return None
    except (Exception, psycopg2.DatabaseError) as error:
        print("Erreur lors de la récupération des données:", error)
    finally:
        if conn:
            conn.close()

    return None


def get_com_info(num_billet):
    try:
        conn = psycopg2.connect(
            host=db_host,
            port=db_port,
            dbname=db_name,
            user=db_user,
            password=db_password
        )

        cursor = conn.cursor()
        query = """
            SELECT
                c.id_commande,
                u.nom,
                u.prenom,
                c.date_com,
                c.heure_com,
                c.numero,
                c.statut
            FROM
                commande c
            JOIN
                utilisateur u ON u.id_user = c.id_user
            WHERE
                c.id_commande = %s;
        """
        cursor.execute(query, (num_billet,))
        reservation_info = cursor.fetchone()

        if reservation_info:
            table_info = list(reservation_info)
            return table_info
        else:
            return None
    except (Exception, psycopg2.DatabaseError) as error:
        print("Erreur lors de la récupération des données:", error)
    finally:
        if conn:
            conn.close()

    return None