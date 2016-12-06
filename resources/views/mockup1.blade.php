@extends('master')

@section('title')
	Hok
@stop

@section('custom_top_scripts')
    <!-- maxima -->
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/jquery-1.6.2.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="{{ url('/') }}/applications/hok/ioLAB_files/shCore.css" type="text/css">
    <link rel="stylesheet" href="{{ url('/') }}/applications/hok/ioLAB_files/shThemeDefault.css" type="text/css">
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/shCore.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/shBrushJScript.js"></script>

    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/jquery.jqplot.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/applications/hok/ioLAB_files/jquery.jqplot.css">

    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/script.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/ajaxupload.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/excanvas.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/jquery.flot.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/MathJax.js">
        MathJax.Hub.Config({
            extensions: ["tex2jax.js"],
            jax: ["input/TeX", "output/HTML-CSS"],
            tex2jax: {inlineMath: [["$", "$"], ["\\(", "\\)"]]}
        });
    </script>
    <style type="text/css">.MathJax_Preview {
            color: #888
        }

        #MathJax_Message {
            position: fixed;
            left: 1em;
            bottom: 1.5em;
            background-color: #E6E6E6;
            border: 1px solid #959595;
            margin: 0px;
            padding: 2px 8px;
            z-index: 102;
            color: black;
            font-size: 80%;
            width: auto;
            white-space: nowrap
        }

        #MathJax_MSIE_Frame {
            position: absolute;
            top: 0;
            left: 0;
            width: 0px;
            z-index: 101;
            border: 0px;
            margin: 0px;
            padding: 0px
        }

        .MathJax_Error {
            color: #CC0000;
            font-style: italic
        }
    </style>
    <!-- -->

    <!-- prihlásenie -->
    <script src="{{ url('/') }}/applications/hok/ioLAB_files/jquery.min.js"></script>
    <script src="{{ url('/') }}/applications/hok/ioLAB_files/jquery.form.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/applications/hok/ioLAB_files/main.js"></script>
    <style type="text/css">#MathJax_About {
            position: fixed;
            left: 50%;
            width: auto;
            text-align: center;
            border: 3px outset;
            padding: 1em 2em;
            background-color: #DDDDDD;
            color: black;
            cursor: default;
            font-family: message-box;
            font-size: 120%;
            font-style: normal;
            text-indent: 0;
            text-transform: none;
            line-height: normal;
            letter-spacing: normal;
            word-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            float: none;
            z-index: 201;
            border-radius: 15px;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            -khtml-border-radius: 15px;
            box-shadow: 0px 10px 20px #808080;
            -webkit-box-shadow: 0px 10px 20px #808080;
            -moz-box-shadow: 0px 10px 20px #808080;
            -khtml-box-shadow: 0px 10px 20px #808080;
            filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color='gray', Positive='true')
        }

        #MathJax_About.MathJax_MousePost {
            outline: none
        }

        .MathJax_Menu {
            position: absolute;
            background-color: white;
            color: black;
            width: auto;
            padding: 2px;
            border: 1px solid #CCCCCC;
            margin: 0;
            cursor: default;
            font: menu;
            text-align: left;
            text-indent: 0;
            text-transform: none;
            line-height: normal;
            letter-spacing: normal;
            word-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            float: none;
            z-index: 201;
            box-shadow: 0px 10px 20px #808080;
            -webkit-box-shadow: 0px 10px 20px #808080;
            -moz-box-shadow: 0px 10px 20px #808080;
            -khtml-box-shadow: 0px 10px 20px #808080;
            filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color='gray', Positive='true')
        }

        .MathJax_MenuItem {
            padding: 2px 2em;
            background: transparent
        }

        .MathJax_MenuArrow {
            position: absolute;
            right: .5em;
            padding-top: .25em;
            color: #666666;
            font-size: .75em
        }

        .MathJax_MenuActive .MathJax_MenuArrow {
            color: white
        }

        .MathJax_MenuArrow.RTL {
            left: .5em;
            right: auto
        }

        .MathJax_MenuCheck {
            position: absolute;
            left: .7em
        }

        .MathJax_MenuCheck.RTL {
            right: .7em;
            left: auto
        }

        .MathJax_MenuRadioCheck {
            position: absolute;
            left: 1em
        }

        .MathJax_MenuRadioCheck.RTL {
            right: 1em;
            left: auto
        }

        .MathJax_MenuLabel {
            padding: 2px 2em 4px 1.33em;
            font-style: italic
        }

        .MathJax_MenuRule {
            border-top: 1px solid #CCCCCC;
            margin: 4px 1px 0px
        }

        .MathJax_MenuDisabled {
            color: GrayText
        }

        .MathJax_MenuActive {
            background-color: Highlight;
            color: HighlightText
        }

        .MathJax_MenuDisabled:focus, .MathJax_MenuLabel:focus {
            background-color: #E8E8E8
        }

        .MathJax_ContextMenu:focus {
            outline: none
        }

        .MathJax_ContextMenu .MathJax_MenuItem:focus {
            outline: none
        }

        #MathJax_AboutClose {
            top: .2em;
            right: .2em
        }

        .MathJax_Menu .MathJax_MenuClose {
            top: -10px;
            left: -10px
        }

        .MathJax_MenuClose {
            position: absolute;
            cursor: pointer;
            display: inline-block;
            border: 2px solid #AAA;
            border-radius: 18px;
            -webkit-border-radius: 18px;
            -moz-border-radius: 18px;
            -khtml-border-radius: 18px;
            font-family: 'Courier New', Courier;
            font-size: 24px;
            color: #F0F0F0
        }

        .MathJax_MenuClose span {
            display: block;
            background-color: #AAA;
            border: 1.5px solid;
            border-radius: 18px;
            -webkit-border-radius: 18px;
            -moz-border-radius: 18px;
            -khtml-border-radius: 18px;
            line-height: 0;
            padding: 8px 0 6px
        }

        .MathJax_MenuClose:hover {
            color: white !important;
            border: 2px solid #CCC !important
        }

        .MathJax_MenuClose:hover span {
            background-color: #CCC !important
        }

        .MathJax_MenuClose:hover:focus {
            outline: none
        }
    </style>
    <style type="text/css">#MathJax_Zoom {
            position: absolute;
            background-color: #F0F0F0;
            overflow: auto;
            display: block;
            z-index: 301;
            padding: .5em;
            border: 1px solid black;
            margin: 0;
            font-weight: normal;
            font-style: normal;
            text-align: left;
            text-indent: 0;
            text-transform: none;
            line-height: normal;
            letter-spacing: normal;
            word-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            float: none;
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
            box-shadow: 5px 5px 15px #AAAAAA;
            -webkit-box-shadow: 5px 5px 15px #AAAAAA;
            -moz-box-shadow: 5px 5px 15px #AAAAAA;
            -khtml-box-shadow: 5px 5px 15px #AAAAAA;
            filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Color='gray', Positive='true')
        }

        #MathJax_ZoomOverlay {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 300;
            display: inline-block;
            width: 100%;
            height: 100%;
            border: 0;
            padding: 0;
            margin: 0;
            background-color: white;
            opacity: 0;
            filter: alpha(opacity=0)
        }

        #MathJax_ZoomFrame {
            position: relative;
            display: inline-block;
            height: 0;
            width: 0
        }

        #MathJax_ZoomEventTrap {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 302;
            display: inline-block;
            border: 0;
            padding: 0;
            margin: 0;
            background-color: white;
            opacity: 0;
            filter: alpha(opacity=0)
        }
    </style>
