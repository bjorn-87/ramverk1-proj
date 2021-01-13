---
views:
    kursrepo:
        region: sidebar-right
        template: anax/v2/block/default
        data:
            meta:
                type: single
                route: block/om-kursrepo

    redovisa:
        region: sidebar-right
        template: anax/v2/block/default
        data:
            meta:
                type: single
                route: block/om-redovisa
---
Om
=========================

Denna sida är skapad av Björn Olsson som ett projektarbete i Kursen DV1610 Webbaserade ramverk och designmönster.

Sidan är tänkt fungera som ett forum för frågor rörande spelkonsoller av alla dess slag.  
För att börja använda sidan måste man skapa en användare och logga in.
När detta är gjort så kan användaren ställa frågor och svara på/kommentera andra användares frågor.  
Frågor och svar kan kommenteras av alla inloggade användare men den inloggade användaren kan inte svara på sin egen fråga.

Alla frågor kan taggas och det finns en sida där man kan se alla taggar och söka på taggar.
Klickar man på en tagg så ser man alla frågor som finns på denna tagg samt vem som ställt frågan.  

[FIGURE src=image/console.jpg?w=300 caption="En klassisk spelkonsol."]
