new WOW().init();

    //When User clicks the button, scroll to top
      function topFunction(){

        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        console.log("Calling this function");
      }

    $(document).ready(function () {

      //Get the Button
      var myButton = document.getElementById("myBtn");

      //When User scrolls down ** 20px ** from top of the document, show button
      window.onscroll = function(){scrollFunction()};

      function scrollFunction(){
        if (document.body.scrollTop > 750 || document.documentElement.scrollTop > 750){
          
          myButton.style.display = "block";

        } else {

          myButton.style.display = "none";

        }


      };


    });
