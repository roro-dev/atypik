#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Roles_Utilisateur
#------------------------------------------------------------

CREATE TABLE Roles_Utilisateur(
        Id_role Int NOT NULL ,
        Role    Varchar (50) NOT NULL
	,CONSTRAINT Roles_Utilisateur_PK PRIMARY KEY (Id_role)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        Id_utilisateur Int NOT NULL AUTO_INCREMENT,
        Nom            Varchar (50) NOT NULL ,
        Prenom         Varchar (50) NOT NULL ,
        Adresse        Varchar (255) NOT NULL ,
        Email          Varchar (255) NOT NULL ,
        Telphone       Varchar (15) NOT NULL ,
        Id_role        Int NOT NULL
	,CONSTRAINT Utilisateur_PK PRIMARY KEY (Id_utilisateur)

	,CONSTRAINT Utilisateur_Roles_Utilisateur_FK FOREIGN KEY (Id_role) REFERENCES Roles_Utilisateur(Id_role)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commentaire
#------------------------------------------------------------

CREATE TABLE Commentaire(
        Id_commentaire Int NOT NULL AUTO_INCREMENT,
        Titre          Varchar (50) NOT NULL ,
        Contenu        Varchar (300) NOT NULL ,
        Note           Int NOT NULL ,
        Photo          Varchar (255) ,
        Id_utilisateur Int NOT NULL
	,CONSTRAINT Commentaire_PK PRIMARY KEY (Id_commentaire)

	,CONSTRAINT Commentaire_Utilisateur_FK FOREIGN KEY (Id_utilisateur) REFERENCES Utilisateur(Id_utilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Activite
#------------------------------------------------------------

CREATE TABLE Activite(
        Id_activite Int NOT NULL AUTO_INCREMENT,
        NomActivite Varchar (255) NOT NULL
	,CONSTRAINT Activite_PK PRIMARY KEY (Id_activite)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Ville
#------------------------------------------------------------

CREATE TABLE Ville(
        Id_ville       Int NOT NULL AUTO_INCREMENT,
        NomVille       Varchar (50) NOT NULL ,
        Taxe           Int NOT NULL ,
        Id_utilisateur Int NOT NULL
	,CONSTRAINT Ville_PK PRIMARY KEY (Id_ville)

	,CONSTRAINT Ville_Utilisateur_FK FOREIGN KEY (Id_utilisateur) REFERENCES Utilisateur(Id_utilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Types_Logement
#------------------------------------------------------------

CREATE TABLE Types_Logement(
        Id_type Int NOT NULL ,
        Type    Varchar (255) NOT NULL
	,CONSTRAINT Types_Logement_PK PRIMARY KEY (Id_type)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Logement
#------------------------------------------------------------

CREATE TABLE Logement(
        Id_logement   Int NOT NULL AUTO_INCREMENT,
        Nom           Varchar (255) NOT NULL ,
        Description   Varchar (255) NOT NULL ,
        NbVoyageur    Int NOT NULL ,
        NbLit         Int NOT NULL ,
        NbSalledeBain Int NOT NULL ,
        Prix          Int NOT NULL ,
        Id_type       Int NOT NULL
	,CONSTRAINT Logement_PK PRIMARY KEY (Id_logement)

	,CONSTRAINT Logement_Types_Logement_FK FOREIGN KEY (Id_type) REFERENCES Types_Logement(Id_type)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type_Paiement
#------------------------------------------------------------

CREATE TABLE Type_Paiement(
        Id_paiement  Int NOT NULL AUTO_INCREMENT,
        ModePaiement Varchar (50) NOT NULL
	,CONSTRAINT Type_Paiement_PK PRIMARY KEY (Id_paiement)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Photo
#------------------------------------------------------------

CREATE TABLE Photo(
        Id_photo    Int NOT NULL AUTO_INCREMENT,
        photo       Varchar (255) NOT NULL ,
        Id_logement Int NOT NULL
	,CONSTRAINT Photo_PK PRIMARY KEY (Id_photo)

	,CONSTRAINT Photo_Logement_FK FOREIGN KEY (Id_logement) REFERENCES Logement(Id_logement)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Réservation
#------------------------------------------------------------

CREATE TABLE Reservation(
        Id_logement         Int NOT NULL ,
        Id_utilisateur      Int NOT NULL ,
        DateDeb_reservation Date NOT NULL ,
        DateFin_reservation Date NOT NULL
	,CONSTRAINT Reservation_PK PRIMARY KEY (Id_logement,Id_utilisateur)

	,CONSTRAINT Reservation_Logement_FK FOREIGN KEY (Id_logement) REFERENCES Logement(Id_logement)
	,CONSTRAINT Reservation_Utilisateur0_FK FOREIGN KEY (Id_utilisateur) REFERENCES Utilisateur(Id_utilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commenter
#------------------------------------------------------------

CREATE TABLE Commenter(
        Id_logement     Int NOT NULL ,
        Id_commentaire  Int NOT NULL ,
        DateCommentaire Date NOT NULL
	,CONSTRAINT Commenter_PK PRIMARY KEY (Id_logement,Id_commentaire)

	,CONSTRAINT Commenter_Logement_FK FOREIGN KEY (Id_logement) REFERENCES Logement(Id_logement)
	,CONSTRAINT Commenter_Commentaire0_FK FOREIGN KEY (Id_commentaire) REFERENCES Commentaire(Id_commentaire)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Proposer
#------------------------------------------------------------

CREATE TABLE Proposer(
        Id_logement         Int NOT NULL ,
        Id_activite      Int NOT NULL ,
        Distance Int NOT NULL
	,CONSTRAINT Proposer_PK PRIMARY KEY (Id_logement,Id_activite)

	,CONSTRAINT Proposer_Logement_FK FOREIGN KEY (Id_logement) REFERENCES Logement(Id_logement)
	,CONSTRAINT Proposer_Activite_FK FOREIGN KEY (Id_activite) REFERENCES Activite(Id_activite)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Payer
#------------------------------------------------------------

CREATE TABLE Payer(
        Id_paiement         Int NOT NULL ,
        Id_utilisateur      Int NOT NULL ,
        DatePaiement Date NOT NULL
	,CONSTRAINT Proposer_PK PRIMARY KEY (Id_paiement,Id_utilisateur)

	,CONSTRAINT Payer_Logement_FK FOREIGN KEY (Id_paiement) REFERENCES Type_Paiement(Id_paiement)
	,CONSTRAINT Payer_Utilisateur_FK FOREIGN KEY (Id_utilisateur) REFERENCES Utilisateur(Id_utilisateur)
)ENGINE=InnoDB;
