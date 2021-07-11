const dataDunat = {
  labels: ['Score to go','My total feedback score' 
    
  ],
  datasets: [{
    label: 'Total feedback score',
    data: [25,75],
    backgroundColor: [
      'rgba(211,211,211)',
      'rgba(75, 192, 192)'
    ],
    hoverOffset: 4
  }]
};

const labels = ['Smooth Driving', 'Balance','Sudden breaks','Accelerations','Sharp Turns','Transitions'];
const dataBar = {
  labels: labels,
  datasets: [{
    label: 'My Score',
    data: [67, 33, 70, 58, 50, 55],
    backgroundColor: [
      'rgba(75, 192, 192, 0.5',
      'rgba(75, 192, 192, 0.5',
      'rgba(75, 192, 192, 0.5',
      'rgba(75, 192, 192, 0.5',
      'rgba(75, 192, 192, 0.5',
      'rgba(75, 192, 192, 0.5',
      'rgba(75, 192, 192, 0.5'
    ],
    borderColor: [
      'rgb(75, 192, 192)',
      'rgb(75, 192, 192)',
      'rgb(75, 192, 192)',
      'rgb(75, 192, 192)',
      'rgb(75, 192, 192)',
      'rgb(75, 192, 192)',
      'rgb(75, 192, 192)'
    ],
    borderWidth: 1
  },{
    label: 'Drivers Score',
    data: [80, 75, 74, 72, 60, 50],
    backgroundColor: [
      'rgba(211,211,211,0.8)',
      'rgba(211,211,211,0.8)',
      'rgba(211,211,211,0.8)',
      'rgba(211,211,211,0.8)',
      'rgba(211,211,211,0.8)',
      'rgba(211,211,211,0.8)',
      'rgba(211,211,211,0.8)'
    ],
    borderColor: [
      'rgb(136, 136, 136)',
      'rgb(136, 136, 136)',
      'rgb(136, 136, 136)',
      'rgb(136, 136, 136)',
      'rgb(136, 136, 136)',
      'rgb(136, 136, 136)',
      'rgb(136, 136, 136)'
    ],
    borderWidth: 1
  }]
};

const configBar = {
  type: 'bar',
  data: dataBar,
  options:{
    scales: {
        yAxes : [{
            ticks : {
                max : 100,    
                min : 0
            }
        }]
    }
}
};

window.onload = function() {
  var ctx = document.getElementById('chDonut1');
  var dataLabel = document.getElementById('data-label');
  var rating = document.getElementById('ratingDiv').innerHTML;
  dataDunat["datasets"][0]["data"][1] = rating;
  dataDunat["datasets"][0]["data"][0] = 100-rating;
  const config = {
    type: 'doughnut',
    data: dataDunat,
          options: {
            legend: {
                display: false
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                onComplete: function() {
                }
            },
        }
  };
  var dunatChart = new Chart(ctx,config);
  var bar1 = document.getElementById('bar1');
  var barChart = new Chart(bar1, configBar);
};

function redirect(url){
  window.location=url;
}

$(document).on("click", ".addRide", function () {
  
  var distance = "";
  var points = "";
  var startInput = "";
  var endInput = "";
  var date = "";
  var balance = "";
  var accident = "";
  var rideId = "";
  var action = "insert";

  $(".modal-body #distanceInput").val( distance );
  $(".modal-body #pointsInput").val( points );
  $(".modal-body #startInput").val( startInput );
  $(".modal-body #endInput").val( endInput );
  $(".modal-body #dateInput").val( date );
  $(".modal-body #accidentInput").val( accident);
  $(".modal-body #inputState").val(balance);
  $(".modal-body #rideIdInput").val(rideId);
  $(".modal-body #actionInput").val(action);
});

$(document).on("click", ".open-Update", function () {

  var distance = $(this).data('todo').distance;
  var points = $(this).data('todo').points;
  var startInput = $(this).data('todo').start;
  var endInput = $(this).data('todo').end;
  var date = $(this).data('todo').date;
  var balance = $(this).data('todo').balance;
  var accident = $(this).data('todo').accident ;
  var rideId = $(this).data('todo').ride;
  var action = "update";

  $(".modal-body #distanceInput").val( distance );
  $(".modal-body #pointsInput").val( points );
  $(".modal-body #startInput").val( startInput );
  $(".modal-body #endInput").val( endInput );
  $(".modal-body #dateInput").val( date );
  $(".modal-body #accidentInput").prop("checked", parseInt(accident));
  $(".modal-body #inputState").val(balance);
  $(".modal-body #rideIdInput").val(rideId);
  $(".modal-body #actionInput").val(action);
});

function sortTable(tableId, columnIndex) {
  var table, rows, switching, i, x, y, shouldSwitch,x_value,y_value;
  table = document.getElementById(tableId);
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 0; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[columnIndex];
      y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
      x_value = x.getElementsByTagName("span");
      y_value = y.getElementsByTagName("span");
      if (parseInt(x_value.value.textContent) > parseInt(y_value.value.textContent)) {
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});


$(document).ready(function () {
  $(".open-AddNameUser").click(function () {
      $('#ride').val($(this).data('id'));
      $('#date').val($(this).data('date'));
  });
});


