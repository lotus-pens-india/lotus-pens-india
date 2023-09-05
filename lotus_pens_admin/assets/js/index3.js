$(function() {
    "use strict";


	
	
	// chart 7
 
 var ctx = document.getElementById('dashboard3-chart-7').getContext('2d');
 
   var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
       gradientStroke1.addColorStop(0, '#7f00ff');
       gradientStroke1.addColorStop(1, 'rgba(225, 0, 255, 0.1)');

   var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
       gradientStroke2.addColorStop(0, '#3bb2b8');
       gradientStroke2.addColorStop(1, 'rgba(66, 230, 149, 0.0)');

      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [{
            label: 'Apple',
            data: [0, 30, 60, 25, 60, 25, 50, 10, 60, 30, 80, 0],
            pointBorderWidth: 4,
            pointHoverBackgroundColor: gradientStroke1,
            backgroundColor: gradientStroke1,
            borderColor: gradientStroke1,
            borderWidth: 2
          }, {
            label: 'Samsung',
            data: [0, 60, 25, 80, 35, 75, 30, 55, 20, 60, 10, 0],
            pointBorderWidth: 4,
            pointHoverBackgroundColor: gradientStroke2,
            backgroundColor: gradientStroke2,
            borderColor: gradientStroke2,
            borderWidth: 2
          }]
        },
        options: {
            
            tooltips: {
			  displayColors:false,
              mode: 'nearest',
              intersect: false,
              position: 'nearest',
              xPadding: 10,
              yPadding: 10,
              caretPadding: 10
            },

         }
      }); 

	  
	  
// worl map

  
	  

	
	
	  

});
      
	  