@stop

@section('content')
    <div id="MathJax_Message" style="display: none;"></div>
    <div id="wrapper">
        <div id="container">
            <div id="content" style="min-height: 550px;">
                <h1>Interaktívny 3D WebGL model Segway vozidla</h1>
                <script type="text/javascript" src="{{ url('/') }}/applications/hok/js/jQuery.js"></script>
                <script type="text/javascript" src="{{ url('/') }}/applications/hok/js/googleGraphs.js"></script>
                <style>

                    #resetButton {
                        display: none;
                    }

                    .pidAll {
                        float: right;
                    }

                    #graf {
                        display: none;
                    }
                    #graf div {
                        position: relative !important;
                    }

                    #loadingGif {
                        display: none;
                        position: absolute;
                        bottom: 0%;
                        right: 0%;
                    }

                    #webGLWindow {
                        position: relative;
                        width: 100%;
                        height: 500px
                    }
                </style>
                <div class="col-sm-12 mockup">
                    <div class="row">
                        <div class="col-md-3">
                            <form id="segwayInputs">
                                <div class="form-group">
                                    <label for="timeInput">Trvanie animácie:</label>
                                    <input class="form-control" name="time" value="5" id="timeInput" type="text" placeholder="Zadaj čas v sekundách"
                                           onchange="checkTimeInput(this.value)">
                                </div>
                                <input name="angle" id="angleInput" hidden>
                                <div class="form-group">
                                    <label for="degreeInput">Počiatočný uhol v stupňoch:</label>
                                    <input class="form-control" name="degree" value="30" id="degreeInput" type="text" placeholder="Zadaj uhol v stupňoch"
                                           onchange="checkDegreeInput(this.value)">
                                </div>
                                <div class="form-group">
                                    <label for="usr">Počiatočná rýchlosť vozidla v m/s:</label>
                                    <input class="form-control" name="speed" value="5" id="speedInput" type="text" placeholder="Zadaj rýchlosť"
                                           onchange="checkSpeedInput(this.value)">
                                </div>
                                <label for="usr">Použiť PID regulátor:</label>
                                <div class="radio">
                                    <label><input id="pidYes" name="pid" type="radio" value="SegwayPID.mo" checked onclick="showPid()">Áno</label>
                                </div>

                                <input id="pidNo" name="pid" type="radio" value="SegwayOnly.mo" onclick="hidePid()">
                                <label for="pidNo">nie</label>
                                <div id="pidPart">
                                    <label for="pInput">P: </label>
                                    <input class="form-control" name="p" type="text" value="18" id="pInput" onchange="checkPInput(this.value)"><br>
                                    <label for="iInput">I: </label>
                                    <input class="form-control" name="i" type="text" value="20" id="iInput" onchange="checkIInput(this.value)"><br>
                                    <label for="dInput">D: </label>
                                    <input class="form-control" name="d" type="text" value="0.1" id="dInput" onchange="checkDInput(this.value)"><br>
                                </div>
                                <button type="submit" id="submitButton" style="display: inline-block;margin: 10px 0;width: 105px;" class="btn btn-success btn-md">Generovať</button>
                                <button type="button" id="grafBan" onclick="grafOnOff()" class="btn btn-success btn-md">Skryť Graf</button>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div id="webGLWindow">
                                <div id="webGL" style="position: absolute; width: 100%; height: 100%"></div>
                                <img id="loadingGif" src="{{ url('/') }}/applications/hok/loading.gif" alt="loading gif">
                            </div>
                        </div>
                    </div>
                    <div id="graf" style="height: 250px;"></div>
                </div>

                <button type="button" id="resetButton" onclick="reset()">Reset</button>

                <script src="{{ url('/') }}/applications/hok/js/three/three.min.js"></script>
                <script src="{{ url('/') }}/applications/hok/js/three/Animation.js"></script>
                <script src="{{ url('/') }}/applications/hok/js/three/AnimationHandler.js"></script>
                <script src="{{ url('/') }}/applications/hok/js/three/KeyFrameAnimation.js"></script>

                <script src="{{ url('/') }}/applications/hok/js/three/ColladaLoader.js"></script>
                <script src="{{ url('/') }}/applications/hok/js/three/OrbitControls.js"></script>
                <script src="{{ url('/') }}/applications/hok/js/three/Detector.js"></script>
                <script src="{{ url('/') }}/applications/hok/js/three/stats.min.js"></script>
                <script src="{{ url('/') }}/applications/hok/js/code.js"></script>


            </div>
        </div>
        <div id="containter_clear"></div>
    </div>
@stop

@section('custom_bottom_scripts')
@stop