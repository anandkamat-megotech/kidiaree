    "use strict";


    /*--
        preloader
    -----------------------------------*/
    $(window).on('load', function(event) {
        $('#preloader').delay(500).fadeOut(500);
    });


    /*--
		Header Sticky
    -----------------------------------*/
    $(window).on('scroll', function(event) {    
        var scroll = $(window).scrollTop();
        if (scroll <= 100) {
            $(".header").removeClass("sticky");
        } else{
            $(".header").addClass("sticky");
        }
	});


    
    /*--
        Menu parent Element Icon
    -----------------------------------*/
    const $subMenu = document.querySelectorAll('.sub-menu');
    $subMenu.forEach(function (subMenu) {
        const menuExpand = document.createElement('span')
        menuExpand.classList.add('menu-icon')
        // menuExpand.innerHTML = '+'
        subMenu.parentElement.insertBefore(menuExpand, subMenu)
        if (subMenu.classList.contains('mega-menu')) {
            subMenu.classList.remove('mega-menu')
            subMenu.querySelectorAll('ul').forEach(function (ul) {
                ul.classList.add('sub-menu')
                const menuExpand = document.createElement('span')
                menuExpand.classList.add('menu-icon')
                menuExpand.innerHTML = '+'
                ul.parentElement.insertBefore(menuExpand, ul)
            })
        }
    })


    /*--
		Menu Script
	-----------------------------------*/

    function menuScript() {

        $('.menu-toggle').on('click', function(){
            $('.mobile-menu').addClass('open')
            $('.overlay').addClass('open')
        });
        
        $('.menu-close').on('click', function(){
            $('.mobile-menu').removeClass('open')
            $('.overlay').removeClass('open')
        });
        
        $('.overlay').on('click', function(){
            $('.mobile-menu').removeClass('open')
            $('.overlay').removeClass('open')
        });
        
        /*Variables*/
        var $offCanvasNav = $('.offcanvas-menu'),
        $offCanvasNavSubMenu = $offCanvasNav.find('.sub-menu');

        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"></span>');

        /*Close Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.slideUp();

        /*Category Sub Menu Toggle*/
        $offCanvasNav.on('click', 'li a, li .menu-expand, li .menu-title', function(e) {
            var $this = $(this);
            if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('mobile-menu-expand'))) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.parent('li').removeClass('active-expand');
                    $this.siblings('ul').slideUp();
                } else {
                    $this.parent('li').addClass('active-expand');
                    $this.closest('li').siblings('li').find('ul:visible').slideUp();
                    $this.closest('li').siblings('li').removeClass('active-expand');
                    $this.siblings('ul').slideDown();
                }
            }
        });

        $( ".sub-menu" ).parent( "li" ).addClass( "menu-item-has-children" );
    }
    menuScript();


       /*--
        Mobile Menu 
    -----------------------------------*/

    /* Get Sibling */
    const getSiblings = function (elem) {
        const siblings = []
        let sibling = elem.parentNode.firstChild
        while (sibling) {
            if (sibling.nodeType === 1 && sibling !== elem) {
                siblings.push(sibling)
            }
            sibling = sibling.nextSibling
        }
        return siblings
    }

    /* Slide Up */
    const slideUp = (target, time) => {
        const duration = time ? time : 500;
        target.style.transitionProperty = 'height, margin, padding'
        target.style.transitionDuration = duration + 'ms'
        target.style.boxSizing = 'border-box'
        target.style.height = target.offsetHeight + 'px'
        target.offsetHeight
        target.style.overflow = 'hidden'
        target.style.height = 0
        window.setTimeout(() => {
            target.style.display = 'none'
            target.style.removeProperty('height')
            target.style.removeProperty('overflow')
            target.style.removeProperty('transition-duration')
            target.style.removeProperty('transition-property')
        }, duration)
    }

    /* Slide Down */
    const slideDown = (target, time) => {
        const duration = time ? time : 500;
        target.style.removeProperty('display')
        let display = window.getComputedStyle(target).display
        if (display === 'none') display = 'block'
        target.style.display = display
        const height = target.offsetHeight
        target.style.overflow = 'hidden'
        target.style.height = 0
        target.offsetHeight
        target.style.boxSizing = 'border-box'
        target.style.transitionProperty = 'height, margin, padding'
        target.style.transitionDuration = duration + 'ms'
        target.style.height = height + 'px'
        window.setTimeout(() => {
            target.style.removeProperty('height')
            target.style.removeProperty('overflow')
            target.style.removeProperty('transition-duration')
            target.style.removeProperty('transition-property')
        }, duration)
    }

    /* Slide Toggle */
    const slideToggle = (target, time) => {
        const duration = time ? time : 500;
        if (window.getComputedStyle(target).display === 'none') {
            return slideDown(target, duration)
        } else {
            return slideUp(target, duration)
        }
    }


    /*--
		Offcanvas/Collapseable Menu 
	-----------------------------------*/
    const offCanvasMenu = function (selector) {

        const $offCanvasNav = document.querySelector(selector),
            $subMenu = $offCanvasNav.querySelectorAll('.sub-menu');
        $subMenu.forEach(function (subMenu) {
            const menuExpand = document.createElement('span')
            menuExpand.classList.add('menu-expand')
            // menuExpand.innerHTML = '+'
            subMenu.parentElement.insertBefore(menuExpand, subMenu)
            if (subMenu.classList.contains('mega-menu')) {
                subMenu.classList.remove('mega-menu')
                subMenu.querySelectorAll('ul').forEach(function (ul) {
                    ul.classList.add('sub-menu')
                    const menuExpand = document.createElement('span')
                    menuExpand.classList.add('menu-expand')
                    menuExpand.innerHTML = '+'
                    ul.parentElement.insertBefore(menuExpand, ul)
                })
            }
        })

        $offCanvasNav.querySelectorAll('.menu-expand').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.preventDefault()
                const parent = this.parentElement
                if (parent.classList.contains('active')) {
                    parent.classList.remove('active');
                    parent.querySelectorAll('.sub-menu').forEach(function (subMenu) {
                        subMenu.parentElement.classList.remove('active');
                        slideUp(subMenu)
                    })
                } else {
                    parent.classList.add('active');
                    slideDown(this.nextElementSibling)
                    getSiblings(parent).forEach(function (item) {
                        item.classList.remove('active')
                        item.querySelectorAll('.sub-menu').forEach(function (subMenu) {
                            subMenu.parentElement.classList.remove('active');
                            slideUp(subMenu)
                        })
                    })
                }
            })
        })
    }
    offCanvasMenu('.offcanvas-menu');

    /*--
		Mousemove Parallax
	-----------------------------------*/
    var b = document.getElementsByTagName("BODY")[0];  

    b.addEventListener("mousemove", function(event) {
    parallaxed(event);

    });

    function parallaxed(e) {
        var amountMovedX = (e.clientX * -0.3 / 8);
        var amountMovedY = (e.clientY * -0.3 / 8);
        var x = document.getElementsByClassName("parallaxed");
        var i;
        for (i = 0; i < x.length; i++) {
            x[i].style.transform='translate(' + amountMovedX + 'px,' + amountMovedY + 'px)'
        }
    }


     /*--    
        Testimonial
    -----------------------------------*/
    var swiper = new Swiper(".author-images-active .swiper-container", {
        loop: true,
        spaceBetween: 0,
        slidesPerView: 1,
        effect: "fade",
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".testimonial-content-active .swiper-container", {
        loop: true,
        spaceBetween: 20,
        pagination: {
            el: ".testimonial-content-active .swiper-pagination",
            clickable: true,
        },
        thumbs: {
          swiper: swiper,
        },
    });

    /*--    
        Testimonial Two Active
    -----------------------------------*/
    var swiper = new Swiper(".testimonial-02-active", {
        slidesPerView: 2,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".testimonial-02-active .swiper-pagination",
            clickable: true,
        },
        breakpoints: {
          0: {
            slidesPerView: 1,
          },
          576: {
            slidesPerView: 1,
            spaceBetween: 20,
          },
          768: {
            slidesPerView: 1,
          },
          992: {
            slidesPerView: 1,
          },
          1400: {
            slidesPerView: 2,
          },
        },
    });

    /*--    
        Courses Active
    -----------------------------------*/
    var swiper = new Swiper(".courses-active", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".courses-active .swiper-pagination",
            clickable: true,
            },
        breakpoints: {
          0: {
            slidesPerView: 1,
          },
          768: {
            slidesPerView: 2,
          },
          992: {
            slidesPerView: 2,
          },
          1200: {
            slidesPerView: 3,
          },
        },
    });

    /*--    
        Class Active 
    -----------------------------------*/
    var swiper = new Swiper(".class-active .swiper-container", {
        slidesPerView: 3,
        loop: true,
        spaceBetween: 30,
        pagination: {
            el: ".class-active .swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
              slidesPerView: 1,
              
            },
            768: {
              slidesPerView: 2,
            },
            1200: {
              slidesPerView: 3,
            }
        },
    });



     /*--
        Testimonial Active
	-----------------------------------*/
    var swiper = new Swiper('.testimonial-3-active', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".testimonial-3-active .swiper-pagination",
            clickable: true,
        },
    });

    /*--    
        Language Active
    -----------------------------------*/
    var swiper = new Swiper(".language-active .swiper-container", {
        slidesPerView: 4,
        spaceBetween: 30,
        loop: true,
        navigation: {
            nextEl: '.language-active .swiper-button-next',
            prevEl: '.language-active .swiper-button-prev',
        },
        breakpoints: {
          0: {
            slidesPerView: 1,
          },
          576: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          768: {
            slidesPerView: 2,
          },
          992: {
            slidesPerView: 3,
          },
          1200: {
            slidesPerView: 4,
          },
        },
    });

    /*--    
        Brand Active
    -----------------------------------*/
    var swiper = new Swiper(".brand-active .swiper-container", {
        slidesPerView: 6,
        spaceBetween: 30,
        loop: true,
        breakpoints: {
          0: {
            slidesPerView: 1,
          },
          576: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          768: {
            slidesPerView: 3,
          },
          992: {
            slidesPerView: 4,
          },
          1200: {
            slidesPerView: 6,
          },
        },
    });


    /*--    
      Counter Up
    -----------------------------------*/  

    $('.counter').counterUp({
        delay: 10,
        time: 1500,
    });

    /*--
		magnificPopup video view 
	-----------------------------------*/	
	$('.popup-video').magnificPopup({
		type: 'iframe'
	});

    /*--
      nice select  
    -----------------------------------*/
	$('select').niceSelect();

    /*--
        AOS
    -----------------------------------*/

    AOS.init({
        duration: 1200,
        once: true,
    });


    /*--
        Back To Top
    -----------------------------------*/

    // Scroll Event
    $(window).on('scroll', function () {
        var scrolled = $(window).scrollTop();
        if (scrolled > 300) $('.back-btn').addClass('active');
        if (scrolled < 300) $('.back-btn').removeClass('active');
    });

    // Click Event
    $('.back-btn').on('click', function () {
        $("html, body").animate({
            scrollTop: "0"
        }, 1200);
    });

    //hide/show button on scroll up/down

    // mouse-on examples
    $('.single-course').data('powertiptarget', 'course-hover');

    $('.single-course').powerTip({
        placement: 'e',
        mouseOnToPopup: true,
        smartPlacement: true,
    });

    window.addEventListener("DOMContentLoaded", function() {
        var zipcodeInput = document.getElementById("zipcode");
        console.log(navigator);
        if(this.navigator.geolocation == null){
          console.log('here');
          var element = document.getElementById("locationModal");
          element.classList.add("show d-block");
          var element = document.getElementById("pop-location_yes");
          element.classList.add("d-none");

        }
  
        // Check if Geolocation is supported
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            // Fetch the ZIP code based on user's location
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
  
            // Example Nominatim API endpoint for reverse geocoding
            var apiUrl = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + latitude + "&lon=" + longitude;
  
            // Make an AJAX request to the Nominatim API
            var xhr = new XMLHttpRequest();
            xhr.open("GET", apiUrl, true);
            xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                var element = document.getElementById("checkLocation");
                element.classList.add("show");
                element.classList.add("d-block");
                var element = document.getElementById("pop-location_yes");
                element.classList.remove("d-none");
                var response = JSON.parse(xhr.responseText);
                console.log(response);
                var zipcode = response.address.postcode;
                var city = response.address.city;
                zipcodeInput.value = zipcode +', '+city;
                localStorage.setItem("pin", zipcode);
              }
            };
            xhr.send();
          });
        }
      });


      
