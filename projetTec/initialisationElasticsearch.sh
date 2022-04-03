date=$(date +"%m-%d-%y")
heure=$(date +"%H")

output=$(curl -X GET "localhost:9200/shopdailydata/_search?q=$date")
if [[ $output =~ $date ]];
    then 
        echo " trouvé"

else 

    echo "
    {  \"date\" : \"$date\",
    
    \"7\":{
        \"temperature\": 10,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0
        },
    \"8\":{
        \"temperature\": 11,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"9\":{
        \"temperature\": 13,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" :0},
    \"10\":{
        \"temperature\": 14,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"11\":{
        \"temperature\": 14,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"12\":{
        \"temperature\": 13,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"13\":{
        \"temperature\": 15,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"14\":{
        \"temperature\": 16,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"15\":{
        \"temperature\": 16,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"16\":{
        \"temperature\": 15,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"17\":{
        \"temperature\": 14,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"18\":{
        \"temperature\": 12,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0},
    \"19\":{
        \"temperature\": 11,
        \"numberCustomers\": 0,
        \"numberMen\": 0,
        \"numberWomen\": 0,
        \"turnover\" : 0}

    }"> src/data/shopdailydatavide
  
    curl -XPOST http://localhost:9200/shopdailydata/_doc -H "Content-Type: application/json" -d '@src/data/shopdailydatavide'
fi

output=$(curl -X GET "localhost:9200/shop/current/_search?pretty")
echo $output
if [[ $output =~ "error" ]];
    then 
       echo "ok"
       curl -XPOST http://localhost:9200/shop/current/_doc -H "Content-Type: application/json" -d @src/data/shop.json


fi
