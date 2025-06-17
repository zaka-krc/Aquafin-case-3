# Aquafin Materiaal Beheer Systeem

## 📋 Overzicht

Het Aquafin Materiaal Beheer Systeem is een webapplicatie ontwikkeld voor het efficiënt beheren en bestellen van materialen door onderhoudstechniekers. Het systeem zorgt ervoor dat techniekers dagelijks de juiste materialen, gereedschappen en beschermingsmiddelen kunnen bestellen voor hun werkzaamheden aan zwembaden en rioleringssystemen.

## 🛠️ Installatie

Volg deze stappen om het project lokaal te installeren:

1. **Zorg dat je [Composer](https://getcomposer.org/) en [Node.js](https://nodejs.org/) hebt geïnstalleerd.**
2. **Download of kopieer dit project naar je computer.**
3. **Open een terminal in de projectmap.**

4. **Installeer de PHP- en JavaScript-afhankelijkheden:**
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   php artisan serve
   ```



## 🎯 Hoofdfunctionaliteiten

### Voor Techniekers (Gebruikers)

#### 1. **Materialen Bekijken**
- Blader door 150+ verschillende materialen in 6 categorieën
- Zoek specifieke materialen via de zoekbalk
- Filter op categorie of voorraadstatus
- Bekijk real-time voorraadinformatie

#### 2. **Bestellingen Plaatsen**
- Voeg materialen toe aan je winkelwagen
- Kies gewenste leverdatum (minimaal 1 dag vooruit)
- Selecteer leverlocatie (hoofdvestiging, werkplaats, projectlocatie, etc.)
- Voeg opmerkingen toe voor speciale instructies

#### 3. **Bestellingen Volgen**
- Bekijk al je geplaatste bestellingen
- Volg de status van elke bestelling
- Zie wanneer materialen geleverd worden

### Voor Beheerders (Admins)

#### 1. **Materiaal Beheer**
- Voeg nieuwe materialen toe aan het systeem
- Verwijder verouderde materialen
- Pas materiaalinformatie aan (prijs, leverancier, etc.)
- Beheer voorraadniveaus

#### 2. **Order Management**
- Bekijk alle inkomende bestellingen
- Keur bestellingen goed of wijs af
- Volg de voortgang van bestellingen
- Voorraad wordt automatisch verminderd bij goedkeuring

#### 3. **Dashboard Overzicht**
- Zie statistieken over materialen en bestellingen
- Ontvang waarschuwingen voor lage voorraad
- Monitor materialen die niet op voorraad zijn

## 📂 Materiaal Categorieën

Het systeem organiseert materialen in 6 hoofdcategorieën:

1. **🧰 Bevestigingsmateriaal**
2. **👷‍♂️ Persoonlijke Beschermingsmiddelen (PBM)**
3. **🔧 Gereedschap**
4. **⚙️ Technische Onderhoudsmaterialen**
5. **🛠️ Specifieke Aquafin/Riolering Tools**
6. **📦 Diversen/Verbruiksgoederen**

## 🔄 Bestelproces Workflow

### 1. **Bestelling Plaatsen** (Technieker)
- Selecteer benodigde materialen
- Controleer beschikbaarheid
- Plaats bestelling met gewenste leverdatum

### 2. **In Afwachting** 🟡
- Bestelling wacht op goedkeuring van magazijnbeheerder

### 3. **Goedgekeurd** 🔵 (Admin)
- Admin controleert voorraad en keurt goed
- Voorraad wordt automatisch verminderd

### 4. **In Verwerking** 🟣
- Magazijn bereidt bestelling voor

### 5. **Geleverd** 🟢
- Materialen zijn afgeleverd op locatie

## 🚨 Voorraad Indicatoren

- **🟢 Op voorraad**: Voldoende materiaal beschikbaar
- **🟡 Lage voorraad**: Voorraad onder minimum niveau
- **🔴 Geen voorraad**: Materiaal tijdelijk niet beschikbaar

## 💡 Belangrijke Features

### Slimme Voorraadcontrole
- Automatische controle op beschikbaarheid
- Voorkomt overbestelling van materialen
- Real-time voorraad updates
- Waarschuwingen bij lage voorraad

### Flexibele Levering
- 6 verschillende leverlocaties:
  - 🏢 Hoofdvestiging
  - 🔧 Werkplaats
  - 📦 Magazijn
  - 🚧 Projectlocatie
  - 🚐 Servicewagen
  - 📍 Anders (zelf specificeren)

### Gebruiksvriendelijke Interface
- Intuïtieve navigatie
- Responsive design (werkt op alle apparaten)
- Snelle zoekfunctie
- Overzichtelijke categorieën

## 📱 Gebruikstips

### Voor Techniekers:
1. **Check voorraad** - Controleer altijd de beschikbaarheid voor het bestellen
2. **Plan vooruit** - Bestel ruim op tijd voor geplande werkzaamheden
3. **Gebruik filters** - Vind snel wat je zoekt met categorie- en voorraadfilters
4. **Wees specifiek** - Voeg duidelijke instructies toe in het opmerkingenveld
5. **Controleer leverdatum** - Zorg dat materialen op tijd geleverd worden

### Voor Admins:
1. **Dagelijkse controle** - Check nieuwe bestellingen elke werkdag
2. **Voorraad monitoring** - Houd lage voorraad items in de gaten
3. **Snelle goedkeuring** - Verwerk spoedbestellingen met prioriteit
4. **Data onderhoud** - Update regelmatig prijzen en leveranciersinformatie
5. **Dashboard gebruik** - Gebruik het dashboard voor totaaloverzicht

## 🔐 Toegangsniveaus

### Gebruiker (Technieker)
- Materialen bekijken
- Bestellingen plaatsen
- Eigen bestellingen inzien

### Administrator
- Alle gebruikersfuncties
- Materiaal toevoegen/wijzigen/verwijderen
- Bestellingen goedkeuren/afwijzen
- Voorraad beheren
- Systeem statistieken inzien (wat betreft de voorraad)



## 🚀 Aan de Slag

1. **Inloggen** - Gebruik je toegewezen gebruikersnaam en wachtwoord
2. **Dashboard** - Start vanaf het hoofddashboard
3. **Materialen bekijken** - Ga naar "Bekijk Voorraad"
4. **Bestellen** - Voeg items toe aan winkelwagen en rond bestelling af
5. **Volgen** - Check status onder "Mijn Bestellingen"


## 👥 Takenverdeling

Hieronder vind je een overzicht van wie verantwoordelijk is voor welke onderdelen van het project:

| Taak                        | Verantwoordelijke(n)         |
|-----------------------------|------------------------------|
| Backend ontwikkeling        | Zakaria Korchi (code), Anas Chakkour (concept) |
| Frontend ontwikkeling       | Zakaria Korchi, Ludger De Sousa Lima (CSS & afbeeldingenbeheer) |
| Database ontwerp & beheer   | Zakaria Korchi |
| Materiaalbeheer (inhoud)    | Aquafin, Erasmushogschool |
| Testen & kwaliteitscontrole | Zakaria Korchi            |
| Documentatie                | Zakaria Korchi |
| Support & onderhoud         | Anas Chakkour, Ludger De Sousa Lima, Sabri Merroun, Zakaria Korchi, Soufiane Abakkiou |

## 📚 Gebruikte Bronnen

- **Lessen Back End Webontwikkeling (Erasmushogeschool Brussel)**
  - Slides en cursusmateriaal van de opleiding
  - Voorbeelden en opdrachten uit de lessen

- **Eindproject Laravel**
  - Projectopdracht en richtlijnen van de opleiding
  - Feedback en tips van docenten

- **Laravel Documentatie**
  - [Laravel officiële documentatie](https://laravel.com/docs)
  - [Laravel Eloquent ORM](https://laravel.com/docs/eloquent)
  - [Laravel Blade Templates](https://laravel.com/docs/blade)
  - [Laravel Routing](https://laravel.com/docs/routing)
  - [Laravel Migrations & Seeders](https://laravel.com/docs/migrations)

- **Overige Documentatie en Hulpmiddelen**
  - [PHP officiële documentatie](https://www.php.net/docs.php)
  - [Composer documentatie](https://getcomposer.org/doc/)
  - [Node.js documentatie](https://nodejs.org/en/docs/)
  - [NPM documentatie](https://docs.npmjs.com/)
  - [MySQL documentatie](https://dev.mysql.com/doc/)
  - [VS Code gebruikersgids](https://code.visualstudio.com/docs)
  - [GitHub Copilot](https://github.com/features/copilot) voor AI-ondersteunde codesuggesties en ontwikkelingshulp
  - Stack Overflow en andere online fora voor specifieke problemen

---


