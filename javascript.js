$(document).ready(function() {
   horloge();
   photo();
   meteo();
   meteoparis();
   temp();
   tempext();
   tempgraph();
   fete();
   minmax();
   ifstat();
   temppi();
   mempi();
   cpupi();
   uptimepi();
   tempgraphext();
   minmaxext();
});


var ifstat_timeout;

function ifstat() {

  var now = new Date().getTime();

    var url_up   = "ajax.php?block=ifstat&eth=WiFi&up_down=up&max=20&hour="+now;
  var img_eth0_up = $("<img />").attr("src", url_up);
  $("#img_eth0_up").attr("src", url_up);
  
  var url_down = "ajax.php?block=ifstat&eth=WiFi&up_down=down&max=10&hour="+now;
  var img_eth0_down = $("<img />").attr("src", url_down);
  $("#img_eth0_down").attr("src", url_down);

  ifstat_timeout = setTimeout("ifstat()", 10000);
}

/* cpu pi */

var cpupi_timeout;

function cpupi()
{
   var now = new Date().getTime();

 var url_cpupi   = "ajax.php?block=cpupi&hour="+now;
  var img_cpupi = $("<img />").attr("src", url_cpupi);
  $("#img_cpupi").attr("src", url_cpupi);

  cpupi_timeout = setTimeout("cpupi()", 5000);
}

/* memoire pi */

var mempi_timeout;

function mempi()
{
   var now = new Date().getTime();

 var url_mempi   = "ajax.php?block=mempi&hour="+now;
  var img_mempi = $("<img />").attr("src", url_mempi);
  $("#img_mempi").attr("src", url_mempi);

  mempi_timeout = setTimeout("mempi()", 5000);
}

/* uptime */

var uptimepi_timeout;

function uptimepi()
{
  $.ajax({
    async : false,
    type: "GET",
    url: "./ajax.php",
    data: "block=uptimepi",
    success: function(html){
      $("#uptimepi").html(html);
    }
  });

  uptimepi_timeout = setTimeout("uptimepi()", 60000);
}

/* temp pi */

var temppi_timeout;

function temppi()
{
  $.ajax({
    async : false,
    type: "GET",
    url: "./ajax.php",
    data: "block=temppi",
    success: function(html){
      $("#temppi").html(html);
    }
  });

  temppi_timeout = setTimeout("temppi()", 100000);
}


/* photo */

var photo_timeout;

function photo ()
{
  $.ajax({
    async : false,
    type: "GET",
    url: "./ajax.php",
    data: "block=photo",
    success: function(html){
      $("#photo").html(html);
    }
  });

  meteo_timeout = setTimeout("photo()", 10000);
}

/* fete */

var fete_timeout;

function fete ()
{
  $.ajax({
    async : false,
    type: "GET",
    url: "./ajax.php",
    data: "block=fete",
    success: function(html){
      $("#fete").html(html);
    }
  });

  fete_timeout = setTimeout("fete()", 3600000);
}

/* meteo */

var meteo_timeout;

function meteo ()
{
  $.ajax({
    async : false,
    type: "GET",
    url: "./ajax.php",
    data: "block=meteo",
    success: function(html){
      $("#meteo").html(html);
    }
  });

  meteo_timeout = setTimeout("meteo()", 3600000);
}

/* meteo paris */

var meteoparis_timeout;

function meteoparis ()
{
  $.ajax({
    async : false,
    type: "GET",
    url: "./ajax.php",
    data: "block=meteoparis",
    success: function(html){
      $("#meteoparis").html(html);
    }
  });

  meteoparis_timeout = setTimeout("meteoparis()", 3600000);
}

/* temp */

var temp_timeout;

function temp()
{
	$.ajax({
	async : false,
	type: "GET",
	url: "./ajax.php",
	data: "block=temp1",
	success: function(html){
	$("#temp").html(html);
	}
});
temp_timeout = setTimeout("temp()", 300000);
}

/* tempext */

var tempext_timeout;

function tempext()
{
	$.ajax({
	async : false,
	type: "GET",
	url: "./ajax.php",
	data: "block=tempext",
	success: function(html){
	$("#tempext").html(html);
	}
});
tempext_timeout = setTimeout("tempext()", 600000);
}

/* temp graphique ext */

var tempgraphext_timeout;

function tempgraphext()
{
	$.ajax({
	async : false,
	type: "GET",
	url: "./ajax.php",
	data: "block=tempgraphext",
	success: function(html){
	$("#tempgraphext").html(html);
	}
});
tempgraphrxt_timeout = setTimeout("tempgraphrxt()", 900000);
}

/* temp graphique salon */

var tempgraph_timeout;

function tempgraph()
{
	$.ajax({
	async : false,
	type: "GET",
	url: "./ajax.php",
	data: "block=tempgraph1",
	success: function(html){
	$("#tempgraph").html(html);
	}
});
tempgraph_timeout = setTimeout("tempgraph()", 900000);
}

/* temp mini maxi salon */

var tempminmax_timeout;

function minmax()
{
	$.ajax({
	async : false,
	type: "GET",
	url: "./ajax.php",
	data: "block=minmax",
	success: function(html){
	$("#minmax").html(html);
	}
});
tempminmax_timeout = setTimeout("minmax()", 900000);
}

/* temp mini maxi ext */

var tempminmaxext_timeout;

function minmaxext()
{
	$.ajax({
	async : false,
	type: "GET",
	url: "./ajax.php",
	data: "block=minmaxext",
	success: function(html){
	$("#minmaxext").html(html);
	}
});
tempminmaxext_timeout = setTimeout("minmaxext()", 900000);
}

/* horloge */

var horloge_timeout;

function horloge()
{
  dows  = ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"];
  mois  = ["janv", "f&eacute;v", "mars", "avril", "mai", "juin", "juillet", "ao&ucirc;t", "sept", "oct", "nov", "d&eacute;c"];

  now          = new Date;
  heure        = now.getHours();
  min          = now.getMinutes();
  sec          = now.getSeconds();
  jour_semaine = dows[now.getDay()];
  jour         = now.getDate();
  mois         = mois[now.getMonth()];
  annee        = now.getFullYear();

  if (sec < 10){sec0 = "0";}else{sec0 = "";}
  if (min < 10){min0 = "0";}else{min0 = "";}
  if (heure < 10){heure0 = "0";}else{heure0 = "";}

  horloge_heure   = heure + ":" + min0 + min;
  horloge_date    = "<span class='horloge_grey'>" + jour_semaine + "</span> " + jour + " " + mois + " <span class='horloge_grey'>" + annee + "</span>";
  horloge_content = "<div class='horloge_heure'>" + horloge_heure + "</div><div class='horloge_date'>" + horloge_date + "</div>";

  $("#horloge").html(horloge_content);

  horloge_timeout = setTimeout("horloge()", 1000);
}