function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
          /*check if the item starts with the same letters as the text field value:*/
          if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].substr(val.length);
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
            b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                closeAllLists();
            });
            a.appendChild(b);
          }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
          currentFocus++;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 38) { //up
          /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
          currentFocus--;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 13) {
          /*If the ENTER key is pressed, prevent the form from being submitted,*/
          e.preventDefault();
          if (currentFocus > -1) {
            /*and simulate a click on the "active" item:*/
            if (x) x[currentFocus].click();
          }
        }
    });
    function addActive(x) {
      /*a function to classify an item as "active":*/
      if (!x) return false;
      /*start by removing the "active" class on all items:*/
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      /*add class "autocomplete-active":*/
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      /*a function to remove the "active" class from all autocomplete items:*/
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }
    function closeAllLists(elmnt) {
      /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
  }
  
  /*An array containing all the country names in the world:*/
  var tags = ["Drums", "Music", "Percussion", "Instrument","Coding", "Computers", "Scratch", "Animation", "Programming", "STEM"];
  
  /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
  autocomplete(document.getElementById("myInput"), tags);



function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, positionError);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  // Success, can use position.
  console.log("Your position is: " + position);
}

function positionError(error) {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        // Success! You can access the user's location from the 'position' object
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        console.log("Latitude: ", latitude);
        console.log("Longitude: ", longitude);
        
        
      },
      function (error) {
        // Handle error (e.g., user denied permission or unable to retrieve location)
        console.error("Error getting location:", error.message);
      }
    );
  } else {
    console.log("Geolocation is not supported in this browser.");
  }
  
  if (error.PERMISSION_DENIED) {
    var element = document.getElementById("locationModal");
    element.classList.add("show");
    element.classList.add("d-block");
    var element = document.getElementById("pop-location_yes");
    element.classList.add("d-none");
    console.log("Error: permission denied");
    // Your custom modal here.
   
    showError('Geolocation is not enabled. Please enable to use this feature.');
  } else {
    // Handle other kinds of errors.
    console.log("Other kind of error: " + error);
  }
}

