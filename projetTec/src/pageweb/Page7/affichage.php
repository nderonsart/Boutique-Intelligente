<!"réalisé par Liam Mayeux , Nicolas Deronsart et Victor Tancrez">

<!"// permet l'affichage des graphiques des données ( en utilisant plotly.js) du jour indiqué">


<?php 
    ini_set('display_errors', TRUE);
    error_reporting(E_ALL);

    if(isset($_POST["accueil"])){
        header('Location: ../Page1/Accueil.php');// redirection vers la page d'accueil, correspond au bouton
      }

    if(isset($_POST["date"])){
        $date=$_POST["date"];
        $output=shell_exec("curl -X GET \"localhost:9200/shopdailydata/_search?q=$date\""); // on recupère le fichier json à l'indice shopdailydata de la date indiqué
        $array=json_decode($output,true);}
?>
<html>
<head>

  <!-- Plotly.js -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

  <style>
        .myDiv {
          height: 300px;
          width: 700px;
        }

        .temperature{
          height: 300px;
          width: 700px;
          margin-left:1000px;
          margin-top:-300px;
        }

        .frequentation{
          height: 300px;
          width: 700px;
          margin-top:-300px;
        }

        .hommefemme{
          height: 300px;
          width: 700px;
          margin-left:1000px;
          margin-top:100px;
        }

  </style>
