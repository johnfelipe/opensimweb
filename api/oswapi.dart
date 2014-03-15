import 'dart:html';

void main() {
  ParagraphElement OnlineUsersp = querySelector("#UsersOnline");
  outputMessage(OnlineUsersp, 'farting?');
}

void outputMessage(Element e, String message){
  print(message);
  e.appendText(message);
  e.appendHtml('<br/>');
  e.scrollTop = e.scrollHeight;
}