function showError(message) {
  // TODO
}

getLocation();


function closeModal(data) {
  var element = document.getElementById(data);
  element.classList.remove("show");
  element.classList.remove("d-block");
}
function closeModal(data) {
  var element = document.getElementById(data);
  element.classList.remove("show");
  element.classList.remove("d-block");
}
function mychecked(data){
  if(data == 'online'){
    $("#online").attr("checked", true);
    $("#offline").attr("checked", false);
    $("#both").attr("checked", false);
    $("#type").val(data);

  }else if(data == 'both'){
    $("#online").attr("checked", false);
    $("#offline").attr("checked", false);
    $("#both").attr("checked", true);
    $("#type").val(data);
  }else if(data == 'offline'){
    $("#online").attr("checked", false);
    $("#offline").attr("checked", true);
    $("#both").attr("checked", false);
    $("#type").val(data);
  }

}

function clearInput(data) {
  document.getElementById("form-location").reset();
  var element = document.getElementById(data);
  element.classList.remove("show");
  element.classList.remove("d-block");
  var element = document.getElementById("pop-location_yes");
  element.classList.add("d-none");
  acceptEmail();
}
function noClick(data) {
  var element = document.getElementById("pop-location_yes");
  element.classList.add("d-none");
  acceptEmail();
}