</head>
  <body>
      <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <td>indiqué la date : mm-dd-YY:</td>
        <td><input type="text" name="date" value=""></td>
      </form>
      <div class="myDiv" id="myDiv"></div>

      <div class="temperature" id="temperature"></div>

      <div class="hommefemme" id="hommefemme"></div>
      <div class="frequentation" id="frequentation"></div>







  <script>
      var trace1 = {

                      x: [7,8, 9, 10,11, 12, 13, 14, 15, 16,17,18],

                      y: [<?php echo $array["hits"]["hits"][0]["_source"]["7"]["turnover"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["8"]["turnover"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["9"]["turnover"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["10"]["turnover"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["11"]["turnover"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["12"]["turnover"]; ?>, 
                          <?php echo $array["hits"]["hits"][0]["_source"]["13"]["turnover"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["14"]["turnover"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["15"]["turnover"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["16"]["turnover"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["17"]["turnover"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["18"]["turnover"]; ?>],
                      name: 'Name of Trace 1',

                      type: 'scatter'

                      };


      var data = [trace1];

      var layout = {

                        title: {

                          text:'Evolution du chiffre d\'affaire de la journée du <?php echo $date;?> ',

                          font: {

                            family: 'Courier New, monospace',

                            size: 16

                          },

                          xref: 'paper',

                          x: 0.05,

                        },

                        xaxis: {

                          title: {

                            text: 'Heure',

                            font: {

                              family: 'Courier New, monospace',

                              size: 14,

                              color: '#7f7f7f'

                            }

                          },

                        },

                          yaxis: {

                            title: {

                              text: 'chiffre d\'affaire',

                              font: {

                                family: 'Courier New, monospace',

                                size: 14,

                                color: '#7f7f7f'

                              }

                            }

                          }

                          };


      // temperature
      var trace2 = {

                    x: [7,8, 9, 10,11, 12, 13, 14, 15, 16,17,18],

                    y: [<?php echo $array["hits"]["hits"][0]["_source"]["7"]["temperature"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["8"]["temperature"]; ?>,
                        <?php echo $array["hits"]["hits"][0]["_source"]["9"]["temperature"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["10"]["temperature"]; ?>,
                        <?php echo $array["hits"]["hits"][0]["_source"]["11"]["temperature"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["12"]["temperature"]; ?>, 
                        <?php echo $array["hits"]["hits"][0]["_source"]["13"]["temperature"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["14"]["temperature"]; ?>,
                        <?php echo $array["hits"]["hits"][0]["_source"]["15"]["temperature"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["16"]["temperature"]; ?>,
                        <?php echo $array["hits"]["hits"][0]["_source"]["17"]["temperature"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["18"]["temperature"]; ?>],
                    name: 'Name of Trace 1',

                    type: 'scatter'

                    };


                    var data2 = [trace2];

                    var layout2 = {

                    title: {

                      text:'Evolution du chiffre de la température intérieure',

                      font: {

                        family: 'Courier New, monospace',

                        size: 16

                      },

                      xref: 'paper',

                      x: 0.05,

                    },

                    xaxis: {

                      title: {

                        text: 'Heure',

                        font: {

                          family: 'Courier New, monospace',

                          size: 14,

                          color: '#7f7f7f'

                        }

                      },

                    },

                    yaxis: {

                      title: {

                        text: 'température(degré)',

                        font: {

                          family: 'Courier New, monospace',

                          size: 14,

                          color: '#7f7f7f'

                        }

                      }

                    }

                    };



      // frequentation
      var trace3 = {

                      x: [7,8, 9, 10,11, 12, 13, 14, 15, 16,17,18],

                      y: [<?php echo $array["hits"]["hits"][0]["_source"]["7"]["numberCustomers"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["8"]["numberCustomers"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["9"]["numberCustomers"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["10"]["numberCustomers"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["11"]["numberCustomers"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["12"]["numberCustomers"]; ?>, 
                          <?php echo $array["hits"]["hits"][0]["_source"]["13"]["numberCustomers"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["14"]["numberCustomers"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["15"]["numberCustomers"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["16"]["numberCustomers"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["17"]["numberCustomers"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["18"]["numberCustomers"]; ?>],
                      name: 'Name of Trace 1',

                      type: 'scatter'

                      };


                      var data3 = [trace3];

                      var layout3 = {

                      title: {

                        text:'Evolution du nombre de clients',

                        font: {

                          family: 'Courier New, monospace',

                          size: 16

                        },

                        xref: 'paper',

                        x: 0.05,

                      },

                      xaxis: {

                        title: {

                          text: 'Heure',

                          font: {

                            family: 'Courier New, monospace',

                            size: 14,

                            color: '#7f7f7f'

                          }

                        },

                      },

                      yaxis: {

                        title: {

                          text: 'nombre de clients',

                          font: {

                            family: 'Courier New, monospace',

                            size: 14,

                            color: '#7f7f7f'

                          }

                        }

                      }

                      };

                      var trace4 = {

                        x: [7,8, 9, 10,11, 12, 13, 14, 15, 16,17,18],

                      y: [<?php echo $array["hits"]["hits"][0]["_source"]["7"]["numberMen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["8"]["numberMen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["9"]["numberMen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["10"]["numberMen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["11"]["numberMen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["12"]["numberMen"]; ?>, 
                          <?php echo $array["hits"]["hits"][0]["_source"]["13"]["numberMen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["14"]["numberMen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["15"]["numberMen"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["16"]["numberMen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["17"]["numberMen"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["18"]["numberMen"]; ?>],
                      name: 'homme',
                      type: 'scatter'

                      };


                      var trace5 = {

                        x: [7,8, 9, 10,11, 12, 13, 14, 15, 16,17,18],

                      y: [<?php echo $array["hits"]["hits"][0]["_source"]["7"]["numberWomen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["8"]["numberWomen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["9"]["numberWomen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["10"]["numberWomen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["11"]["numberWomen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["12"]["numberWomen"]; ?>, 
                          <?php echo $array["hits"]["hits"][0]["_source"]["13"]["numberWomen"]; ?>, <?php echo $array["hits"]["hits"][0]["_source"]["14"]["numberWomen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["15"]["numberWomen"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["16"]["numberWomen"]; ?>,
                          <?php echo $array["hits"]["hits"][0]["_source"]["17"]["numberWomen"]; ?>,<?php echo $array["hits"]["hits"][0]["_source"]["18"]["numberWomen"]; ?>],
                      name: 'femme',
                      type: 'scatter'

                      };
                      var layout4 = {

                      title: {

                        text:'Evolution du nombre de clients homme et femme dans la journée',

                        font: {

                          family: 'Courier New, monospace',

                          size: 16

                        },

                        xref: 'paper',

                        x: 0.05,

                      },

                      xaxis: {

                        title: {

                          text: 'Heure',

                          font: {

                            family: 'Courier New, monospace',

                            size: 14,

                            color: '#7f7f7f'

                          }

                        },

                      },

                      yaxis: {

                        title: {

                          text: 'nombre de client homme/femme au cours de la journée',

                          font: {

                            family: 'Courier New, monospace',

                            size: 14,

                            color: '#7f7f7f'

                          }

                        }

                      }
                      }
      var data4 = [trace4, trace5];

      Plotly.newPlot('myDiv', data);
      Plotly.newPlot('myDiv', data, layout);
      Plotly.newPlot('temperature', data2, layout2);
      Plotly.newPlot('frequentation',data3 ,layout3 );
      Plotly.newPlot('hommefemme',data4 ,layout4 );
  </script>

  <form action= "<?php echo $_SERVER["PHP_SELF"]?>" method="post">
          <button id="b2" type="submit" value="ENVOI" name="accueil">retourner à la page d'accueil </button>
  </form>
</body>
</html>


