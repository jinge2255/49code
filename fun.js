function GetSelectedText()
{
  var selectedText=(
        window.getSelection
        ?
            window.getSelection()
        :
            document.getSelection
            ?
                document.getSelection()
            :
                document.selection.createRange().text
     );
 if(!selectedText || selectedText=="")
 {
    if(document.activeElement.selectionStart)
    {
     selectedText = document.activeElement.value.substring(
          document.activeElement.selectionStart
          . document.activeElement.selectionEnd);
    }
 }
 return selectedText;
 console.log(selectedText);
 alert(selectedText);
}