$(document).ready(function() { 
  var emailAccept = localStorage.getItem("accept-email");
  console.log(emailAccept);
if(emailAccept == "yes"){
  var element = document.getElementById("pop-location_yes").style.display = 'none';
  // element.classList.add("show");
  // element.classList.add("d-none");
}
 });




function acceptEmail(){
  localStorage.setItem("accept-email", "yes");
  closeModal('notifications');
}

function register(){
  window.location.replace('add_kid.php');
}
function sendOtp(){
  var emailorphone = $('#emailorphone').val();
  var params1 = emailorphone;
  
  let url = 'validate_mobile.php';
  function validatePhoneNumber(input_str) {
    var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
  
    return re.test(input_str);
  }

  var datavalue = validatePhoneNumber(emailorphone);
  console.log(datavalue);
  if(datavalue){
    url = 'validate_mobile.php';
  }

  // var regex = new RegExp('/^(\+\d{1,3}[- ]?)?\d{10}$/');
  var regex = new RegExp('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})|(^[0-9]{10})+$');
  
  if(emailorphone){
  		 if(!regex.test(emailorphone)){
          document.getElementById("emailorphone").focus();
          $("#validationError").text("Please enter valid phone number.")
       }else{
         $("#validationError").text('')
         $.ajax({
          url: './main-file/'+url,
          type:'POST',
          data:
          {
              // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
              data: $('#emailorphone').val()
          },
          success: function(msg)
          {
            // var element = document.getElementById("optSendModal");
            //   element.classList.add("show");
            //   element.classList.add("d-block");
            let response = JSON.parse(msg);
            console.log(response.body.id);
            localStorage.setItem("idUser", response.body.id);
            var params2 = response.body.id;
            window.location.href = 'otp.php?mobile='+params1+'&idUser='+params2;
            $('#idUser').val(response.body.id)
          }               
      });
       }
  }else{
    document.getElementById("emailorphone").focus();
   	$("#validationError").text('This field is required.')
  }

console.log(url);
 
}
function resetAll(){
  
  $('#otpresendtext').addClass('d-none');  
$('#otpresendtext1').removeClass('d-none'); 
  $('#successmsg').addClass('d-none'); // Removing it as with next form submit you will be adding the div again in your code. 
  let timerOn = true;
  timer(10); 
  }

