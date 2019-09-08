function random_color() {
  var r = Math.floor(Math.random() * 255);
  var g = Math.floor(Math.random() * 255);
  var b = Math.floor(Math.random() * 255);
  return "rgb(" + r + "," + g + "," + b;
}

var names = [];
var counts = [];
var bg_colors = [];
var ol_colors = [];

$.ajaxSetup({
  async: false
});

$.get("/home/names", function(response){
  response.forEach(function(data){
      names.push(data);
      var temp_random_color = random_color();
      bg_colors.push(temp_random_color + ", 0.2)")
      ol_colors.push(temp_random_color + ", 1)")


  });
});

$.get("/home/counts", function(response){
  response.forEach(function(data){
      counts.push(data);
  });
});

// console.log(counts);
// console.log(names);
// console.log(bg_colors);
// console.log(ol_colors);

var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: names,
        datasets: [{
            label: '# of Orders per Category',
            data: counts,
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