<link rel=stylesheet href="Web/codemirror-5.7/lib/codemirror.css">
<script src="Web/codemirror-5.7/lib/codemirror.js"></script>
<script src="Web/codemirror-5.7/mode/xml/xml.js"></script>
<script src="Web/codemirror-5.7/mode/clike/clike.js"></script>
<script src="Web/codemirror-5.7/mode/php/php.js"></script>
<script src="Web/codemirror-5.7/mode/javascript/javascript.js"></script>
<script src="Web/codemirror-5.7/mode/css/css.js"></script>
<script src="Web/codemirror-5.7/mode/htmlmixed/htmlmixed.js"></script>
<script src="Web/codemirror-5.7/addon/mode/simple.js"></script>

<style>
  .CodeMirror { height: auto; border: 1px solid #ddd;}
  .CodeMirror-scroll { max-width: auto; }
  .CodeMirror pre { padding-left: 7px; line-height: 1.25; }
</style>

<textarea id='textEditWindow'>

</textarea>
<script>
  var editor = CodeMirror.fromTextArea(document.getElementById("textEditWindow"), {
	lineNumbers: true,
	mode: "simplemode",
	matchBrackets: true
  });
  $('.CodeMirror').css('display','none');
</script>
<script src="Web/JS/CodeEditor.js"></script>