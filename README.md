Test Apitic
======

Projet de test Apitic.
Ce projet est documenté via les commentaires PHP.

Pour ce qui est des entités, il y a une entité mère 'Animal' dont hérite les entités filles 'Reptile', 'Mammmal'
et 'Bird'. Ces entités fille n'apportent aucun attribut, seulement leurs getters/setters respectifs ('fur' et 'growl' pour
les mammifères par exemple). Un 'Animal' a un type (Mammifère, Reptile ou Oiseau) qui permet de retrouver
sa classe fille.

Le contrôleur gère seulement des instances d'Animal. Lorsqu'un Animal est persisté en base ou mise à jour,
il est intercepté par un listener Doctrine. Son persist/update est annulé, il est transformé en la classe
fille d'après son type et ce dernier est persisté/mis à jour à sa place.

La gestion des couleurs pour l'affichage des animaux en fonctions de leur type est gérée par une extension
twig qui affiche une couleur claire (sur laquelle on peut écrire en noir de manière lisible) pour chaque
classe fille d'Animal affichée. Sa syntaxe est la suivante addAnimalColor(animalEntity). Elle retourne
un attribut 'style' appliquant une couleur de fond.

Enfin, l'affichage des informations des animaux est simplement fait avec Twig via la méthode '__tostring'
implémenté par les classes filles.
