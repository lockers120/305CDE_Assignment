DROP DATABASE  IF EXISTS 305CDE;

CREATE DATABASE 305CDE;
USE 305CDE;

CREATE TABLE Member (
    username varchar(25) NOT NULL,
    password varchar(25) NOT NULL,
    email varchar(255) NOT NULL,
    type varchar(6) NOT NULL,
    CONSTRAINT member_pk PRIMARY KEY (username)
);

CREATE TABLE Drug (
    drugname varchar(255) NOT NULL,
    type varchar(255) NOT NULL,
    description varchar(60000),
    CONSTRAINT drug_pk PRIMARY KEY (drugname)
);

CREATE TABLE Favourite (
    username varchar(25) NOT NULL,
    drugname varchar(255) NOT NULL,
    CONSTRAINT favourite_pk PRIMARY KEY (username, drugname),
    CONSTRAINT favourite_fk1 FOREIGN KEY (username) REFERENCES Member(username),
    CONSTRAINT favourite_fk2 FOREIGN KEY (drugname) REFERENCES Drug(drugname)
);

CREATE TABLE Comment (
    cmid int NOT NULL auto_increment,
    username varchar(25) NOT NULL,
    drugname varchar(255) NOT NULL,
    comment varchar(128) NOT NULL,
    timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT comment_pk PRIMARY KEY (cmid),
    CONSTRAINT comment_fk1 FOREIGN KEY (username) REFERENCES Member(username),
    CONSTRAINT comment_fk2 FOREIGN KEY (drugname) REFERENCES Drug(drugname)
);


INSERT INTO Member VALUES ('alex', 'alex', 'alex@alex.com', 'admin');

INSERT INTO Drug VALUES ('Alcohol', 'Drinking',"Alcohol can be an addictive substance. Not everyone who consumes alcohol will become addicted. However, certain people may be more susceptible to addiction.
<br>
It should be noted that alcohol addiction and abuse are not the same. It's important to understand the facts on alcohol abuse. Alcohol addiction refers to a psychological and physical dependency on alcohol. Individuals who suffer from alcohol addiction may build up a tolerance to the substance, as well as continue drinking even when alcohol-related problems become evident.
<br>
Alcohol abusers are not necessarily addicted to alcohol. Abusers are typically heavy drinkers who continue drinking regardless of the results. Abusers of alcohol may not drink on a consistent basis. For example, an individual who abuses alcohol may only drink once a week. However, when that individual drinks, he puts himself into risky situations or drinks enough to cause problems, such as alcohol poisoning. Certain individuals who abuse alcohol may eventually become dependent on it." );

INSERT INTO Drug VALUES ('Cocaine', 'Drug', 'Cocaine is a stimulant drug and is very addictive. The three routes of administration for cocaine are snorting, injecting, and smoking. It stimulates the brain by releasing dopamine, which causes the user to feel pleasure');

INSERT INTO Drug VALUES ('Heroin', 'Pain Killer', 'Heroin is an addictive recreational drug known to induce feelings of intense relaxation and euphoria. It is an opioid derived from morphine, which is derived from the opium poppy. Heroin can be injected, smoked, snorted, or taken orally');

INSERT INTO Drug VALUES ('LSD', 'Psychedelic drug', 'A hallucinogen manufactured from lysergic acid, which is found in ergot, a fungus that grows on rye and other grains. LSD is an abbreviation of the scientific name "Lysergic acid diethylamide." ');

INSERT INTO Drug VALUES ('Methamphetamine', 'Stimulant', 'Methamphetamine is a stimulant that is highly addictive and has a high potential for widespread abuse. This drug affects the central nervous system and is also referred to as speed, ice, crank, meth and crystal. ');