function resendOtp(){
  var emailorphone = $('#emailorphone').val();
  var params1 = emailorphone;
  
  let url = 'validate_mobile.php';
  function validatePhoneNumber(input_str) {
    var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
  
    return re.test(input_str);
  }

  var datavalue = validatePhoneNumber(emailorphone);
  console.log(datavalue);
  if(datavalue){
    url = 'validate_mobile.php';
  }

  // var regex = new RegExp('/^(\+\d{1,3}[- ]?)?\d{10}$/');
  var regex = new RegExp('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})|(^[0-9]{10})+$');
  
  if(emailorphone){
  		 if(!regex.test(emailorphone)){
          document.getElementById("emailorphone").focus();
          $("#validationError").text("Please enter valid phone number.")
       }else{
         $("#validationError").text('')
         $.ajax({
          url: './main-file/'+url,
          type:'POST',
          data:
          {
              // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
              data: $('#emailorphone').val()
          },
          success: function(msg)
          {
            // var element = document.getElementById("optSendModal");
            //   element.classList.add("show");
            //   element.classList.add("d-block");
            let response = JSON.parse(msg);
            console.log(response.body.id);
            localStorage.setItem("idUser", response.body.id);
            var params2 = response.body.id;
            $('#successmsg').removeClass('d-none');
            $('#successmsg').html("OTP sent successfully!")
            .hide()
            .fadeIn(1500, function() { $('#successmsg'); });
           setTimeout(resetAll,3000);
            // window.location.href = 'otp.php?mobile='+params1+'&idUser='+params2;
            $('#idUser').val(response.body.id)
          }               
      });
       }
  }else{
    document.getElementById("emailorphone").focus();
   	$("#validationError").text('This field is required.')
  }

console.log(url);
 
}

function VerifyOtp(){
var otp = $("input[name='otp[]']")
.map(function(){return $(this).val();}).get().join("");
var idUser = $('#idUser').val();
console.log(otp);
console.log(idUser);
//   alert('here');
  $.ajax({
    url: './main-file/validate_otp.php',
    type:'POST',
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        otp: otp,
        idUser: idUser
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = response.body.url+'?token='+response.body.token;
        localStorage.setItem("token", response.body.token);
      } else {
        $('#otpError').html('OTP is incorrect!');
      }
      
      // $('#idUser').val(response.body.id)
    }               
});
}

