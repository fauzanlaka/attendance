function checkEnter(){
    if(event.keyCode==13){
        check();
        return false;
    }
}
function check(){
    if(document.getElementById('teacher').value.length<10){
        
    }else{
        var URL = "function/scan.php?dummy=" + Math.random();
        var data = getFrmData('teacherForm');
        document.getElementById('checking').innerHTML = "Checking...";
        ajaxLoadFrw('post', URL, data, '');
    }
}