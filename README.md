# Refaktorizacija register PHP skripte

## Tehnologije
- Docker
- PHP 8.1
- nginx
- MySQL

## Instrukcije
- kreirati .env na osnovu .env.example
- kreirati tabele u MySQL-u sa *./sql/ddl.sql*
- pokrenuti docker sa `docker compose up --build` u *./docker* direktorijumu
- instaliranje zavisnosti pokretanjem `composer install` iz **refactor-app** kontejnera u *root* direktorijumu
- pristup preko <localhost:8000>

## Napomene o rešenju

- funkcionalnost refaktorisane skripte se nalazi na POST */register* (RegisterController, register metoda)
- mail-ovi se čuvaju u bazi kao neposlati (status QUEUED), i šalju se skriptom `./scripts/send_mails.php`

## Dodatni zahtevi

### MaxMind
- Interfejs *App\Contracts\Services\\* **FraudDetectionServiceInterface**
- Mock implementacija *App\Services\ThirdParty\\* **MaxMindFraudDetectionServiceMock**
- Integrisan u *App\Validation\Validators\\* **UserRegistrationValidator** kao Rule-ovi **IpFraudDetectionRule** i **EmailFraudDetectionRule**

### Prosleđivanje SQL izraza pri select, insert i update
- U query building sistemu, parametri se prosleđuju kao **QueryParamInterface**
- Implementacija *App\Query\\* **Param** podržava `Param::raw(string)` koja će pri build-ovanju query-ja biti umetnuta kao "raw" string vrednost.
- Na primer:
```php
// app/Repositories/UserLogRepository.php
 
 $insert = $this->queryBuilderFactory
     ->createInsertQuery(
     "user_log",
     ["action", "user_id", "log_time"],
 );

 $insert->values(
     [Param::bind($action), Param::bind($userId), Param::raw("NOW()")],
 );
```