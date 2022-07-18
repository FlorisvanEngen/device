# Device

Floris van Engen <br/>
18-07-2022

## De applicatie kunnen laten draaien

### Benodigde software

Om de applicatie lokaal te kunnen draaien moet de volgende software geïnstalleerd zijn:

- Een browser
- Git-gui
- XAMPP

### Lokaal draaien

De applicatie kan lokaal gebruikt worden door de volgende stappen uit te voeren:
1. Open Git Bash en clone de applicatie in de map "c/xampp/htdocs/device". Zie de hoofdstuk "Git - Clone".
2. Open XAMPP en start de MySQL module. Zie hieronder voor een voorbeeld.
   ![XAMPP](/readme/xampp.PNG)
3. Open Git Bash en ga naar de hoofdmap waar de applicatie staat.
4. Voer, in Git Bash, de volgende command.

```text
php artisan serve
```

![Git-bash](/readme/git-bash.PNG)

5. Open de browser en ga naar de url dat in Git-Bash staat. Zie hierboven voor een voorbeeld.

Nu is de applicatie gestart.

## Git

### Clone

Een repository kan geclonned worden door de volgende stappen uit te voeren:

1. Ga naar de repository op [GitHub.com](https://github.com/FlorisvanEngen/device) en klik op de groene knop "Code".
2. Kopieër de HTTPS link. Zie hieronder voor een voorbeeld.

![Clone voorbeeld](/readme/git-clone.PNG)

3. Open een terminal en ga naar een map waar de repository naar geclonned kan worden.
4. Voor de onderstaande commando uit in de terminal. Verander de {URL} met de url dat in stap 2 is gekoppieërd.

```text
git clone {URL}
```

Nu heb is een clone gemaakt van de repository.

### Commit

De wijzigingen dat wordt gemaakt kan worden gecommit door de volgende stappen uit te voeren:

1. Voor de onderstaande commando's uit om alle wijzigingen klaar te zetten om te kunnen commiten. Hierdoor word alle
   wijzigingen klaar gezet.

```text
git stage -A
```

2. Voor de onderstaande commando uit om de commit aan te maken. Verander de {Message} met het bericht voor de commit.

```text
git commit -m '{Message}'
```

Nu is een commit aangemaakt met de huidige wijzigingen.

### Pull

De wijzigingen kan opgehaald worden door de volgende stappen uit te voeren:

1. Zorg dat alle huidige wijzigingen zijn gecommit. (Zie Commit)
2. Voer onderstaande commando uit om de wijzigingen van de repository op te halen.

```text
git pull
```

Nu zijn alle nieuwe wijzigingen opgehaald.

### Push

De gemaakte wijzigingen kan naar de repository verstuurd worden door de volgende stappen uit te voeren:

1. Zorg dat alle huidige wijzigingen zijn gecommit. (zie Commit)
2. Zorg dat alle wijzigingen van de repository zijn opgehaald. (Zie Pull)
3. Voer de volgende commando uit om de gemaakte wijzigingen te naar de repository te sturen.

```text
git push 
```

Nu zijn alle gemaakte wijzigingen verstuurd naar de repository.

### Status

De status van de local repository kan weergegeven worden door de volgende commando uit te voeren:

```text
git status
```

### Cheat sheet

In deze [cheatsheet](/readme/git-cheatsheet.pdf) staan verschillende commando's met uitgelegd wat ze doen.
