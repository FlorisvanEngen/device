# Device

Floris van Engen <br/>
18-07-2022

## Git via een terminal
### Clone

Een repository kan geclonned worden door de volgende stappen uit te voeren:

1. Ga naar de repository op [GitHub.com](https://github.com/FlorisvanEngen/device) en klik op de groene knop "Code".
2. Kopieër de HTTPS link. Zie hieronder voor een voorbeeld.

![Clone voorbeeld](/readme/git-clone.PNG)

3. Open een terminal en ga naar een map waar de repository naar geclonned kan worden.
4. Voor de onderstaande commondo uit in de terminal. Verander de {URL} met de url dat in stap 2 is gekoppieërd.

```text
$ git clone {URL}
```

Nu heb is een clone gemaakt van de repository.

### Commit

De wijzigingen dat wordt gemaakt kan worden gecommit door de volgende stappen uit te voeren:

1. Voor de onderstaande commando's uit om alle wijzigingen klaar te zetten om te kunnen commiten. Hierdoor word alle
   wijzigingen klaar gezet.

```text
$ git stage -A
```

2. Voor de onderstaande commando uit om de commit aan te maken. Verander de {Message} met het bericht voor de commit.

```text
$ git commit -m '{Message}'
```

Nu is een commit aangemaakt met de huidige wijzigingen.

### Pull

De wijzigingen kan opgehaald worden door de volgende stappen uit te voeren:

1. Zorg dat alle huidige wijzigingen zijn gecommit. (Zie Commit)
2. Voer onderstaande commando uit om de wijzigingen van de repository op te halen.

```text
$ git pull
```

Nu zijn alle nieuwe wijzigingen opgehaald.

### Push

De gemaakte wijzigingen kan naar de repository verstuurd worden door de volgende stappen uit te voeren:

1. Zorg dat alle huidige wijzigingen zijn gecommit. (zie Commit)
2. Zorg dat alle wijzigingen van de reposiory zijn opgehaald. (Zie Pull)
3. Voer de volgende commando uit om de gemaakte wijzigingen te naar de repository te sturen.

```textmate
$ git push 
```

Nu zijn alle gemaakte wijzigingen verstuurd naar de repository. 
