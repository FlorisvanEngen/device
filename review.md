### Review 1 20-7-2022

1. Style - Notificatie gaat niet weg
2. Use - Gebruikers hoeven niet in te login
3. Bug - Double click login error
4. Use - In het CMS, na login redirect gelijk naar de Devices
5. Style - Ik zie 3 nav style (Home, Login en Register), elke ziet anders
6. Use - Ik wil 3 tabs zien, elke tab laat zien een categorie, na refresh (gebruikers pagina, cms hoeft niet) (camera
   default)
7. Use - Ik wil op een device TR kan klikken (CMS en Users page)
8. Tip - Doe maar de pages inhoud en een path pages -> view/pages
9. Tip - bijbehorende component van een pagina binnen het map van deze pagina
10. Bug - ik kan de pdf niet opennen
11. Bug - ik kan photos ook niet opennen.
12. Bug - datum onder klopt niet, wij zijn in 2022
13. Tip (belangrijk) - JS en CSS moeten in resources zijn, worden gekopieerd naar npm run
14. Tip - Create a device - order verplicht, ok, dan default vul met max order
15. Bug - Delete a device - Double click delete krijg ik error
16. Use - Update device - Na klik op de Update device niet terug naar de lijst
17. Tip - voor create en update gebruik maar autocomplete OFF
18. Bug - na upload van pdf en foto's naam kwijt, originele name mag niet weg
19. Bug - bij delete device pdf en foto's niet verwijderd uit de folder
20. Bug - Lijst - Created at tijd klopt niet
21. Bug - In logs laat veel bugs zien (Aanmaken van data)

### Review 2 26-7-2022
**script**
1. Groupeer maar de routes, dat kun je zo doen Route::group(['middleware' => 'auth'], function () {});
2. Advies- De route DeviceController heb je alles voor gebruikt, hier beter Route::resources te gebruiken, lees maar hier https://laravel.com/docs/9.x/controllers#actions-handled-by-resource-controller
3. Je heeft 2 controller voor pdfs en photos, beide zijn file, er is geen verschil tussen pdf en image anders dan andere type.
   Je kan een gebruiken, bijv. FileController, MediaController.

**Views**
1. Wanneer komt een naam of beschrijving, gebruik maar {!! ipv {{, lees meer https://laravel.com/docs/master/blade#displaying-unescaped-data
2. Advies - in form actions gebruik maar {{route('route naam', $var)}} ipv static urls, in lange urls met veel data, variables wordt handiger
3. != null  is hetzelfde als zonder, bijv. if($device->pdf_path != null) is precies gelijk aan if($device->pdf_path) :)
4. if(count($photos) > 0) is ook gelijk aan if(count($photos)) en gelijk aan if($photos) ;-)
5. In change order file (views\pages\devices\order\index) heb je <script> boven en daar heb je php loop in js. Eerste script moet helemaal onder, eind van file, tweede don't mix talen met elkaar, ook als deze manier lijkt op te werken