function saveKids(){
  var idUser =  localStorage.getItem("idUser");
  var gender_value = 'Male';
  var ele = document.getElementsByName('gender');
 
            for (let i = 0; i < ele.length; i++) {
                if (ele[i].checked)
                gender_value = ele[i].value;
            }
  var gender = gender_value;
  var k_dob =  $('#k_dob_start').val(); 
  var k_name = $('#k_name').val(); 
  var grade =  $('#grade').val(); 
  console.log(gender);
  console.log(k_dob);
  console.log(k_name);
  console.log(grade);
  $.ajax({
    url: './main-file/add_kids.php',
    type:'POST',
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        idUser: idUser,
        gender: gender,
        k_dob: k_dob,
        k_name: k_name,
        grade: grade
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = 'add_address.php';
      } else {
        // $('#otpError').html('Otp is incorrect!');
      }
      
      // $('#idUser').val(response.body.id)
    }               
});
}
function saveAddress(){
  var idUser =  localStorage.getItem("idUser");
  var token =  localStorage.getItem("token");
  console.log(token);
  var email =  $('#email').val(); 
  var addressLine1 =  $('#addressLine1').val(); 
  var addressLine2 = $('#addressLine2').val(); 
  var area =  $('#area').val(); 
  var city =  $('#city').val(); 
  var state =  $('#state').val(); 
  var country =  $('#country').val(); 
  var pincode =  $('#pincode').val(); 
  console.log(addressLine1);
  console.log(addressLine2);
  console.log(area);
  console.log(city);
  console.log(state);
  console.log(country);
  console.log(pincode);
  $.ajax({
    url: './main-file/update_user_profile.php',
    type:'POST',
    headers: {
        'Authorization': 'Bearer '+token
    },
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        email: email,
        addressLine1: addressLine1,
        addressLine2: addressLine2,
        area: area,
        city: city,
        state: state,
        country: country,
        pincode: pincode
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = 'dashboard.php';
      } else {
        // $('#otpError').html('Otp is incorrect!');
      }
      
      // $('#idUser').val(response.body.id)
    }               
});
}


// document.addEventListener("DOMContentLoaded", function (event) {
//   function searchPin() {
//     let pin = document.getElementById("text").value;
//     $.getJSON("https://api.postalpincode.in/pincode/" + pin, function (data) {
//       createHTML(data);
//     })
//     function createHTML(data) {
//       var htmlElements = " ";
//       var msg = "";
//       msg += '<div id="msg">' + data[0].Message + '<span id="close">X</span></div>'
//       if (data[0].PostOffice && data[0].PostOffice.length) {
//         for (var i = 0; i < data[0].PostOffice.length; i++) {
//           if (data[0].PostOffice.length > 3) {
//             document.getElementById("mkslider").classList.add("sliders");
//           }
//           else {
//             document.getElementById("mkslider").removeAttribute("class");
//           }
//           htmlElements += '<div class="col-sm-4"><div class="card"><div class="list-group"><h4>' + data[0].PostOffice[i].Name + '<small class="pull-right underline">' + data[0].PostOffice[i].Block + '</small></h4><p>District: <span class="pull-right">' + data[0].PostOffice[i].District + '</span></p><p>PostOffice :<span class="pull-right">' + data[0].PostOffice[i].State + '</span></p></div></div></div></div>'
//         }
//       }
//       else {
//         alert('Enter Valid pincode');
//       }
//       var htmlView = document.getElementById("mkslider");
//       htmlView.innerHTML = htmlElements;
//       var msgView = document.getElementById("total-msg");
//       msgView.innerHTML = msg;
//       createSlider();
//     }
//     setTimeout(function () {
//       $('#close').trigger('click');
//     }, 3000);
//   }

//   $(document).on("click", '#close', function () {
//     $('#total-msg').remove();
//   });

