// save submitbutton in variable 
let submitButton = document.getElementById('button');
submitButton.addEventListener('click', validateForm);

// function for validating the input (front-end) and sending the values to the backend
// this will return a success response if the call is successful, or a error response if the call is not successful
// with this response, we can give the user feedback without having to reload the page.
function validateForm() {
  // get the values from the input fields
  let naam = $('#name').val();
  let Bericht = $('#message').val();
  let imageData = $('#fileToUpload').prop('files')[0];
  
  // create a new instance of the FormData class
  // add the values from the inputfields to the FormData instance
  var form_data = new FormData();
  form_data.append('name', naam);
  form_data.append('message', Bericht);
  form_data.append('fileToUpload', imageData);
  
  // send the form data to the server
  $.ajax({
    url: 'upload.php', // which script will handle the request
    type: 'POST', // the HTTP method
    data: form_data, // what data we will post
    dataType: 'json', // the data we expect to receive from the server
    processData: false,
    contentType: false, // ensures that the content type will be set automatically
    // if the call is successful, the server will return the success response.
    // the call can be sucessful, but the server can still return an error response.
    // this is why we need to check the status of the response
    success: function(response) {
      if(response.status == "error")
      {
        console.log("response.error: " + response.error);
      }
      else if (response.status == "success")
      {
       console.log("message uploaded succeeded");
      }
    },
    // when an error occurs, the server will return an error response
    // this error response means something went wrong with the server (not the client side validation)
    error: function(xhr, status, error) {
     console.log(xhr.responseText);
    }
  });
}

// function thats called when there's an error with the image
function onImageError()
{

}

// function thats called when there's an error with the message
function onMesageError()
{

}

// function thats called when there's an error with the name
function onNameError()
{

}