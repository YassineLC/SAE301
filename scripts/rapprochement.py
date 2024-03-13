import sys
import os
import pickle
import networkx as nx
import json

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


# Obtenir le chemin du dossier actuel du script rapprochement.py
current_dir = os.path.dirname(__file__)

# Construire le chemin vers graph.pickle de manière dynamique
graph_path = os.path.join(current_dir, 'graph.pickle')


source = sys.argv[1]  # Identifiant de la source
target = sys.argv[2]  # Identifiant de la cible

#print(f"Tentative de chargement de: {graph_path}")
try:
    # Tenter de charger le graphe sérialisé
    with open(graph_path, 'rb') as f:
        G_loaded = pickle.load(f)
    
    # Trouver le chemin le plus court
    path = find_shortest_path(G_loaded, source, target)

    #print("Chargement réussi.")
except EOFError:
    path = None
    #print(f"Erreur: le fichier {graph_path} est vide ou corrompu.")
except Exception as e:
    path = None
    #print(f"Erreur inattendue lors du chargement du fichier: {e}")

if path is not None:
    print(json.dumps({"status": "success", "path": path}))
else:
    print(json.dumps({"status": "error", "message": f"Aucun chemin trouvé entre {source} et {target}."}))