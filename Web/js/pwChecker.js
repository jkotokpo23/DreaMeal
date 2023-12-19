function checkingPassword(){
    var pw1 = document.getElementById('password').value;
    var pw2 = document.getElementById('passwordconf').value;
    if(pw1 != pw2){
        alert("Mots de passe ne correspondent âs")
        return false;
    }
    return true;
}