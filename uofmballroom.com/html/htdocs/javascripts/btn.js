// JavaScript Document
1var btn = {
2 init : function() {
3 if (!document.getElementById || !document.createElement || !document.appendChild) return false;
4 as = btn.getElementsByClassName('btn(.*)');
5 for (i=0; i<as.length; i++) {
6 if ( as[i].tagName == "INPUT" && ( as[i].type.toLowerCase() == "submit" || as[i].type.toLowerCase() == "button" ) ) {
7 var a1 = document.createElement("a");
8 a1.appendChild(document.createTextNode(as[i].value));
9 a1.className = as[i].className;
10 a1.id = as[i].id;
11 as[i] = as[i].parentNode.replaceChild(a1, as[i]);
12 as[i] = a1;
13 as[i].style.cursor = "pointer";
14 }
15 else if (as[i].tagName == "A") {
16 var tt = as[i].childNodes;
17 }
18 else { return false };
19 var i1 = document.createElement('i');
20 var i2 = document.createElement('i');
21 var s1 = document.createElement('span');
22 var s2 = document.createElement('span');
23 s1.appendChild(i1);
24 s1.appendChild(s2);
25 while (as[i].firstChild) {
26 s1.appendChild(as[i].firstChild);
27 }
28 as[i].appendChild(s1);
29 as[i] = as[i].insertBefore(i2, s1);
30 }
31 // The following lines submits the form if the button id is "submit_btn"
32 btn.addEvent(document.getElementById('submit_btn'),'click',function() {
33 var form = btn.findForm(this);
34 form.submit();
35 });
36 // The following lines resets the form if the button id is "reset_btn"
37 btn.addEvent(document.getElementById('reset_btn'),'click',function() {
38 var form = btn.findForm(this);
39 form.reset();
40 });
41 },
42 findForm : function(f) {
43 while(f.tagName != "FORM") {
44 f = f.parentNode;
45 }
46 return f;
47 },
48 addEvent : function(obj, type, fn) {
49 if (obj.addEventListener) {
50 obj.addEventListener(type, fn, false);
51 }
52 else if (obj.attachEvent) {
53 obj["e"+type+fn] = fn;
54 obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
55 obj.attachEvent("on"+type, obj[type+fn]);
56 }
57 },
58 getElementsByClassName : function(className, tag, elm) {
59 var testClass = new RegExp("(^|\s)" + className + "(\s|$)");
60 var tag = tag || "*";
61 var elm = elm || document;
62 var elements = (tag == "*" && elm.all)? elm.all : elm.getElementsByTagName(tag);
63 var returnElements = [];
64 var current;
65 var length = elements.length;
66 for(var i=0; i<length; i++){
67 current = elements[i];
68 if(testClass.test(current.className)){
69 returnElements.push(current);
70 }
71 }
72 return returnElements;
73 }
74}
75
76btn.addEvent(window,'load', function() { btn.init();} );
77