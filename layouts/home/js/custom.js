/*Theme    : narani
 * Author  : Design_mylife
 * Version : V1.0
 *
 */



// niceScroll
jQuery("html").niceScroll({
    scrollspeed: 50,
    mousescrollstep: 38,
    cursorwidth: 7,
    cursorborder: 0,
    cursorcolor: '#f99200',
    autohidemode: false,
    zindex: 9999999,
    horizrailenabled: false,
    cursorborderradius: 0
});

//sticky header on scroll
$(window).load(function() {
    $(".sticky").sticky({topSpacing: 0});
});

//parallax
$(window).stellar({
    horizontalScrolling: false,
    responsive: true/*,
     scrollProperty: 'scroll',
     parallaxElements: false,
     horizontalScrolling: false,
     horizontalOffset: 0,
     verticalOffset: 0*/
});

/*====flex  slider for main slider on header2====*/
$('.main-slider').flexslider({
    slideshowSpeed: 5000,
    directionNav: false,
    controlNav: true,
    animation: "fade"
});

//owl carousel for work
$(document).ready(function() {
    $("#work-carousel").owlCarousel({
        // Most important owl features
        items: 4,
        itemsCustom: false,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [768, 3],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        startDragging: true
    });

});

//owl carousel for testimonials
$(document).ready(function() {

    $("#testi-carousel").owlCarousel({
        // Most important owl features
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [768, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        startDragging: true
    });

});
//owl carousel for full width image slider
$(document).ready(function() {

    $("#full-img-slide").owlCarousel({
        // Most important owl features
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [768, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        startDragging: true
    });

});

/* ==============================================
 Counter Up
 =============================================== */
jQuery(document).ready(function($) {
    $('.counter').counterUp({
        delay: 100,
        time: 800
    });
});


/* ==============================================
 WOW plugin triggers animate.css on scroll
 =============================================== */

var wow = new WOW(
        {
            boxClass: 'wow', // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset: 100, // distance to the element when triggering the animation (default is 0)
            mobile: false        // trigger animations on mobile devices (true is default)
        }
);
wow.init();

//portfolio mix
$('#grid').mixitup();


/*========tooltip and popovers====*/
/*==========================*/
$("[data-toggle=popover]").popover();

$("[data-toggle=tooltip]").tooltip();

$('#simple-criteria li').on('click', function(){
    //alert($(this).text());
    $('#mainKeywords').val($(this).text().trim());
});
$('#simple-radius li').on('click', function(){
    //alert($(this).text());
    $('#lnkradius').text($(this).text());
    $('#hdnRadius').val($(this).text().trim());
});
$('#btnFindLeague').on('click', function(){
    window.location.href="/actfind#lnkradius";
});
$('#btnRegisterLeague').on('click', function(){
    var userId = $("#hdnUserId").val();

    if(userId==""){
        window.location.href="/actfind/prototype/users/register?action=signup&callback=register";
    }
    else{
        window.location.href="/actfind/prototype/clubs/join?action=step1";
    }
});
$('#btnSignUp').on('click', function(){
    window.location.href="/actfind/prototype/users/register?action=signup";
});
$('#btnSignIn').on('click', function(){
    window.location.href="/actfind/prototype/users/register?action=signin";
});
$('#btnLogOut').on('click', function(){
    window.location.href="/actfind/prototype/users/logout";
});
$('#go').on('click', function(){
    //var city = $("#city_id").val();
    //alert(city);
    var radius = $("#lnkradius").text();
    var category = $("#mainKeywords").val().trim();
    var lat = $("#hdnLat").val();
    var lng = $("#hdnLong").val();
   // alert($('#hdnRadius').val());
   // alert(radius);

  //  alert(lat);
  //  alert(lng);
    //document.getElementById("searchForm").action="searchresults.php?lat="+lat+"&lng="+lng+"&radius="+radius+"&category="+category
    document.getElementById("searchForm").submit();


    /*
    $.get( "/api/activity/search?lat="+lat+"&lng="+lng+"&radius="+radius+"&category="+category, function( data ) {
        var obj = JSON.parse(data);
        if(obj.success){
            var str = "";
            for (var key in obj.data) {
              var c = obj.data[key];
              activity_id = c.activity_id;
              console.log(c.activity_id)
              url = c.ac_images;
              str = str + "<div class='col-xs-6 col-sm-2'><a class='bootcards-summary-item' href='blog.html?activity_id="+ activity_id +"'><img src='img/work-10.jpg' alt='Pulpit rock' width='150' height='150'></a></div>"
              //str = str + "<a href='"+c.url+"'>"+c.name+"</a> ("+c.activity_id+" )<br />";
              console.log(str);
            }
             $('#grdActivity').html(str);

        }*/
        //console.log(obj);
        //return false;
        /*
        var str = "";
        var first = false;
        for (var key in obj.nearby) {
          var c = obj.nearby[key];
          if (!first) {
            latitude = c.latitude;
            longitude = c.longitude;
            first = true;
          }
          str = str + "<a href='"+c.url+"'>"+c.name+"</a> ("+c.distance+" mi)<br />";
        }
        $('#homepagenearby').show();
        $('#homepagenearbycontent').html(str);
        initializeGoogleMap('mapCanvas')*/
  });



