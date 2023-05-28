function filledFields(){
    const form = document.querySelector('form');
    const name = form.elements['name'];
    const lastname = form.elements['lastname'];
    const email = form.elements['email'];
    const username = form.elements['username'];

    if(name.value.length>0){
        formStatus['name']='false';
    }
    if(lastname.value.length>0){
        formStatus['lastname']='false';
    }
    if(email.value.length>0){
        formStatus['email']='false';
    }
    if(username.value.length>0){
        formStatus['username']='false';
    }
}

function isFull(){
    const submit = document.querySelector('#submit');

    for(const state in formStatus){
        if(formStatus[state] === true){
            send = false;
            break;
        } else {
            send = true;
        }
    }

    if(send){
        submit.classList.add('active');
    } else {
        submit.classList.remove('active');
    }
}

function showPassword(event){
    const clicked = event.currentTarget;
    const input = clicked.parentNode.querySelector("input");
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.type = type;
    const source = input.getAttribute('type') === 'password' ? './assets/open.png' : './assets/closed.png';
    clicked.src = source;
}

function checkUsername(event){
    const username=event.currentTarget;

    if(username.value.length===0){
        username.parentNode.querySelector('span').classList.add('error');
    } else {
        username.parentNode.querySelector('span').classList.remove('error');
        formStatus['username'] = false;
        isFull();
    }
}

function checkPassword(event){
    const password = event.currentTarget;

    if(password.value.length == 0){
        password.parentNode.querySelector('span').classList.add('error');
    } else {
        password.parentNode.querySelector('span').classList.remove('error');
        formStatus['password'] = false;
        isFull();
    }
}

function sendForm(event){
    const form = document.querySelector('form');

    if(send){
        form.submit();
    } else {
        event.preventDefault();
    }
}

document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector(".password img").addEventListener('click', showPassword);
document.querySelector("#submit").addEventListener('click', sendForm);

const formStatus = { 'username': true, 'password': true };
let send = false;

filledFields();