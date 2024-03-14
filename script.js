 let button = document.getElementById('submitknop');

button.addEventListener('click', function() {

  var naam = $('#naam').val();
  var Bericht = $('#bericht').val();
  var imageData = $('#fileToUpload').prop('files')[0];

var form_data = new FormData();
form_data.append('naam', naam);
form_data.append('bericht', Bericht);
form_data.append('afbeelding', imageData);

  $.ajax({
    url: 'upload.php',
    type: 'POST',
    data: form_data,
    dataType: 'json',
    processData: false,
    success: function(response) {
     console.log("response: we did it");
     console.log(response.status);
    
     if(response.status == "error")
     {
          console.log("response.message");
      
     }
  },
  error: function(xhr, status, error) {
        console.log("response: we done goofed");
      // console.error('Error retrieving images:', error);
    }
  });
});
    
    
//     $('#submitknop').click(function() {

//     var naam = $('#naam').val();
//     var Bericht = $('#bericht').val();
//     var imageData = $('#fileToUpload').prop('files')[0];

// var form_data = new FormData();
// form_data.append('naam', naam);
// form_data.append('bericht', Bericht);
// form_data.append('afbeelding', imageData);

//     $.ajax({
//       url: 'upload.php',
//       type: 'POST',
//       data: form_data,
//       dataType: 'html',
//       success: function(response) {
//           // $('#imageContainer').html(response);
//        console.log("response: we did it");
//        if(response.status == "error")
//        {
//             console.log("response.message");
        
//        }
//     },
//     error: function(xhr, status, error) {
//           console.log("response: we done goofed");
//         // console.error('Error retrieving images:', error);
//       }
//     });
//   });