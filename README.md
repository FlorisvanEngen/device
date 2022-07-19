# Device

Floris van Engen - 18-07-2022

## De applicatie lokaal kunnen laten draaien

### Benodigde software

Om de applicatie lokaal te kunnen draaien moet de volgende software geïnstalleerd zijn:

- Een browser
- Git-gui
- XAMPP

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

3. Voer de commando "npm install" uit.

```text
npm install
```

4. Maak een kopie van de .env.example genaamd .env door de volgende commando uit te voeren.

```text
cp .env.example .env
```

5. Configureer de db instellingen, App_key en pas de instelling filesystem_disk aan naar public. Dit kan via de volgende
   commando. (Als er geen bestaande App_key beschikbaar is kan deze worden aangemaakt in stap 8)

```text
nano .env
```

6. Open XAMPP en start de module's apache en mysql.
7. Ga naar [phpMyAdmin](http://localhost/phpmyadmin/index.php) en maak een database aan met de naam dat in stap 5 is
   geconfigureerd. [^1]
8. Als de App_key in stap 5 is ingesteld kan deze stap worden overgeslagen. Voer de commando "php artisan key:generate"
   uit om een nieuw App_key aan te maken. [^2]

```text
php artisan key:generate
```

9. Voer de commando "php artisan migrate:fresh --seed" uit. Hiermee word de database tabellen aangemaakt en voorzien van
   dummy data.

```text
php artisan migrate:fresh --seed
```

10. Voer de commando "php artisan storage:link" uit. Hiermee word een snelkoppeling gemaakt van de public map naar de
    storage map. Hierdoor zijn de files in de storage map op de website beschikbaar.

```text
php artisan storage:link
```

11. Start de applicatie op door de commando "php artisan serve" uit te voeren. De url van de applicatie staat in de
    Git Bash terminal.

```text
php artisan serve
```

Nu is de applicatie gestart om lokaal te kunnen gebruiken.

### Bestaande applicatie lokaal draaien

Als de applicatie al op de computer staat kan de volgende stappen uitgevoerd worden:

1. Open XAMPP en start de module mysql.
2. Open Git Bash en ga naar de hoofdmap van de applicatie.
3. Start de applicatie op door de commando "php artisan serve" uit te voeren. De url van de applicatie staat in de
   Git Bash terminal.

```text
php artisan serve
```

[^1]: PhpMyAdmin is geïnstalleerd via XAMPP.

[^2]: De App_key sleutel mag alleen aangemaakt worden bij nieuwe applicaties of bij applicaties dat niet met andere
databases samenwerkt. Deze sleutel word namelijk gebruikt om de database gegevens te kunnen ver- en ontsleutelen.
