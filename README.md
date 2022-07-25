# Device

Floris van Engen - 18-07-2022

## De applicatie lokaal kunnen laten draaien

### Benodigde software

Om de applicatie lokaal te kunnen draaien moet de volgende software geïnstalleerd zijn:

- [Composer](https://getcomposer.org/download/)
- Een browser ([Chrome](https://www.google.com/intl/nl_nl/chrome/), [Firefox](https://www.mozilla.org/nl/firefox/new/),
  etc.)
- [Git-gui](https://git-scm.com/download/win)
- [XAMPP](https://www.apachefriends.org/)

### Eerste keer lokaal draaien

Als de applicatie nog niet lokaal op de computer staat kan de volgende stappen uitgevoerd worden:

1. Open Git Bash en clone de [applicatie](https://github.com/FlorisvanEngen/device) in de map "C:\xampp\htdocs".
2. Ga naar de map van de applicatie door de commando "cd device" uit te voeren.

```text
cd device
```

3. Voer de commando "composer install" uit.

```text
composer install
```

4. Voer de commando "npm install" uit.

```text
npm install
```

5. Maak een kopie van de .env.example file met de naam .env door de volgende commando uit te voeren.

```text
cp .env.example .env
```

6. Configureer de db instellingen en de App_key. Dit kan via de volgende commando. (Als er geen bestaande App_key
   beschikbaar is kan deze worden aangemaakt in stap 8)

```text
nano .env
```

7. Open XAMPP en start de module's apache en mysql.
8. Ga naar [phpMyAdmin](http://localhost/phpmyadmin/index.php) en maak een database aan met de naam dat in stap 5 is
   geconfigureerd. [^1]
9. Als de App_key in stap 5 is ingesteld kan deze stap worden overgeslagen. Voer de commando "php artisan key:generate"
   uit om een nieuwe App_key aan te maken. [^2]

```text
php artisan key:generate
```

10. Voer de commando "php artisan migrate:fresh --seed" uit. Hiermee word de database tabellen aangemaakt en voorzien
    van
    dummy data.

```text
php artisan migrate:fresh --seed
```

11. Voer de commando "php artisan storage:link" uit. Hiermee word een snelkoppeling gemaakt van de public map naar de
    storage map. Hierdoor zijn de files in de storage map op de website beschikbaar.

```text
php artisan storage:link
```

12. Start een andere git bash applicatie en voer de commando "npm run dev"[^3] uit. Dit zorgt ervoor dat de css en
    javascript code op de juiste manier word geladen. [^4]

```text
npm run dev
```

13. Start de applicatie op door de commando "php artisan serve" uit te voeren. De url van de applicatie staat in de
    Git Bash terminal. [^5]

```text
php artisan serve
```

Nu is de applicatie gestart om lokaal te kunnen gebruiken.

### Bestaande applicatie lokaal draaien

Als de applicatie al op de computer staat en heeft al een keer gedraaid, dan kan de volgende stappen uitgevoerd worden:

1. Open XAMPP en start de module mysql.
2. Open Git Bash en ga naar de hoofdmap van de applicatie.
3. Start de applicatie op door de commando "php artisan serve" uit te voeren. De url van de applicatie staat in de
   Git Bash terminal. [^5]

```text
php artisan serve
```

[^1]: PhpMyAdmin is geïnstalleerd via XAMPP.

[^2]: De App_key sleutel mag alleen aangemaakt worden bij nieuwe applicaties of bij applicaties dat niet met andere
databases samenwerkt. Deze sleutel word namelijk gebruikt om de database gegevens te kunnen ver- en ontsleutelen.

[^3]: Als de commando "npm run build" word gebruikt geeft de js code de error "ReferenceError: $ is not defined". Dit
komt doordat de jquery code door vite niet juist word geladen. Een oplossing hiervoor is om de commando "npm run dev"
uit te voeren (Zie note hieronder[^4]) of door de jquery code in de public map al op te slaan.

[^4]: Terwijl de commando "npm run dev" word uitgevoerd mag de Git Bash terminal niet gesloten worden. Dit zorgt er
namelijk voor dat de css en js code worden geladen.

[^5]: Om de applicatie te kunnen gebruiken mag de Git Bash terminal niet gesloten worden. De commando "php artisan
serve" moet ook uitgevoerd blijven worden. 
