<?php

/*

Enoncés :
Echo, mascotte de l'équipe de Globalis, a découvert une fonction foo() bien mystérieuse. Hélas, il n'a pas accès au code.
Curieux et grand amateur de rétro-ingénierie, Echo s'est amusé à appeler cette fonction, en injectant des données en entrée et en récoltant les sorties.
Le comportement de la fonction foo() est le suivant :

Appel > Sortie
foo([[0, 3], [6, 10]]) > [[0, 3], [6, 10]]
foo([[0, 5], [3, 10]]) > [[0, 10]]
foo([[0, 5], [2, 4]]) > [[0, 5]]
foo([[7, 8], [3, 6], [2, 4]]) > [[2, 6], [7, 8]]
foo([[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6]]) > [[1, 10], [15, 20]]
Le challenge, si vous l'acceptez, serait d'aider Echo à comprendre ce que fait cette fonction et à la recoder. Vous êtes partant ? ;)

Question 1
Expliquez, en quelques lignes, ce que fait cette fonction.
> Cette fonction fusionne des couples de valeurs passés en paramètres par intervalles sécents

Question 2
Codez cette fonction. Merci de fournir un fichier contenant :
- la fonction,
- l'appel de la fonction, avec un jeu de test en entrée,
- l'affichage du résultat en sortie.

Question 3
Précisez en combien de temps vous avez implémenté cette fonction.
> ~24mn

*/

function foo(array $a)
{

    if (empty($a)) {
        return null;
    }

    // Ordering couples ascending
    foreach ($a as &$couple) {
        if ($couple[1] < $couple[0]) {
            $tmp = $couple[0];
            $couple[0] = $couple[1];
            $couple[1] = $tmp;
        }
    }

    sort($a);

    $currentIndex = 0;
    $result = array();

    for ($i = 0; $i <= count($a); $i++) {

        $cursor = $a[$i];
        if (count($cursor) !== 2) {
            continue;
        }

        if (empty($result)) {
            $result[$currentIndex] = $cursor;
            continue;
        }

        if ($cursor[0] <= $result[$currentIndex][1] && $cursor[1] > $result[$currentIndex][1]) {
            $result[$currentIndex][1] = $cursor[1];
        } else if ($cursor[0] > $result[$currentIndex][1]) {
            $currentIndex++;
            $result[$currentIndex] = $cursor;
        }
    }

    return $result;
}

$dataSet = [
    [],
    [[0, 3], [6, 10]], // > [[0, 3], [6, 10]]
    [[0, 5], [3, 10]], // > [[0, 10]]
    [[0, 5], [2, 4]], // > [[0, 5]]
    [[7, 8], [3, 6], [2, 4]], // > [[2, 6], [7, 8]]
    [[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6]] // > [[1, 10], [15, 20]]
];

foreach ($dataSet as $data) {
    $result = foo($data);

    if (is_null($result)) {
        echo '-' . PHP_EOL;
        continue;
    }

    echo '|';
    foreach ($result as $bar) {
        echo $bar[0] . '-' . $bar[1] . '|';
    }
    echo PHP_EOL;
}