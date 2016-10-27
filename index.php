<?php
@$slide = $_REQUEST['slide'];
?>

<html>
<head>
<meta name="author" content="JLTChiu">
<meta http-equiv="Content-Type" content="text/html; charset=big5" />
<title>NTU Virtual Instructor -- Introduction to Digital Speech Processing</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="big5">
<style>
iframe {
background: white;
}
h1 {		/* Define style of header: NTU Virtual Instructor. */
color: white;
float: left;
display: block;
clear: none;
       margin-left: 1em;
font: oblique small-caps bold 2.2em Arial, sans-serif;
}
#retrieve {	/* Define style of retrieval form */
	margin-top: 33px;
	margin-right: 57px;
float: right;
clear: none;
display: block;
}
#lside {	/* Define the left side menu style */
height: 88%;
	margin-left:-25px;
width: 20%;
float: left;
clear: left;
display: block;
	 overflow-y: auto;
	 overflow-x: hidden;
}
#main {		/* Define the style of right side main page */

height: 87%;
width: 81%;
float: left;
clear: none;
display: block;
}
a {		/* Define the style of all hyperlink */
clear: none;
float: left;
display: block;
	 text-decoration: none;
}
li {		/* Define the style of left side menu button */
display: block;
clear: both;
padding: 1px;
	 text-align: center;
}
li a{		/* Define the style of hyperlink button in left side menu */
border: 1px #E4E4CA solid;
width: 85%;
       text-decoration: none;
display: block;
padding: 5px 10px;
clear: both;
color: white;
       font-size: 1.2em;
       text-indent: 1em;
cursor: pointer;
}
li a:hover {
border: 1px #E4E4CA solid;
width: 88%;
       text-decoration: underline;
display: block;
padding: 5px 10px;
clear: both;
color: #FF9D37;
       font-size: 1.2em;
cursor: pointer;
}
ul { margin: 0px; }

.head {		/* Define the style of the head button in left side menu */	
width: 88%;
background: #6DA9E7;
}
.leaf {		/* Define the style of the slide button under chapter button in left side menu */

background: #87B8EB;
}
</style>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/util.js" type="text/javascript"></script>
<script type="text/javascript">
var chapter = '';
var lecture = 'DSP';
var popwin = null;	/* Object of pop window */
var isfocus = false;
$(document).ready(function(){
		$(".leaf_navigation").hide();	/* Hide All leaf button */
		$(window).keypress(function(e){ /* Define hotkey -- Enter query word */
			if(isfocus) return;
			var txt = String.fromCharCode(e.which);
			if (e.which == 32 || (65 <= e.which && e.which <= 65 + 25)
				|| (97 <= e.which && e.which <= 97 + 25)) {
			$('#query').val(txt);
			$('#query').focus();
			isfocus = true;
			}
			});
		$('#query').focus(function(){
			isfocus = true;
			});
		$('#query').blur(function(){
			isfocus = false;
			});
		<?php
		/* Define action for specified slide */
		$slide = trim($slide);
		$chapter = split("-", $slide);
		if(!empty($slide)){
			echo "changeMain('$slide');";
			echo "$('#navigation_slide".$chapter[0]."').show();";
		}
		?>
});
function changeMain(chapter){	/* Action for onclick event of left side menu button */
	if(chapter != 0){
		if(isNaN(chapter))
			$("#main").attr("src", "index_file/sel_slide.php?slide="+chapter);
		else
			$("#main").attr("src", "index_file/sel_chapter.php?chapter="+chapter);
	}
	else
		$("#main").attr("src", "index_file/index.html");
	$("#navigation_slide"+chapter).slideToggle("fast");
}
</script>
<script type="text/javascript">
/*Google Analytics Code*/
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
	var pageTracker = _gat._getTracker("UA-9001206-1");
	pageTracker._trackPageview();
} catch(err) {}</script>
</head>
<body>
<a href="index.php"><h1>NTU Virtual Instructor</h1></a>
<div id="retrieve"><form method='POST' action="search.php" id='search_form'>
<font color='white'>Lecture Search: </font>

<!--<input id="query" type='text' size='12' maxlength='100' name='query'></input>-->

<!-- <select name='query' id="query" >
<option selected ></option>
<option value="acoustic model"> acoustic model</option>
<option value="black word algorithm"> black word algorithm</option>
<option value="frequencies"> frequencies</option>
</select> -->

<input id='query' name='query' type="text" lang='zh-TW' speech x-webkit-speech onwebkitspeechchange='document.getElementById("search_form").submit.click()' onspeechchange='document.getElementById("search_form").submit.click()'>

