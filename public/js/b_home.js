function random_color() {
  var r = Math.floor(Math.random() * 255);
  var g = Math.floor(Math.random() * 255);
  var b = Math.floor(Math.random() * 255);
  return "rgb(" + r + "," + g + "," + b;
}

var bg_colors = [];
// var bg2_colors = [];
var ol_colors = [];

$.ajaxSetup({
  async: false
});


// console.log(bg_colors);
// console.log(ol_colors);

var customers = [];
var orders = [];

$.get("/home/customers", function(response){
  response.forEach(function(data){
      customers.push(data);
      var temp_random_color = random_color();
      bg_colors.push(temp_random_color + ", 0.3)");
      // bg2_colors.push(temp_random_color + ", 0.5)");
      ol_colors.push(temp_random_color + ", 1)");
  });
});

$.get("/home/orders", function(response){
  response.forEach(function(data){
      orders.push(data);
  });
});

// console.log(customers);
// console.log(orders);


var ctx = document.getElementById('customers_chart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: customers,
        datasets: [{
            label: '# of Orders per Customer',
            data: orders,
            backgroundColor: bg_colors,
            borderColor: ol_colors,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});







var offers = [];
var qtys = [];

$.get("/home/offers", function(response){
  response.forEach(function(data){
      offers.push(data);
      var temp_random_color = random_color();
      bg_colors.push(temp_random_color + ", 0.2)")
      ol_colors.push(temp_random_color + ", 1)")
  });
});

$.get("/home/qtys", function(response){
  response.forEach(function(data){
      qtys.push(data);
  });
});

// console.log(offers);
// console.log(qtys);


var ctx2 = document.getElementById('offers_chart');

var myDoughnutChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
      datasets: [{
            data: qtys,
            backgroundColor: ol_colors,
            borderColor: bg_colors,
        }],
      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: offers
  }
});







var months = [];
var months_orders = [];

$.get("/home/months", function(response){
  response.forEach(function(data){
      months.push(data);
      var temp_random_color = random_color();
      bg_colors.push(temp_random_color + ", 0.2)")
      ol_colors.push(temp_random_color + ", 1)")
  });
});

$.get("/home/months_orders", function(response){
  response.forEach(function(data){
      months_orders.push(data);
  });
});

console.log(months);
console.log(months_orders);


var ctx3 = document.getElementById('months_chart');


var myLineChart = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: '# of Orders per Month',
            data: months_orders,
            backgroundColor: bg_colors,
            borderColor: ol_colors,
        }]
    },
    options: {
      scales: {
        yAxes: [{
          scaleLabel: {
            display: true,
            // labelString: 'probability'
          }
        }]
      }
    }

});

// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: offers,
//         datasets: [{
//             label: '# of Orders per Offer',
//             data: qtys,
//             backgroundColor: bg_colors,
//             borderColor: ol_colors,
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// });