# Användarfall

## Grundläggande krav
1. Systemet ska svara på användarens interaktion inom en rimlig tid.
2. Systemet ska vara användarvänligt.
  1. Systemet ska vara hjälpsam mot användare.
  2. Systemet ska erbjuda hjälpsamma felmeddelanden.
3. Systemet ska vara säkert. Ska vara skyddat mot:
  1. SQL-injections.
  2. Javascript injections.
  3. Session hijacking.

## A1 - Logga in
### Huvudscenario
1. Startar när användaren vill logga in.
2. Systemet frågar efter användarnamn, lösenord, och om systemet ska komma ihåg användaren.
3. Användaren skriver in sitt användarnamn och lösenord och trycker på logga in.
4. Systemet authentikerar användaren och presenterar att inloggningen lyckades.

### Alternativa scenarion
3a. Användaren vill att systemet ska komma ihåg en för en lättare inloggning.

1. Systemet authentikerar användaren och presenterar att inloggningen lyckades.

4a. Användaren kunde inte bli authentikerad.

1. Systemet presenterar ett felmeddelande.
2. Steg 2 i huvudscenariot.


## A2 - Logga ut en användare
### Förkrav
1. Användaren är inloggad. Ex. A1.

### Huvudscenario
1. Startar när användaren vill logga ut.
2. Systemet presenterar en logga ut knapp.
3. Användaren talar om för systemet att hen vill logga ut.
4. Systemet loggar ut användaren och presenterar att utloggningen lyckades.


## A3 - Inloggning av sparade inloggningsuppgifter
### Förkrav
A1. 3a. Användaren vill att systemet ska komma ihåg en för en lättare inloggning.

### Huvudscenario
1. Startar när användaren vill logga in med sparade inloggningsuppgifter.
2. Systemet loggar in användaren och presenterar att det hände med dom sparade inloggningsuppgifterna.

### Alternativa scenarion
2a. Användaren kunde inte bli authentikerad (för gamla inloggnignsuppgifter sparade > 30 dagar) (fel inloggnignsuppgifter), manipulerade inloggnignsuppgifter.

1. Systemet presenterar ett felmeddelande.
2. Steg 2 i A1.


## A4 - Användaren vill skapa en meme
### Förkrav
1. Användaren är inloggad. Ex. A1.

### Huvudscenario
1. Startar när användaren vill skapa en meme.
2. Systemet presenterar en sida där användaren kan fylla i text i meme:en och välja vilken bild hen vill använda.
3. Användaren fyller i text, väljer en bild, och trycker på spara.
4. Systemet genererar meme:en och presenterar den för användaren.

### Alternativa scenarion
3a. Användaren vill ladda upp en egen bild.

1. Systemet presenterar en "ladda upp bild"-knapp.
2. Användaren trycker på den och väljer en bild från sin lokala dator.
3. Systemet tar emot den och går vidare till steg 4 i huvudscenariot.


## A5 - Användaren vill dela en skapade meme
### Förkrav
1. Användaren är inloggad. Ex. A1.
2. Användaren har skapat en meme. Ex. A4.

### Huvudscenario
1. Startar när användaren vill dela en meme.
2. Systemet presenterar dela knappar till Facebook, Twitter, och möjligheten att ladda upp den på bildsidan Imgur.
3. Användaren väljer att dela den på Facebook.
4. Systemet presenterar Facebook's delaruta där användaren kan fylla i en text som följer med Facebook-delningen.
5. Systemet presenterar att delningen har lyckats.

### Alternativa scenarion
3a. Användaren väljer att ladda upp bilden till bildsidan Imgur.

1. Systemet laddar upp bilden på Imgur och presenterar en länk till bilden för användaren.


## A6 - Användaren vill se sina skapade meme:s
### Förkrav
1. Användaren är inloggad. Ex. A1.
2. Användaren har skapat en meme. Ex. A4.

### Huvudscenario
1. Startar när användaren vill se sina skapade meme:s.
2. Systemet presenterar en länk till en sida där användarens tidigare skapade meme:s finns sparade.
3. Användaren trycker på sagda länk och sidan presenteras för användaren.


## A7 - Användaren vill se ett galleri med skapade meme:s
### Förkrav
1. Användaren är inloggad. Ex. A1.
2. Någon användare eller den inloggade användaren har skapat en meme.

### Huvudscenario
1. Startar när användaren vill se ett galleri med skapade meme:s.
2. Systemet presenterar en länk till en sida där alla användares meme:s finns sparade.
3. Användaren trycker på sagda länk och sidan presenteras för användaren.


## A8 - Användaren vill rösta på en annans meme
### Förkrav
1. Användaren är inloggad. Ex. A1.
2. Någon användare eller den inloggade användaren har skapat en meme.
3. Användaren är på gallerisidan för meme:s. Ex. A7.

### Huvudscenario
1. Startar när användaren vill rösta på en meme.
2. Systemet presenterar en gilla-knapp och en ogilla-knapp brevid varje skapad meme.
3. Användaren trycker på antingen gilla eller ogilla.
4. Systemet registrerar knapptryckningen och presenterar ett meddelande till användaren att handlingen är slutförd.


## A9 - Användaren vill ta bort en skapad meme
### Förkrav
1. Användaren är inloggad. Ex. A1.
2. Användaren har skapat en meme. Ex. A4.
3. Användaren är inne på sidan med sina skapade meme:s. Ex. A6.

### Huvudscenario
1. Startar när användaren vill radera en meme.
2. Systemet presenterar en radera-knapp för användaren bredvid varje bild som användaren har skapat.
3. Användaren trycker på en av radera-knapparna.
4. Systemet tar bort bilden och presenterar ett meddelande att det har lyckats.
