import sys
import pickle
import networkx as nx
import json
import psycopg2
import concurrent.futures

def find_shortest_path(graph, source, target):
    """
    Trouve et retourne le chemin le plus court entre deux nœuds dans un graphe
    en utilisant l'algorithme de Dijkstra.

    :param graph: Le graphe NetworkX chargé.
    :param source: L'identifiant du nœud source.
    :param target: L'identifiant du nœud cible.
    :return: Une liste des nœuds formant le chemin le plus court.
    """
    try:
        # Calcul du chemin le plus court
        path = nx.shortest_path(graph, source=source, target=target)
        return path
    except nx.NetworkXNoPath:
        path= ["Aucun chemin trouvé entre {source} et {target}."]
        return None
    
def fetch_node_details(node_id):
    """
    Fonction pour récupérer les détails d'un nœud (titre ou nom) basé sur son identifiant.
    """
    with psycopg2.connect(conn_string) as conn:
        with conn.cursor() as cursor:
            if node_id.startswith('tt'):
                query = "SELECT tconst, originaltitle FROM resultats_intermediaires WHERE tconst = %s;"
            elif node_id.startswith('nm'):
                query = "SELECT nconst, primaryname FROM resultats_intermediaires WHERE nconst = %s;"
            cursor.execute(query, (node_id,))
            result = cursor.fetchone()
    return node_id, result[1] if result else 'Inconnu'

# Chemin vers le fichier où votre graphe est sauvegardé
graph_path = '/var/www/html/GitHub/SAE/SAE301/scripts/graph.pickle'

# Charger le graphe sérialisé
with open(graph_path, 'rb') as f:
    G_loaded = pickle.load(f)

# Initialisation d'un dictionnaire pour stocker les résultat
result_data = {}
source = sys.argv[1]  # Identifiant de la source
target = sys.argv[2]  # Identifiant de la cible
    
# Trouver le chemin le plus court
path = []
path = find_shortest_path(G_loaded, source, target)

# Paramètres de connexion à la base de données
host = "localhost"
dbname = "sae"
user = "melvyn"
password = "4774"
conn_string = f"host={host} dbname={dbname} user={user} password={password}"

if path  != [] : 
    
    # Utilisation de ThreadPoolExecutor pour récupérer les détails en parallèle tout en conservant l'ordre
    with concurrent.futures.ThreadPoolExecutor(max_workers=5) as executor:
        # executor.map prend en charge le maintien de l'ordre des résultats en fonction de l'ordre des appels
        results = list(executor.map(fetch_node_details, path))

    with open('/var/www/html/GitHub/GRP/SAE301/scripts/result.json', 'w') as file:
        json.dump(results, file) 

    
    print(results); 

# Affichage des résultats dans l'ordre
#    for node_id, details in results:
#        print(f"{node_id}: {details}") 