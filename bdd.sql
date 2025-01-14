-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_commandes;
USE gestion_commandes;

CREATE TABLE UTILISATEURS(
   idUtilisateur INT AUTO_INCREMENT,
   nomUtilisateur VARCHAR(50)  NOT NULL,
   prenomUtilisateur VARCHAR(50)  NOT NULL,
   pseudoUtilisateur VARCHAR(50)  NOT NULL,
   mdpUtilisateur VARCHAR(50)  NOT NULL,
   roleUtilisateur INT NOT NULL,
   PRIMARY KEY(idUtilisateur)
);

CREATE TABLE CLIENT(
   idClient INT AUTO_INCREMENT,
   nomClient VARCHAR(50)  NOT NULL,
   prenomClient VARCHAR(50)  NOT NULL,
   codePostalClient INT NOT NULL,
   villeClient VARCHAR(50)  NOT NULL,
   PRIMARY KEY(idClient)
);

CREATE TABLE ARTICLE(
   codeArticle INT AUTO_INCREMENT,
   libelleArticle VARCHAR(50) ,
   garantieArticle INT,
   prixUnitaire INT NOT NULL,
   qteStockPrincipal INT,
   qteStockSAV INT,
   qteStockRebus VARCHAR(50) ,
   PRIMARY KEY(codeArticle)
);

CREATE TABLE KIT(
   codeKit INT AUTO_INCREMENT,
   nomKit VARCHAR(50)  NOT NULL,
   PRIMARY KEY(codeKit)
);

CREATE TABLE DIAGNOSTIC(
   idDiag INT AUTO_INCREMENT,
   statutDiag BOOLEAN,
   PRIMARY KEY(idDiag)
);

CREATE TABLE FACTURE(
   idFacture INT AUTO_INCREMENT,
   PRIMARY KEY(idFacture)
);

CREATE TABLE COMMANDE(
   numCommande INT AUTO_INCREMENT,
   dateCommande DATE NOT NULL,
   idDiag INT,
   idClient INT NOT NULL,
   PRIMARY KEY(numCommande),
   FOREIGN KEY(idDiag) REFERENCES DIAGNOSTIC(idDiag),
   FOREIGN KEY(idClient) REFERENCES CLIENT(idClient)
);

CREATE TABLE DOSSIER_RECLAMATION(
   numDossier INT AUTO_INCREMENT,
   dateDossier DATE NOT NULL,
   typeDossier INT NOT NULL,
   dateClotureDossier DATE,
   statutDossier INT NOT NULL,
   commentaireDossier VARCHAR(200) ,
   numCommande INT,
   idDiag INT,
   idUtilisateur INT NOT NULL,
   PRIMARY KEY(numDossier),
   FOREIGN KEY(numCommande) REFERENCES COMMANDE(numCommande),
   FOREIGN KEY(idDiag) REFERENCES DIAGNOSTIC(idDiag),
   FOREIGN KEY(idUtilisateur) REFERENCES UTILISATEURS(idUtilisateur)
);

CREATE TABLE EXPEDITION(
   numExpedition INT AUTO_INCREMENT,
   quantiteExpedie INT NOT NULL,
   dateExpedition DATE NOT NULL,
   numDossier INT NOT NULL,
   numCommande INT NOT NULL,
   PRIMARY KEY(numExpedition),
   FOREIGN KEY(numDossier) REFERENCES DOSSIER_RECLAMATION(numDossier),
   FOREIGN KEY(numCommande) REFERENCES COMMANDE(numCommande)
);

CREATE TABLE APPELER(
   idUtilisateur INT,
   idClient INT,
   PRIMARY KEY(idUtilisateur, idClient),
   FOREIGN KEY(idUtilisateur) REFERENCES UTILISATEURS(idUtilisateur),
   FOREIGN KEY(idClient) REFERENCES CLIENT(idClient)
);

CREATE TABLE COMPOSER(
   codeArticle INT,
   codeKit INT,
   PRIMARY KEY(codeArticle, codeKit),
   FOREIGN KEY(codeArticle) REFERENCES ARTICLE(codeArticle),
   FOREIGN KEY(codeKit) REFERENCES KIT(codeKit)
);

