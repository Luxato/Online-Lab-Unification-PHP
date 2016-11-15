<!DOCTYPE html>
<!-- saved from url=(0100)http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/33-vseobecne-o-modelovani/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <title>ioLAB - interaktívne online laboratórium&nbsp;&gt;&nbsp;Predmety&nbsp;&gt;&nbsp;TAR1&nbsp;&gt;&nbsp;Teória&nbsp;&gt;&nbsp;Modelovanie systémov&nbsp;&gt;&nbsp;Všeobecne o modelovaní</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./ioLAB_files/css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="./ioLAB_files/style.css">
  <link rel="shortcut icon" href="http://www.iolab.sk/websupport/favicon.ico" type="image/x-icon">
  <link rel="icon" href="http://www.iolab.sk/websupport/favicon.ico" type="image/x-icon">
  <script src="./ioLAB_files/fullscreen.js"></script> 

  <!-- maxima -->  
  <script type="text/javascript" src="./ioLAB_files/jquery-1.6.2.js"></script>
  <script type="text/javascript" src="./ioLAB_files/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="./ioLAB_files/shCore.css" type="text/css">
  <link rel="stylesheet" href="./ioLAB_files/shThemeDefault.css" type="text/css">
  <script type="text/javascript" src="./ioLAB_files/shCore.js"></script>
  <script type="text/javascript" src="./ioLAB_files/shBrushJScript.js"></script>
  
  <script type="text/javascript" src="./ioLAB_files/jquery.jqplot.min.js"></script>
  <link rel="stylesheet" type="text/css" href="./ioLAB_files/jquery.jqplot.css">
  
  <script type="text/javascript" src="./ioLAB_files/script.js"></script>
  <script type="text/javascript" src="./ioLAB_files/ajaxupload.js"></script>
	<script type="text/javascript" src="./ioLAB_files/excanvas.js"></script>
	<script type="text/javascript" src="./ioLAB_files/jquery.flot.js"></script>  
  
  <script type="text/javascript" src="./ioLAB_files/MathJax.js">
    MathJax.Hub.Config({
      extensions: ["tex2jax.js"],
      jax: ["input/TeX","output/HTML-CSS"],
      tex2jax: {inlineMath: [["$","$"],["\\(","\\)"]]}
    });
  </script><style type="text/css">.MathJax_Preview {color: #888}
#MathJax_Message {position: fixed; left: 1em; bottom: 1.5em; background-color: #E6E6E6; border: 1px solid #959595; margin: 0px; padding: 2px 8px; z-index: 102; color: black; font-size: 80%; width: auto; white-space: nowrap}
#MathJax_MSIE_Frame {position: absolute; top: 0; left: 0; width: 0px; z-index: 101; border: 0px; margin: 0px; padding: 0px}
.MathJax_Error {color: #CC0000; font-style: italic}
</style> 
  <!-- -->       

  <!-- prihlásenie -->  
	<script src="./ioLAB_files/jquery.min.js"></script>
	<script src="./ioLAB_files/jquery.form.js"></script>
 <!--	<script type="text/javascript" src="/prihlasenie/js/bootstrap.js"></script>    
 20150823 -->

  <!-- syntax highliter -->
<!--  <script type="text/javascript" src="/websupport/js/syntaxhighlighter/shCore.js"></script>
  <script type="text/javascript" src="/websupport/js/syntaxhighlighter/shBrushJScript.js"></script>  
20150823   -->

  <script type="text/javascript" src="./ioLAB_files/main.js"></script>  
  <style type="text/css">#MathJax_About {position: fixed; left: 50%; width: auto; text-align: center; border: 3px outset; padding: 1em 2em; background-color: #DDDDDD; color: black; cursor: default; font-family: message-box; font-size: 120%; font-style: normal; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; border-radius: 15px; -webkit-border-radius: 15px; -moz-border-radius: 15px; -khtml-border-radius: 15px; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color='gray', Positive='true')}
#MathJax_About.MathJax_MousePost {outline: none}
.MathJax_Menu {position: absolute; background-color: white; color: black; width: auto; padding: 2px; border: 1px solid #CCCCCC; margin: 0; cursor: default; font: menu; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; z-index: 201; box-shadow: 0px 10px 20px #808080; -webkit-box-shadow: 0px 10px 20px #808080; -moz-box-shadow: 0px 10px 20px #808080; -khtml-box-shadow: 0px 10px 20px #808080; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color='gray', Positive='true')}
.MathJax_MenuItem {padding: 2px 2em; background: transparent}
.MathJax_MenuArrow {position: absolute; right: .5em; padding-top: .25em; color: #666666; font-size: .75em}
.MathJax_MenuActive .MathJax_MenuArrow {color: white}
.MathJax_MenuArrow.RTL {left: .5em; right: auto}
.MathJax_MenuCheck {position: absolute; left: .7em}
.MathJax_MenuCheck.RTL {right: .7em; left: auto}
.MathJax_MenuRadioCheck {position: absolute; left: 1em}
.MathJax_MenuRadioCheck.RTL {right: 1em; left: auto}
.MathJax_MenuLabel {padding: 2px 2em 4px 1.33em; font-style: italic}
.MathJax_MenuRule {border-top: 1px solid #CCCCCC; margin: 4px 1px 0px}
.MathJax_MenuDisabled {color: GrayText}
.MathJax_MenuActive {background-color: Highlight; color: HighlightText}
.MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {background-color: #E8E8E8}
.MathJax_ContextMenu:focus {outline: none}
.MathJax_ContextMenu .MathJax_MenuItem:focus {outline: none}
#MathJax_AboutClose {top: .2em; right: .2em}
.MathJax_Menu .MathJax_MenuClose {top: -10px; left: -10px}
.MathJax_MenuClose {position: absolute; cursor: pointer; display: inline-block; border: 2px solid #AAA; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; font-family: 'Courier New',Courier; font-size: 24px; color: #F0F0F0}
.MathJax_MenuClose span {display: block; background-color: #AAA; border: 1.5px solid; border-radius: 18px; -webkit-border-radius: 18px; -moz-border-radius: 18px; -khtml-border-radius: 18px; line-height: 0; padding: 8px 0 6px}
.MathJax_MenuClose:hover {color: white!important; border: 2px solid #CCC!important}
.MathJax_MenuClose:hover span {background-color: #CCC!important}
.MathJax_MenuClose:hover:focus {outline: none}
</style><style type="text/css">#MathJax_Zoom {position: absolute; background-color: #F0F0F0; overflow: auto; display: block; z-index: 301; padding: .5em; border: 1px solid black; margin: 0; font-weight: normal; font-style: normal; text-align: left; text-indent: 0; text-transform: none; line-height: normal; letter-spacing: normal; word-spacing: normal; word-wrap: normal; white-space: nowrap; float: none; -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; box-shadow: 5px 5px 15px #AAAAAA; -webkit-box-shadow: 5px 5px 15px #AAAAAA; -moz-box-shadow: 5px 5px 15px #AAAAAA; -khtml-box-shadow: 5px 5px 15px #AAAAAA; filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color='gray', Positive='true')}
#MathJax_ZoomOverlay {position: absolute; left: 0; top: 0; z-index: 300; display: inline-block; width: 100%; height: 100%; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}
#MathJax_ZoomFrame {position: relative; display: inline-block; height: 0; width: 0}
#MathJax_ZoomEventTrap {position: absolute; left: 0; top: 0; z-index: 302; display: inline-block; border: 0; padding: 0; margin: 0; background-color: white; opacity: 0; filter: alpha(opacity=0)}
</style></head>
  <body><div id="MathJax_Message" style="display: none;"></div>                                                                                
    <div id="wrapper">
      <nav class="top" style="">
        <div class="in">
                        <a href="http://www.iolab.sk/9-experiments/">Experimenty</a>            
                            <a href="http://www.iolab.sk/10-services/">Služby</a>            
                            <a href="http://www.iolab.sk/11-subjects/">Predmety</a>            
                            <a href="http://www.iolab.sk/12-aktuality/">Aktuality</a>            
                            <a href="http://www.iolab.sk/13-kontakt/">Kontakt</a>            
                            <a href="http://www.iolab.sk/14-mapa-stranky/">Mapa stránky</a>            
                      </div>
      </nav>
      <header> 
        <div class="in">
          <div id="logo" class="left" style="">
            <a href="http://www.iolab.sk/">
                                <img src="./ioLAB_files/iolab-logo1_sk.png" style="height:114px;margin-top:-7px;" alt="ioLAB - interaktívne online laboratórium">
                                
            </a>
          </div>
          <div class="right" style="">
            <div class="right_in">
              <div id="lang_bar">              
                <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/33-vseobecne-o-modelovani/?lang=en" id="en"><span></span></a>
                <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/33-vseobecne-o-modelovani/?lang=sk" id="sk"><span></span></a>
                <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/33-vseobecne-o-modelovani/?action=&amp;pdf=1" id="pdf"><span></span></a>
              </div>
            </div>
          </div>  
              <nav id="breadcrumb">
                <a href="http://www.iolab.sk/">Domov</a>&nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp; <a href="http://www.iolab.sk/11-subjects/">Predmety</a>&nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp; <a href="http://www.iolab.sk/11-subjects/26-tar1/">TAR1</a>&nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/">Teória</a>&nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/">Modelovanie systémov</a>&nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/33-vseobecne-o-modelovani/">Všeobecne o modelovaní</a> 
              </nav>
        </div>
      </header>
      <div id="container"> 
        <aside id="container_aside" style="">
          
            <nav class="left">
              <h2>Modelovanie systémov</h2>
              <ul>
                <li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/33-vseobecne-o-modelovani/">Všeobecne o modelovaní</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/34-mechanicky-system/">Mechanický systém</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/37-elektricky-system/">Elektrický systém</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/42-elektromechanicky-system/">Elektromechanický systém</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/47-sustava-dvoch-spojenych-nadov/">Sústava dvoch spojených nádob</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/52-analogie/">Analógie</a></li>
              </ul>
            </nav>            
            
            <nav class="left">
              <h2>Teória</h2>
              <ul>
                <li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/29-uvod-do-matlabu/">Úvod do Matlabu</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/32-modelovanie-systemov/">Modelovanie systémov</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/53-algebra-prenosov/">Algebra prenosov</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/57-charakteristiky/">Charakteristiky</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/60-stabilita/">Stabilita</a></li><li>&gt; <a href="http://www.iolab.sk/11-subjects/26-tar1/28-teoria/65-stavovy-priestor/">Stavový priestor</a></li>
              </ul>
            </nav>            
                      
          <div id="prihlasovanie">
            <h2 style="cursor:pointer;">
              Prihlásiť sa            </h2>
            <div id="prihlasovanie_in" style="display:none;">
                          </div>
          </div>           
        </aside>
        <div id="content" style="min-height: 550px;">
        <?php
        include('content.php');
        ?>
   
          
        </div>           
      </div> 
      <div id="containter_clear"></div>            
      <footer style="">
        <div class="in">
          <div class="left">
          ioLAB - interaktívne online laboratórium          </div>
          <div class="right">
          Design by <a href="http://www.martinkollar.info/" target="_blank">Martin Kollár</a>
          </div>  
        </div>
      </footer>
    </div>
  

	
          
             </body></html>