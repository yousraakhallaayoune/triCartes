# triCartes

#Description

Le projet se déroule autour d'un jeu des cartes suivant le réglement suivant:
- Chaque joueur recevra une main de 10 cartes tirées de manière aléatoire.
- Chaque carte possède une couleur ("Carreaux", par exemple) et une valeur ("10", par exemple).

Le résulat doit afficher une main "triée" à l'utilisateur. C'est-à-dire que les cartes doivent être classées par couleur et valeur.
 	*  Exemple de l'ordre des couleurs: Carreaux, Cœur, Pique, Trèfle;
 
	*  Exemple de l'ordre des valeurs: AS, 2, 3, 4, 5, 6, 7, 8, 9, 10, Valet, Dame, Roi.

#Logique utilisée

- on récupère les données via l'API.
- on extrait les cartes ayant chacune une catégorie et une valeur et on les trie suivant les ordres des catégories et des valeurs données via l'API, en procédant par la logique suivante:

	* On récupère l'ordre de l'index de chaque catégorie par rapport à l'ordre de categoryOrder;
	* On récupère l'ordre de l'index de chaque valeur par rapport à l'ordre de valueOrder;

	* on rassemble les données dans un tableau à deux dimensions "category" et "value" tout en gardant les index récupérés;
	* on procède par récursivité pour ordonner le tableau à deux dimensions selon les index récupérés
	* on fusionne le tableau trié de deux dimensions pour obtenir un tableau d'une seule dimension
	* Ajouter l'ordre des catégories et l'ordre des valeurs aux tableau résultant 
	* Renvoyer le résultat à l'API sous format json

#Présentation du résultat

Vous pouvez consulter le résultat sous: le lien: "hostname"/carte
	- Un tableau des données non triées
	- Un tableau des données triées 

