
var login_event = document.querySelector(".login");
var cadastro_event = document.querySelector(".cadastro");
var log = document.querySelector(".main .log");
var cad = document.querySelector(".main .cad");
var teste = 1;

/*
function login(){
    var user_log = log.querySelector("#user");
    var senha_log = log.querySelector("#senha");

    
    var user_text = user_log.value;
    var senha_text = senha_log.value;


    if(user_text=="" || user_text == " "){
        user_log.classList.add("erro");
    }
    else{
        user_log.classList.remove("erro");
    }

    if(senha_text == "" || senha_text == " "){
        senha_log.classList.add("erro");
    }
    else{
        senha_log.classList.remove("erro");
    }


    if((senha_text == "" || senha_text == " ") || (user_text=="" || user_text == " ")){
        login_event.setAttribute("href", "#");
    } else{
        login_event.setAttribute("href", "serviços.html");
    }
}
*/

let userCampLogin = document.getElementById("user");
let passwordCampLogin = document.getElementById("senha");
let checkbox = document.getElementById("ver_senha");
let button = document.getElementById("buttonLogin");
let buttonCad = document.getElementById("buttonCadastro");
let checkboxCad =document.getElementById("ver_senhaCad");

checkbox.addEventListener("click", versenha);
checkboxCad.addEventListener("click", versenhaCadastro);
button.addEventListener("click", validateLogin);
buttonCad.addEventListener("click", validateCadastro);


function versenha(){
    if(passwordCampLogin.type == "password"){
        passwordCampLogin.type = "text";
    }
    else{
        passwordCampLogin.type = "password";
    }
}

function versenhaCadastro(){
    let password1 = document.getElementById("pass1");
    let password2 = document.getElementById("pass2");

    if(password1.type == "password"){
        password1.type = "text";
        password2.type = "text";
    }
    else{
        password1.type = "password";
        password2.type = "password";
    }
}

function validateLogin(e){
    let errorLog = document.getElementById("error-msg-login");
    let errorMsg = null;
    let spaces = 0;
    let spaces_user = 0;
    let spaces_pass = 0;
    let i;

    let user = userCampLogin.value;
    let pass = passwordCampLogin.value;

    for(i = 0; i < user.length; i++){
        if(user[i] == ' '){
            spaces_user++;
            spaces++;
            userCampLogin.classList.add("error-camp");
        }
    }


    if(spaces_user == 0){
        userCampLogin.classList.remove("error-camp");
    }

    for(i = 0; i < pass.length; i++){
        if(pass[i] == ' '){
            spaces_pass++;
            spaces++;
            passwordCampLogin.classList.add("error-camp");
        }
    }

    if(spaces_pass == 0){
        passwordCampLogin.classList.remove("error-camp");
    }

    if(pass == "" | user == "" || spaces > 0){
        errorMsg = "Usuário ou Senha inválidos(s)!";
        e.preventDefault();
    }

    if(pass == ""){
        passwordCampLogin.classList.add("error-camp");
    }
    else{
        passwordCampLogin.classList.remove("error-camp");
    }

    if(user == ""){
        userCampLogin.classList.add("error-camp");
    }
    else{
        userCampLogin.classList.remove("error-camp");
    }

    if(errorMsg != null){
        errorLog.innerHTML = errorMsg;
        if(errorLog.classList.contains("slide") == false){
            errorLog.classList.add("slide");
            setTimeout(() => {
                errorLog.classList.remove("slide");
            }, 3000);
        }
    }
    

}

function validateCadastro(e){
    let vazios = 0;
    let errorLog = document.getElementById("error-msg-login");
    let errorMsg = null;
    let cpf = document.getElementById("cpf");
    let password1 = document.getElementById("pass1");
    let password2 = document.getElementById("pass2");
    let cep = document.getElementById("cep");

    let camps = document.querySelectorAll(".cad .text");
    camps.forEach(camp => {
        camp.value = camp.value.trim();
        if(camp.value == ""){
            camp.classList.add("error-camp");
            vazios++;
        }
        else{
            camp.classList.remove("error-camp");
        }
    });

    if(vazios > 0){
        errorMsg = "Campo(s) Vazio(s)/Inválidos(s)!";
    }
    else{
        if(cpf.value.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333"|| cpf == "44444444444"|| cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999" || isNaN(cpf.value) == true){
            errorMsg = "CPF inválido!";
            cpf.classList.add("error-camp");
        }
        else{
            cpf.classList.remove("error-camp");
            if(password1.value != password2.value){
                errorMsg = "Senhas não coincidem!";
                password1.classList.add("error-camp");
                password2.classList.add("error-camp");
            }
            else if(password1.value.length < 8){
                errorMsg = "A senha deve ter no mínimo 8 caracteres!";
                password1.classList.add("error-camp");
                password2.classList.add("error-camp");
            }
            else{
                password1.classList.remove("error-camp");
                password2.classList.remove("error-camp");
                if(cep.value.length != 8 || cep.value == "00000000" || isNaN(cep.value) == true){
                    errorMsg = "CEP inválido!";
                    cep.classList.add("error-camp");
                }
                else{
                    cep.classList.remove("error-camp");
                }
            }
        }
    }

    if(errorMsg != null){
        e.preventDefault();
        errorLog.innerHTML = errorMsg;
        if(errorLog.classList.contains("slide") == false){
            errorLog.classList.add("slide");
            setTimeout(() => {
                errorLog.classList.remove("slide");
            }, 3000);
        }
    }
}





