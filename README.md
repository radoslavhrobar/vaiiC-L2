# Semestrálna práca VAII 2024/2025

Tento projekt predstavuje moju semestrálnu prácu z predmetu VAII (vývoj aplikácií pre internet a intranet).
Aplikácia je určená na prehľad a hodnotenie diel (filmových a literárnych).

# Návod na lokálne spustenie

Na spustenie webovej aplikácie je potrebený mať Docker (napríklad Docker Desktop) a vývojové prostredie pre jazyk PHP (napríklad PhpStorm).

## Krok 1: Klonovanie repozitára

Napríklad pomocou príkazu git clone github.com/radoslavhrobar/vaiiC-L2

## Krok 2: Spustenie kontajnerov

1. Zapnutie Dockeru.
2. Otvorenie a spustenie súboru docker-compose.yml.
3. Po úspešnom spustení by sa mali v Dockery v sekcii Containers objaviť nasledovné položky:
adminer - spravovanie databázy
mariadb - databáza
thevajko/vaii-web-server:main - stránka

