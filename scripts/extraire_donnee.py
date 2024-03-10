import psycopg2
import networkx as nx
import pickle

# Paramètres de connexion à la base de données
host = "localhost"
dbname = "sae"
user = "melvyn"
password = "4774"

conn_string = f"host={host} dbname={dbname} user={user} password={password}"

# Initialisation du graphe
G = nx.Graph()

try:
    # Connexion à la base de données
    with psycopg2.connect(conn_string) as conn:
        with conn.cursor() as cursor:
            # Requête pour extraire les données pertinentes de la table intermédiaire
            query = "SELECT tconst, nconst FROM resultats_intermediaires;"
            cursor.execute(query)
            
            # Construction du graphe
            for tconst, nconst in cursor:
                G.add_node(tconst, type='title')
                G.add_node(nconst, type='person')
                G.add_edge(tconst, nconst)

except Exception as e:
    print(f"Erreur lors de la connexion à la base de données: {e}")

print(f"Nombre de nœuds : {G.number_of_nodes()}")
print(f"Nombre d'arêtes : {G.number_of_edges()}")

# Chemin où le graphe sérialisé sera sauvegardé
graph_path = './graph.pickle'

with open(graph_path, 'wb') as f:
    pickle.dump(G, f)

print(f"Graphe sauvegardé dans {graph_path}")