<input type="submit" value="SEARCH" name="submit">
</form></div>
<div id="lside">
<ul class="" id="navigation">
<li>
<a class="head" style="font: normal small-caps bold 0.9em Time New Roman;cursor: arrow; text-indent: 0;text-decoration: none;" alt="Digital Speech Processing" title="Digital Speech Processing" onclick="changeMain(0)">Introduction to <BR> Digital Speech Processing</a>
</li>
<li class="">
<a class="head" onclick="changeMain(1)">Chapter 1</a>
<ul class="leaf_navigation" id="navigation_slide1">
<li><a class="leaf" onclick="changeMain('1-1')">1-1</a></li>
<li><a class="leaf" onclick="changeMain('1-2')">1-2</a></li>
<li><a class="leaf" onclick="changeMain('1-3')">1-3</a></li>
<li><a class="leaf" onclick="changeMain('1-4')">1-4</a></li>
<li><a class="leaf" onclick="changeMain('1-5')">1-5</a></li>
<li><a class="leaf" onclick="changeMain('1-6')">1-6</a></li>
<li><a class="leaf" onclick="changeMain('1-7')">1-7</a></li>
<li><a class="leaf" onclick="changeMain('1-8')">1-8</a></li>
<li><a class="leaf" onclick="changeMain('1-9')">1-9</a></li>
<li><a class="leaf" onclick="changeMain('1-10')">1-10</a></li>
<li><a class="leaf" onclick="changeMain('1-11')">1-11</a></li>
<li><a class="leaf" onclick="changeMain('1-12')">1-12</a></li>
<li><a class="leaf" onclick="changeMain('1-13')">1-13</a></li>
<li><a class="leaf" onclick="changeMain('1-14')">1-14</a></li>
<li><a class="leaf" onclick="changeMain('1-15')">1-15</a></li>
<li><a class="leaf" onclick="changeMain('1-16')">1-16</a></li>
<li><a class="leaf" onclick="changeMain('1-17')">1-17</a></li>
<li><a class="leaf" onclick="changeMain('1-18')">1-18</a></li>
<li><a class="leaf" onclick="changeMain('1-19')">1-19</a></li>
<li><a class="leaf" onclick="changeMain('1-20')">1-20</a></li>
<li><a class="leaf" onclick="changeMain('1-21')">1-21</a></li>
<li><a class="leaf" onclick="changeMain('1-22')">1-22</a></li>
<li><a class="leaf" onclick="changeMain('1-23')">1-23</a></li>
<li><a class="leaf" onclick="changeMain('1-24')">1-24</a></li>
<li><a class="leaf" onclick="changeMain('1-25')">1-25</a></li>
<li><a class="leaf" onclick="changeMain('1-26')">1-26</a></li>
<li><a class="leaf" onclick="changeMain('1-27')">1-27</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(2)">Chapter 2</a>
<ul class="leaf_navigation" id="navigation_slide2">
<li><a class="leaf" onclick="changeMain('2-1')">2-1</a></li>
<li><a class="leaf" onclick="changeMain('2-2')">2-2</a></li>
<li><a class="leaf" onclick="changeMain('2-3')">2-3</a></li>
<li><a class="leaf" onclick="changeMain('2-4')">2-4</a></li>
<li><a class="leaf" onclick="changeMain('2-5')">2-5</a></li>
<li><a class="leaf" onclick="changeMain('2-6')">2-6</a></li>
<li><a class="leaf" onclick="changeMain('2-7')">2-7</a></li>
<li><a class="leaf" onclick="changeMain('2-8')">2-8</a></li>
<li><a class="leaf" onclick="changeMain('2-9')">2-9</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(3)">Chapter 3</a>
<ul class="leaf_navigation" id="navigation_slide3">
<li><a class="leaf" onclick="changeMain('3-1')">3-1</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(4)">Chapter 4</a>
<ul class="leaf_navigation" id="navigation_slide4">
<li><a class="leaf" onclick="changeMain('4-1')">4-1</a></li>
<li><a class="leaf" onclick="changeMain('4-2')">4-2</a></li>
<li><a class="leaf" onclick="changeMain('4-3')">4-3</a></li>
<li><a class="leaf" onclick="changeMain('4-4')">4-4</a></li>
<li><a class="leaf" onclick="changeMain('4-5')">4-5</a></li>
<li><a class="leaf" onclick="changeMain('4-6')">4-6</a></li>
<li><a class="leaf" onclick="changeMain('4-7')">4-7</a></li>
<li><a class="leaf" onclick="changeMain('4-8')">4-8</a></li>
<li><a class="leaf" onclick="changeMain('4-9')">4-9</a></li>
<li><a class="leaf" onclick="changeMain('4-10')">4-10</a></li>
<li><a class="leaf" onclick="changeMain('4-11')">4-11</a></li>
<li><a class="leaf" onclick="changeMain('4-12')">4-12</a></li>
<li><a class="leaf" onclick="changeMain('4-13')">4-13</a></li>
<li><a class="leaf" onclick="changeMain('4-14')">4-14</a></li>
<li><a class="leaf" onclick="changeMain('4-15')">4-15</a></li>
<li><a class="leaf" onclick="changeMain('4-16')">4-16</a></li>
<li><a class="leaf" onclick="changeMain('4-17')">4-17</a></li>
<li><a class="leaf" onclick="changeMain('4-18')">4-18</a></li>
<li><a class="leaf" onclick="changeMain('4-19')">4-19</a></li>
<li><a class="leaf" onclick="changeMain('4-20')">4-20</a></li>
<li><a class="leaf" onclick="changeMain('4-21')">4-21</a></li>
<li><a class="leaf" onclick="changeMain('4-22')">4-22</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(5)">Chapter 5</a>
<ul class="leaf_navigation" id="navigation_slide5">
<li><a class="leaf" onclick="changeMain('5-1')">5-1</a></li>
<li><a class="leaf" onclick="changeMain('5-2')">5-2</a></li>
<li><a class="leaf" onclick="changeMain('5-3')">5-3</a></li>
<li><a class="leaf" onclick="changeMain('5-4')">5-4</a></li>
<li><a class="leaf" onclick="changeMain('5-5')">5-5</a></li>
<li><a class="leaf" onclick="changeMain('5-6')">5-6</a></li>
<li><a class="leaf" onclick="changeMain('5-7')">5-7</a></li>
<li><a class="leaf" onclick="changeMain('5-8')">5-8</a></li>
<li><a class="leaf" onclick="changeMain('5-9')">5-9</a></li>
<li><a class="leaf" onclick="changeMain('5-10')">5-10</a></li>
<li><a class="leaf" onclick="changeMain('5-11')">5-11</a></li>
<li><a class="leaf" onclick="changeMain('5-12')">5-12</a></li>
<li><a class="leaf" onclick="changeMain('5-13')">5-13</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(6)">Chapter 6</a>
<ul class="leaf_navigation" id="navigation_slide6">
<li><a class="leaf" onclick="changeMain('6-1')">6-1</a></li>
<li><a class="leaf" onclick="changeMain('6-2')">6-2</a></li>
<li><a class="leaf" onclick="changeMain('6-3')">6-3</a></li>
<li><a class="leaf" onclick="changeMain('6-4')">6-4</a></li>
<li><a class="leaf" onclick="changeMain('6-5')">6-5</a></li>
<li><a class="leaf" onclick="changeMain('6-6')">6-6</a></li>
<li><a class="leaf" onclick="changeMain('6-7')">6-7</a></li>
<li><a class="leaf" onclick="changeMain('6-8')">6-8</a></li>
<li><a class="leaf" onclick="changeMain('6-9')">6-9</a></li>
<li><a class="leaf" onclick="changeMain('6-10')">6-10</a></li>
<li><a class="leaf" onclick="changeMain('6-11')">6-11</a></li>
<li><a class="leaf" onclick="changeMain('6-12')">6-12</a></li>
<li><a class="leaf" onclick="changeMain('6-13')">6-13</a></li>
<li><a class="leaf" onclick="changeMain('6-14')">6-14</a></li>
<li><a class="leaf" onclick="changeMain('6-15')">6-15</a></li>
<li><a class="leaf" onclick="changeMain('6-16')">6-16</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(7)">Chapter 7</a>
<ul class="leaf_navigation" id="navigation_slide7">
<li><a class="leaf" onclick="changeMain('7-1')">7-1</a></li>
<li><a class="leaf" onclick="changeMain('7-2')">7-2</a></li>
<li><a class="leaf" onclick="changeMain('7-3')">7-3</a></li>
<li><a class="leaf" onclick="changeMain('7-4')">7-4</a></li>
<li><a class="leaf" onclick="changeMain('7-5')">7-5</a></li>
<li><a class="leaf" onclick="changeMain('7-6')">7-6</a></li>
<li><a class="leaf" onclick="changeMain('7-7')">7-7</a></li>
<li><a class="leaf" onclick="changeMain('7-8')">7-8</a></li>
<li><a class="leaf" onclick="changeMain('7-9')">7-9</a></li>
<li><a class="leaf" onclick="changeMain('7-10')">7-10</a></li>
<li><a class="leaf" onclick="changeMain('7-11')">7-11</a></li>
<li><a class="leaf" onclick="changeMain('7-12')">7-12</a></li>
<li><a class="leaf" onclick="changeMain('7-13')">7-13</a></li>
<li><a class="leaf" onclick="changeMain('7-14')">7-14</a></li>
<li><a class="leaf" onclick="changeMain('7-15')">7-15</a></li>
<li><a class="leaf" onclick="changeMain('7-16')">7-16</a></li>
<li><a class="leaf" onclick="changeMain('7-17')">7-17</a></li>
<li><a class="leaf" onclick="changeMain('7-18')">7-18</a></li>
<li><a class="leaf" onclick="changeMain('7-19')">7-19</a></li>
<li><a class="leaf" onclick="changeMain('7-20')">7-20</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(8)">Chapter 8</a>
<ul class="leaf_navigation" id="navigation_slide8">
<li><a class="leaf" onclick="changeMain('8-1')">8-1</a></li>
<li><a class="leaf" onclick="changeMain('8-2')">8-2</a></li>
<li><a class="leaf" onclick="changeMain('8-3')">8-3</a></li>
<li><a class="leaf" onclick="changeMain('8-4')">8-4</a></li>
<li><a class="leaf" onclick="changeMain('8-5')">8-5</a></li>
<li><a class="leaf" onclick="changeMain('8-6')">8-6</a></li>
<li><a class="leaf" onclick="changeMain('8-7')">8-7</a></li>
<li><a class="leaf" onclick="changeMain('8-8')">8-8</a></li>
<li><a class="leaf" onclick="changeMain('8-9')">8-9</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(9)">Chapter 9</a>
<ul class="leaf_navigation" id="navigation_slide9">
<li><a class="leaf" onclick="changeMain('9-1')">9-1</a></li>
<li><a class="leaf" onclick="changeMain('9-2')">9-2</a></li>
<li><a class="leaf" onclick="changeMain('9-3')">9-3</a></li>
<li><a class="leaf" onclick="changeMain('9-4')">9-4</a></li>
<li><a class="leaf" onclick="changeMain('9-5')">9-5</a></li>
<li><a class="leaf" onclick="changeMain('9-6')">9-6</a></li>
<li><a class="leaf" onclick="changeMain('9-7')">9-7</a></li>
<li><a class="leaf" onclick="changeMain('9-8')">9-8</a></li>
<li><a class="leaf" onclick="changeMain('9-9')">9-9</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(10)">Chapter 10</a>
<ul class="leaf_navigation" id="navigation_slide10">
<li><a class="leaf" onclick="changeMain('10-1')">10-1</a></li>
<li><a class="leaf" onclick="changeMain('10-2')">10-2</a></li>
<li><a class="leaf" onclick="changeMain('10-3')">10-3</a></li>
<li><a class="leaf" onclick="changeMain('10-4')">10-4</a></li>
<li><a class="leaf" onclick="changeMain('10-5')">10-5</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(11)">Chapter 11</a>
<ul class="leaf_navigation" id="navigation_slide11">
<li><a class="leaf" onclick="changeMain('11-1')">11-1</a></li>
<li><a class="leaf" onclick="changeMain('11-2')">11-2</a></li>
<li><a class="leaf" onclick="changeMain('11-3')">11-3</a></li>
<li><a class="leaf" onclick="changeMain('11-4')">11-4</a></li>
<li><a class="leaf" onclick="changeMain('11-5')">11-5</a></li>
<li><a class="leaf" onclick="changeMain('11-6')">11-6</a></li>
<li><a class="leaf" onclick="changeMain('11-7')">11-7</a></li>
<li><a class="leaf" onclick="changeMain('11-8')">11-8</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(12)">Chapter 12</a>
<ul class="leaf_navigation" id="navigation_slide12">
<li><a class="leaf" onclick="changeMain('12-1')">12-1</a></li>
<li><a class="leaf" onclick="changeMain('12-2')">12-2</a></li>
<li><a class="leaf" onclick="changeMain('12-3')">12-3</a></li>
<li><a class="leaf" onclick="changeMain('12-4')">12-4</a></li>
<li><a class="leaf" onclick="changeMain('12-5')">12-5</a></li>
<li><a class="leaf" onclick="changeMain('12-6')">12-6</a></li>
<li><a class="leaf" onclick="changeMain('12-7')">12-7</a></li>
<li><a class="leaf" onclick="changeMain('12-8')">12-8</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(13)">Chapter 13</a>
<ul class="leaf_navigation" id="navigation_slide13">
<li><a class="leaf" onclick="changeMain('13-1')">13-1</a></li>
<li><a class="leaf" onclick="changeMain('13-2')">13-2</a></li>
<li><a class="leaf" onclick="changeMain('13-3')">13-3</a></li>
<li><a class="leaf" onclick="changeMain('13-4')">13-4</a></li>
<li><a class="leaf" onclick="changeMain('13-5')">13-5</a></li>
<li><a class="leaf" onclick="changeMain('13-6')">13-6</a></li>
<li><a class="leaf" onclick="changeMain('13-7')">13-7</a></li>
<li><a class="leaf" onclick="changeMain('13-8')">13-8</a></li>
<li><a class="leaf" onclick="changeMain('13-9')">13-9</a></li>
<li><a class="leaf" onclick="changeMain('13-10')">13-10</a></li>
<li><a class="leaf" onclick="changeMain('13-11')">13-11</a></li>
<li><a class="leaf" onclick="changeMain('13-12')">13-12</a></li>
<li><a class="leaf" onclick="changeMain('13-13')">13-13</a></li>
<li><a class="leaf" onclick="changeMain('13-14')">13-14</a></li>
<li><a class="leaf" onclick="changeMain('13-15')">13-15</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(14)">Chapter 14</a>
<ul class="leaf_navigation" id="navigation_slide14">
<li><a class="leaf" onclick="changeMain('14-1')">14-1</a></li>
<li><a class="leaf" onclick="changeMain('14-2')">14-2</a></li>
<li><a class="leaf" onclick="changeMain('14-3')">14-3</a></li>
<li><a class="leaf" onclick="changeMain('14-4')">14-4</a></li>
<li><a class="leaf" onclick="changeMain('14-5')">14-5</a></li>
<li><a class="leaf" onclick="changeMain('14-6')">14-6</a></li>
<li><a class="leaf" onclick="changeMain('14-7')">14-7</a></li>
<li><a class="leaf" onclick="changeMain('14-8')">14-8</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(15)">Chapter 15</a>
<ul class="leaf_navigation" id="navigation_slide15">
<li><a class="leaf" onclick="changeMain('15-1')">15-1</a></li>
<li><a class="leaf" onclick="changeMain('15-2')">15-2</a></li>
<li><a class="leaf" onclick="changeMain('15-3')">15-3</a></li>
<li><a class="leaf" onclick="changeMain('15-4')">15-4</a></li>
<li><a class="leaf" onclick="changeMain('15-5')">15-5</a></li>
<li><a class="leaf" onclick="changeMain('15-6')">15-6</a></li>
<li><a class="leaf" onclick="changeMain('15-7')">15-7</a></li>
<li><a class="leaf" onclick="changeMain('15-8')">15-8</a></li>
<li><a class="leaf" onclick="changeMain('15-9')">15-9</a></li>
<li><a class="leaf" onclick="changeMain('15-10')">15-10</a></li>
<li><a class="leaf" onclick="changeMain('15-11')">15-11</a></li>
<li><a class="leaf" onclick="changeMain('15-12')">15-12</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(16)">Chapter 16</a>
<ul class="leaf_navigation" id="navigation_slide16">
<li><a class="leaf" onclick="changeMain('16-1')">16-1</a></li>
<li><a class="leaf" onclick="changeMain('16-2')">16-2</a></li>
<li><a class="leaf" onclick="changeMain('16-3')">16-3</a></li>
<li><a class="leaf" onclick="changeMain('16-4')">16-4</a></li>
<li><a class="leaf" onclick="changeMain('16-5')">16-5</a></li>
<li><a class="leaf" onclick="changeMain('16-6')">16-6</a></li>
<li><a class="leaf" onclick="changeMain('16-7')">16-7</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(17)">Chapter 17</a>
<ul class="leaf_navigation" id="navigation_slide17">
<li><a class="leaf" onclick="changeMain('17-1')">17-1</a></li>
<li><a class="leaf" onclick="changeMain('17-2')">17-2</a></li>
<li><a class="leaf" onclick="changeMain('17-3')">17-3</a></li>
</ul>
</li>
<li class="">
<a class="head" onclick="changeMain(18)">Chapter 18</a>
<ul class="leaf_navigation" id="navigation_slide18">
<li><a class="leaf" onclick="changeMain('18-1')">18-1</a></li>
</ul>
</li>
</ul>
</div>
<iframe id="main" src="index_file/index.html">
</iframe>
</body>
</html>