//   function createSlider() {
//     $('.sliders').slick({
//       dots: false,
//       infinite: false,
//       speed: 300,
//       slidesToShow: 3,
//       arrows: true,
//       slidesToScroll: 1,
//       autoplay: true,
//       responsive: [
//         {
//           breakpoint: 600,
//           settings: {
//             slidesToShow: 2,
//             slidesToScroll: 1
//           }
//         },
//         {
//           breakpoint: 480,
//           settings: {
//             slidesToShow: 1,
//             slidesToScroll: 1
//           }
//         }
//       ]
//     });
//   }
//   document.getElementById("submit").addEventListener("click", searchPin);
// });

function getKidsDashboard(idKids){

  $.ajax({
    url: './main-file/get_kids_details.php',
    type:'POST',
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        id: idKids
    },
    success: function(data)
    {
      let response = JSON.parse(data);
      if(response.code == "200"){
        $('#k_id').val(response.body[0].id);
        $('#k_name_edit').val(response.body[0].kid_name);
        $('#k_dob_start_edit').val(response.body[0].dob);
        $('#grade_edit').val(response.body[0].grade).niceSelect('update');
        $('#board_edit').val(response.body[0].board).niceSelect('update');
        $('#gender_' + response.body[0].gender).prop('checked',true);
        $('#kidsModalEdit').modal('show')
      }
      
      // $('#idUser').val(response.body.id)
    }               
});
}


function saveKidsDashboard(data){
  var idUser =  localStorage.getItem("idUser");
  var gender_value = 'Male';
  var ele = document.getElementsByName('gender_edit');
 
            for (let i = 0; i < ele.length; i++) {
                if (ele[i].checked)
                gender_value = ele[i].value;
            }
  var gender = gender_value;
  var k_dob =  $('#k_dob_start_edit').val(); 
  var k_name = $('#k_name_edit').val(); 
  var grade =  $('#grade_edit').val(); 
  var board =  $('#board_edit').val(); 
  var k_id =  $('#k_id').val(); 
  console.log(gender);
  console.log(k_dob);
  console.log(k_name);
  console.log(grade);
  console.log(board);
  $.ajax({
    url: './main-file/add_kids.php',
    type:'POST',
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        idUser: idUser,
        gender: gender,
        k_dob: k_dob,
        k_name: k_name,
        grade: grade,
        board: board,
        kid_id: k_id
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = 'dashboard.php';
      } else {
        // $('#otpError').html('Otp is incorrect!');
      }
      
      // $('#idUser').val(response.body.id)
    }               
});
}
function saveDetailsUser(a) {
  alert('here');
  var idUser =  localStorage.getItem("idUser");
  var gender_value = 'Male';
  var ele = document.getElementsByName('gender');
 
            for (let i = 0; i < ele.length; i++) {
                if (ele[i].checked)
                gender_value = ele[i].value;
            }
  var gender = gender_value;
  var k_dob =  $('#k_dob_start').val(); 
  var k_name = $('#k_name').val(); 
  var grade =  $('#grade').val(); 
  var board =  $('#board').val(); 
  if( k_name == '' ) {
    $("#k_name").after(' <p class="text-danger"> Name is required</p>');
  }
  
}

function saveKidsDashboardAdd(){
  var idUser =  localStorage.getItem("idUser");
  var gender_value = 'Male';
  var ele = document.getElementsByName('gender');
 
            for (let i = 0; i < ele.length; i++) {
                if (ele[i].checked)
                gender_value = ele[i].value;
            }
  var gender = gender_value;
  var k_dob =  $('#k_dob_start').val(); 
  var k_name = $('#k_name').val(); 
  var grade =  $('#grade').val(); 
  var board =  $('#board').val(); 
  console.log(gender);
  console.log(k_dob);
  console.log(k_name);
  console.log(grade);
  $.ajax({
    url: './main-file/add_kids.php',
    type:'POST',
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        idUser: idUser,
        gender: gender,
        k_dob: k_dob,
        k_name: k_name,
        board: board,
        grade: grade
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = 'dashboard.php';
      } else {
        // $('#otpError').html('Otp is incorrect!');
      }
      
      // $('#idUser').val(response.body.id)
    }               
});
}