/*
function cadastro(){
    var user_cad = cad.querySelector(".cad .user");
    var email_cad = cad.querySelector(".cad .email");
    var senha_cad = cad.querySelector(".cad .senha");
    var repSenha_cad = cad.querySelector(".cad .rep_senha");
    var cep = cad.querySelector(".cad .cep");
    
    var email_text = email_cad.value;
    var user_text = user_cad.value;
    var senha_text = senha_cad.value;
    var repSenha_text = repSenha_cad.value;
    var cep_text = cep.value;

    var teste_arroba = email_text.indexOf("@");
    var teste_ponto = email_text.indexOf(".");
    var teste_espaço = email_text.indexOf(" ");


    if(email_text == "" || email_text == " "){
        email_cad.classList.add("erro");
    }
    else{
        email_cad.classList.remove("erro");

        if((teste_arroba == -1) || (teste_ponto == -1)){
            email_cad.value = "";
            email_cad.setAttribute("placeholder", "Email inválido");
            email_cad.classList.add("erro");
            console.log("tese")
        }else{
            if((email_text[teste_arroba-1] == "" || email_text[teste_arroba-1] == " ") || (email_text[teste_arroba+1] == "" || email_text[teste_arroba+1] == " ") || (email_text[teste_ponto-1] == "" || email_text[teste_ponto-1] == " ") || (email_text[teste_ponto+1] == "" || email_text[teste_ponto+1] == " ") || (teste_espaço != -1)){
                email_cad.value = "";
                email_cad.setAttribute("placeholder", "Email inválido");
                email_cad.classList.add("erro");
            }
        }
    }


    if(user_text=="" || user_text == " "){
        user_cad.classList.add("erro");
    }
    else{
        user_cad.classList.remove("erro");
    }


    if(senha_text == "" || senha_text == " "){
        senha_cad.classList.add("erro");
    }
    else{
        senha_cad.classList.remove("erro");
    }


    if(repSenha_text == "" || repSenha_text == " "){
        repSenha_cad.classList.add("erro");
        if(repSenha_text != senha_text){
            senha_cad.value = "hdhd";
            repSenha_cad.setAttribute("placeholder", "As senhas não diferentes")
        }
    }

    else{
        repSenha_cad.classList.remove("erro");
        if(repSenha_text != senha_text){
            repSenha_cad.value = "";
            repSenha_cad.setAttribute("placeholder", "As senhas não diferentes");
            repSenha_cad.classList.add("erro");
        }
    }
    

    if(cep_text == "" || cep_text == " "){
        cep.classList.add("erro");
    }
    else{
        cep.classList.remove("erro");
        if(cep_text.length != 8){
            cep.value = "";
            cep.setAttribute("placeholder", "CEP inválido");
            cep.classList.add("erro");
        }
        if(cep_text == "00000000"){
            cep.value = "";
            cep.setAttribute("placeholder", "00000000 não é um CEP válido");
            cep.classList.add("erro");
        }
    }


    if((senha_text == "" || senha_text == " ") || 
    (user_text =="" || user_text == " ") ||
    (email_text =="" || email_text == " ") || 
    (repSenha_text =="" ||repSenha_text  == " ") || 
    (cep_text =="" || cep_text == " ")){
        cadastro_event.setAttribute("href", "#");
    } else{
        cadastro_event.setAttribute("href", "serviços.html");
    }
}


function ver_senha_cad(){
    var senha_cad = cad.querySelector(".cad .senha");
    var repSenha_cad = cad.querySelector(".cad .rep_senha");
    var teste = senha_cad.classList.contains("texto_p");

    if(teste == false){
        senha_cad.type = "text";
        senha_cad.classList.remove("pass");
        senha_cad.classList.add("texto_p");

        repSenha_cad.type = "text";
        repSenha_cad.classList.remove("pass");
        repSenha_cad.classList.add("texto_p");
    }
    else{
        senha_cad.type = "password";
        senha_cad.classList.remove("texto_p");
        senha_cad.classList.add("pass");

        repSenha_cad.type = "password";
        repSenha_cad.classList.remove("pass");
        repSenha_cad.classList.add("texto_p");
    }
}
*/

function slide_img(){
    let img = document.querySelector("#slideImg");
    img.classList.toggle("img-slided");
    
}