CREATE TABLE CONTENIR(
   codeArticle INT,
   numCommande INT,
   quantitéArticleCommande INT NOT NULL,
   PRIMARY KEY(codeArticle, numCommande),
   FOREIGN KEY(codeArticle) REFERENCES ARTICLE(codeArticle),
   FOREIGN KEY(numCommande) REFERENCES COMMANDE(numCommande)
);

CREATE TABLE CONCERNER(
   codeArticle INT,
   numDossier INT,
   PRIMARY KEY(codeArticle, numDossier),
   FOREIGN KEY(codeArticle) REFERENCES ARTICLE(codeArticle),
   FOREIGN KEY(numDossier) REFERENCES DOSSIER_RECLAMATION(numDossier)
);

CREATE TABLE ENGENDRER(
   numCommande INT,
   idFacture INT,
   PRIMARY KEY(numCommande, idFacture),
   FOREIGN KEY(numCommande) REFERENCES COMMANDE(numCommande),
   FOREIGN KEY(idFacture) REFERENCES FACTURE(idFacture)
);



-- UTILISATEURS
INSERT INTO `utilisateurs` (`nomUtilisateur`, `prenomUtilisateur`, `pseudoUtilisateur`, `mdpUtilisateur`, `roleUtilisateur`) VALUES
('Pion', 'Tarten', 'tartenpion', '123456', 1),
('Nemar', 'Jean', 'jeannemar', '123456', 2),
('Position', 'Paul', 'paulposition', '123456', 2),
('Terrieur', 'Alex', 'alexterrieur', '123456', 2),
('Man', 'Iron', 'ironman', '123456', 3),
('Man', 'Spider', 'spiderman', '123456', 3),
('Arrya', 'Stark', 'arryastark', '123456', 3);


-- CLIENTS
INSERT INTO `client`(`nomClient`, `prenomClient`, `codePostalClient`, `villeClient`) VALUES 
('Troijour','Adam','69000','Lyon'),
('Hénette','Claire','13000','Marseille'),
('Stourne','Henri','75000','Paris');


-- ARTICLE
INSERT INTO `article`(`libelleArticle`, `garantieArticle`, `prixUnitaire`, `qteStockPrincipal`, `qteStockSAV`, `qteStockRebus`) VALUES 
('Portail','10','1200','5','0','0'),
('Portillon','2','250', '5','1','0'),
('Grillage','1','55', '20','2','2'),
('Piquet','1','5', '20','1','1');

-- KIT
INSERT INTO `kit`(`nomKit`) VALUES 
('Portail et Portillon'),
('Grillage et Portillon');

-- CREATION DES KITS
INSERT INTO `composer`(`codeArticle`, `codeKit`) VALUES 
('1','1'),
('2','1'),
('2','2'),
('3','2');

-- COMMANDE
INSERT INTO `commande`(`dateCommande`,`idClient`) VALUES 
('2024/03/18','1'),
('2024/03/18','2'),
('2024/03/18','3'),
('2023/09/10','3'),
('2023/10/10','3'),
('2023/12/20','3');

-- CONTENU COMMANDE
INSERT INTO `contenir`(`codeArticle`, `numCommande`, `quantitéArticleCommande`) VALUES 
-- commande numéro 1
('1','1','2'),
('2','1','2'),
-- commande numéro 2
('1','2','1'),
('3','2','2'),
-- commande numéro 3
('1','3','2'),
('2','3','1'),
('3','3','1'),
-- commande numéro 4
('1','4','2'),
('4','4','10'),
('3','4','1'),
-- commande numéro 5
('1','5','2'),
('4','5','10'),
('3','5','1'),
-- commande numéro 6
('1','6','2'),
('4','6','10'),
('3','6','1');

-- DIAGNOSTIC
INSERT INTO `diagnostic`(`idDiag`) VALUES 
('1'),
('2');

-- CREATION DOSSIERS
INSERT INTO `dossier_reclamation`(`dateDossier`, `typeDossier`,`statutDossier`,`numCommande`, `idUtilisateur`) VALUES 
('2024-03-15','5','2','1', '2'),
('2024-02-24','5','1','2', '2'),
('2024-03-10','2','3','3', '2');

-- CONCERNER

INSERT INTO `concerner`(`codeArticle`, `numDossier`) VALUES 
('1','1'),
('2','1'),
('3','2'),
('4','3');
