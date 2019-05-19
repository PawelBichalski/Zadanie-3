API
====================

Utwórz dwa endpointy REST API:

a) POST /users - dodanie nowego użytkownika
b) GET /users - lista wszystkich użytkowników

Api powinno akceptować i zwracać dane w formacie JSON

### Informacje
Użytkownik powinien zawierać następujące dane:
- firstname 
- surname
- identification number PESEL 

### Wymagania
1. Wszystkie dane przy użytkowniku powinny być wymagane
2. Przy dodawaniu nowego użytkownika powinna nastąpić weryfikacja numeru PESEL (długość, suma kontrolna)
3. Błędy walidacji powinny być zwracane w następującym formacie:

````
{
    "code": 422,
    "message": "Validation Failed";
    "errors": {
        „identificationNumber": "Invalid value for identificationNumber."
    }
}
````
4. Dane powinny być persystowane do bazy dowolnego typu

### Zasady
1. Do wykonania zadania możesz użyć frameworka Symfony oraz bibliotek z packagist.org
2. Jeśli coś nie jest sprecyzowane, wykonaj to według własnego pomysłu




