<?php
/*
* Copyright 2007-2013 Charles du Jeu - Abstrium SAS <team (at) pyd.io>
* This file is part of Pydio.
*
* Pydio is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Pydio is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with Pydio.  If not, see <http://www.gnu.org/licenses/>.
*
* The latest code can be found at <http://pyd.io/>.
*/
$mess=array(
"Lucene Search Engine" => "Moteur de recherche Lucene",
"Zend_Search_Lucene implementation to index all files and search a whole repository quickly." => "Intégration de la librairie Zend_Search_Lucene pour l'indexation des fichiers et la recherche rapide dans l'intégralité d'un dépôt.",
"Index Content" => "Indexer le contenu",
"Parses the file when possible and index its content (see plugin global options)" => "Indexe, si possible, le contenu des documents (voir les options du plugin)",
"Index Meta Fields" => "Champs métadonnées",
"Which additionnal fields to index and search" => "Liste de champs additionnels à indexer et rechercher",
"Repository keywords" => "Mot-clés dépôt",
"If your repository path is defined dynamically by specific keywords like AJXP_USER, or your own, mention them here." => "Si le chemin de votre dépôt contient des mot-clés tel AJXP_USER, les mentionner ici.",
"Parse Content Until" => "Analyser le contenu jusqu'à",
"Skip content parsing and indexation for files bigger than this size (must be in Bytes)" => "Ne pas analyser et indexer les fichiers dont la taille est plus grande que (en octets)",
"HTML files" => "Fichiers HTML",
"List of extensions to consider as HTML file and parse content" => "Liste d'extensions considérées comme des fichiers HTML.",
"Text files" => "Fichiers texte",
"List of extensions to consider as Text file and parse content" => "Liste d'extensions considérées comme des fichiers texte.",
"Unoconv Path" => "Chemin de Unoconv",
"Full path on the server to the 'unoconv' binary" => "Chemin complet, sur le serveur, d'accès au programme 'unoconv'",
"PdftoText Path" => "Chemin de PdftoText",
"Full path on the server to the 'pdftotext' binary" => "Chemin complet, sur le serveur, d'accès au programme 'pdftotext'",
"Query Analyzer" => "Analyseur de requêtes",
"Analyzer used by Zend to parse the queries. Warning, the UTF8 analyzers require the php mbstring extension." => "Analyzeur utilisé par zend pour analyser les requêtes. Attention, les analysuers UTF8 requierent l'extension php mbstring.",
"Wildcard limitation" => "Limitation des jokers",
"For the sake of performances, it is not recommanded to use wildcard as a very first character of a query string. Lucene recommends asking the user minimum 3 characters before wildcard. Still, you can set it to 0 if necessary for your usecases." => "Pour des raisons de performances, il n'est pas recommandé d'utiliser un joker en premier caractère d'une requête. Lucene recommande de demander, à l'utilisateur, au minimum, 3 caractères avant le joker. Toutefois, vous pouvez le définir à 0 si requis pour votre utilisation.",
);