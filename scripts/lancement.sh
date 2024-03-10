#!/bin/bash

# Vérifier si Python est installé
echo "Vérification de l'installation de Python et des bibliothèques requises."
if ! which python3 > /dev/null; then
   echo "Python n'est pas installé. Veuillez installer Python 3."
   exit 1
fi

## Fonction pour vérifier et demander l'installation des bibliothèques manquantes
verif_bibli() {
    lib=$1
    if ! python3 -c "import $lib" 2>/dev/null; then
        echo "La bibliothèque $lib n'est pas installée."
        read -p "Voulez-vous l'installer maintenant ? (O/n) " response
        if [[ "$response" =~ ^([oO][uU]|[oO])$ ]]; then
            pip install $lib
        elif [[ "$response" =~ ^([nN][oO]|[nN])$ ]]; then
            echo "L'utilisateur a choisi de ne pas installer $lib. Arrêt du script."
            exit 1
        else
            echo "Réponse non reconnue. Arrêt du script."
            exit 1
        fi
    fi
}

# Liste des bibliothèques à vérifier
libs=("psycopg2" "networkx")

# Pour les bibliothèques standard Python, pas besoin de vérification
# libs_standard=("pickle", "json", "concurrent.futures") sont inclus dans Python

for lib in "${libs[@]}"; do
    verif_bibli $lib
done

echo "Toutes les vérifications sont passées. Continuation du script."

# Assurer que le script s'arrête en cas d'erreur
set -e

# Affichage du message de début
echo "Début du processus centralisé"

# Demander le chemin du répertoire des scripts
read -p "Veuillez entrer le chemin complet du répertoire SAE/scripts: " chemin_scripts

# Se déplacer vers le répertoire spécifié
cd "$chemin_scripts"

# Assurer que les scripts shell, SQL et Python sont exécutables
chmod +777 ./
chmod +777 telechargement.sh
chmod +777 tables.sql
chmod +777 ajout.sql
chmod +777 lancement.sh
chmod +777 rapprochement.py
chmod +777 extraire_donnee.py

# Demander à l'utilisateur les informations de connexion à la base de données
read -p "Entrez le nom d'utilisateur de la base de données (PGUSER): " PGUSER
read -sp "Entrez le mot de passe de la base de données (PGPASSWORD): " PGPASSWORD
echo # Ajoutez une nouvelle ligne après la saisie du mot de passe
read -p "Entrez l'hôte de la base de données (PGHOST): " PGHOST
read -p "Entrez le nom de la base de données (PGDATABASE): " PGDATABASE

# Exporter les variables pour les rendre disponibles aux scripts invoqués
export PGUSER
export PGPASSWORD
export PGHOST
export PGDATABASE

# Exécution des scripts shell
echo "Lancement de telechargement.sh"
./telechargement.sh

echo "Lancement de importation.sh"
./importation.sh


# Ajouter les fonctions avec functions.sql
echo "Ajout des fonctions avec functions.sql"
PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -f "functions.sql"

# Ajouter les index avec ajout.sql
echo "Ajout des index avec ajout.sql"
PGPASSWORD="$PGPASSWORD" psql -h "$PGHOST" -d "$PGDATABASE" -U "$PGUSER" -f "ajout.sql"

# Exécution du script Python pour création du graphe 
python3 extraire_donnee.py $PGUSER $PGPASSWORD $PGHOST $PGDATABASE
chmod +777 graph.pickle

echo "Processus centralisé terminé avec succès"