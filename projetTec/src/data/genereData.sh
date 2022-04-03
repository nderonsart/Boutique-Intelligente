#!/bin/bash


#genere la tempèrature du magasin en fonction de si le chauffage est allumé ou pas 
genereTemperature()
{ 
 date=$(date +"%m-%d-%y")
heure=$(date +"%H")
echo "{
    \"script\" : {
      \"source\":\"if(ctx._source.temperatureInside<40){ctx._source.temperatureInside+=1;}\",
      \"lang\": \"painless\"  
    },
    \"query\": {
        \"term\" : {
            \"heating.keyword\": \"on\"
        }
    }
}
"> changetemperature
#augmente la tempèrature du magasin de 1 degré
curl -XPOST "http://localhost:9200/shop/_update_by_query" -H 'Content-Type: application/json' -d @changetemperature


echo "{
    \"script\" : {
      \"source\": \"if(ctx._source.temperatureInside>ctx._source.temperatureOutside){ctx._source.temperatureInside-=1;}\",
      \"lang\": \"painless\"  
    },
    \"query\": {
        \"term\" : {
            \"heating.keyword\": \"off\"
        }
    }
}
"> changetemperature
#baisse la tempèrature du magasin de 1 degré
curl -XPOST "http://localhost:9200/shop/_update_by_query" -H 'Content-Type: application/json' -d @changetemperature
    timeout 120 ping 8.8.8.8
    $(genereTemperature)
}

echo $(genereTemperature)
