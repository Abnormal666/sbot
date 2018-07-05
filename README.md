# sbot
Darmowy bot na Twój serwer TS

### CHANGELOG 1.5
W funkcji <b>BAN_LIST</b> zmieniono kolejność wyświetlanych banów, od teraz wyświetlają się od najnowszego do najstarszego.<br/>
W funkcji <b>ADMINS_ONLINE</b> naprawiono błąd dotyczący braku adminów online.<br/>
Dodano proste tworzenie kanału prywatnego po wejściu na odpowiedni kanał. (Funkcja CREATE_PRIVATE_CHANNEL)<br/>
Dodano funkcję <b>BANNER</b>, która odpowiada za generowanie interaktywnego banneru.<br/>
Dodano funkcję <b>WELCOME_MESSAGE</b> odpowiadająca za przywitanie użytkownika podczas jego wejścia na serwer. <br/>

### CHANGELOG 2.0
Poprawiono wydajność bota.<br/>
Dodano 2 nowe instancję.<br/>
Poprawiono wyświetlanie błędów.<br/>
W funckcji <b>POKE_ADMINS</b> dodano url klienta w poke dla admina.<br/>
Dodano funckję <b>GET_CLIENTS</b>, odpowiadająca za sczytywanie informacji do topek.<br/>
Dodano funckję <b>TOPS_SAVE_IN_CHANNEL</b>, która wstawia w opis kanału daną topkę.<br/>
Dodano funckję <b>BAD_NICKNAMES</b>, która ma za zadanie dopilnować aby użytkownicy nie posiadali niedozwolonego nicku.<br/>
Dodano funckję <b>AWAY_CLIENTS_LIST</b> odpowiadającą za wstawianie do opisu kanału listy użytkowników away,a  w nazwie ich ilość.<br/>
Dodano funckję <b>SERVERGROUPS_SECURITY</b> która ma za zadanie dopilnować aby użytkownik nie wpisany w configu nie posiadał danej grupy.<br/>
Dodano funckję <b>CLIENT_PERMISSIONS_SECURITY</b> odpowiadająca za usuwanie nie wpisanym użytkownikom w konfiguracji permisji.<br/>
Dodano funckję <b>WEATHER_IN_CHANNEL</b> która w opisie kanału wpisuje pogodę z danego miasta<br/>
Dodano funckje <b>AWAY_MOVE</b> odpowiadająca za przenie na odpowiedni kanał gdy użytkownik jest away<br/>
Dodano funckje <b>AWAY_GROUP</b> odpowiadająca za nadanie grupę gdy użytkownik jest away<br/>
Dodano funckje <b>ADVERTISEMENT</b> ,która pisze co X czasu wiadomość na czacie globalnym<br/>
Dodano funckję <b>SAVE_TO_EVENT</b> odpowiadająca za zapisanie użytkownika w opisie gdy ten wejdzie na odpowiedni kanał<br/>
Dodano funckję <b>COUNTDOWN_TO_DATE</b> odpowiadającą za odliczanie do danej daty, a następnie wpisywanie wartości do nazwy kanału<br/>
Dodano funckję <b>GROUPS_LIMIT</b> służącą za dopilnowanie aby użytkownicy serwera nie posiadali więcej grup niż jest to ustawione w konfiguracji.<br/>
Dodano funckję <b>CREATE_VIP_CHANNEL</b> odpowiadająca za stworzenie użytkownikowi kanału VIP gdy ten wejdzie na odpowiedni kanał<br/>
Dodano funckję <b>GROUP_ONLINE</b> ,która działa na takiej samej zasadzie co funckja ONLINE_FROM_GROUP tyle że informacje o grupie o kanale pobiera z bazy danych<br/>
Dodano funckję <b>CHANNEL_GROUP</b> ,która działa na takiej samej zasadzie co funckja CHANNEL_ADD_GROUP tyle że informacje o grupie o kanale pobiera z bazy danych<br/>
Dodano funckję <b>QUERY_CHANNEL_LIST</b> ,która ma za zadanie wpisywać w nazwę ilość klientów query, a w opis ich li<br/>stę<br/>
Dodano funckcję <b>CLIENT_LEVELS</b> odpowiadającą za nadanie użytkownikowi poziomu za jego spędzony czas. 
