// Traitement Asynchrone

const forms = document.querySelectorAll('form');

forms.forEach(form => {
    if (form.getAttribute('async') != null) {
        form.onsubmit = function (e) {
            e.preventDefault();

            var message = document.getElementById('message');
            var alert = document.getElementById('alert');
            var data = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/async/'+form.getAttribute('async'), true);
            xhr.responseType = 'json';
            
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var res = this.response;
                    if (res.succes) {
                        if (res.reload == true) {
                            alert.innerHTML = '<div class="alert bg-success text-white"><i class="dripicons-checkmark mr-2"></i> '+res.message+'</div>';
                            document.location.reload();
                        } else if (res.redirection != null) {
                            alert.innerHTML = '<div class="alert bg-success text-white"><i class="dripicons-checkmark mr-2"></i> '+res.message+'</div>';
                            document.location.href = res.redirection;
                        } else {
                            $.NotificationApp.send('Réussi !', res.message, 'top-right', 'rgba(0,0,0,0.2)', 'success');
                            alert.style.display = 'none';
                            message.style.display = 'block';
                        }
                    } else {
                        if (res.reload == true) {
                            alert.innerHTML = '<div class="alert bg-danger text-white"><i class="dripicons-wrong mr-2"></i> '+res.message+'</div>';
                            document.location.reload();
                        } else if (res.redirection != null) {
                            alert.innerHTML = '<div class="alert bg-danger text-white"><i class="dripicons-wrong mr-2"></i> '+res.message+'</div>';
                            document.location.href = res.redirection;
                        } else {
                            $.NotificationApp.send('Erreur !', res.message, 'top-right', 'rgba(0,0,0,0.2)', 'error');
                            alert.style.display = 'none';
                            message.style.display = 'block';
                        }
                        grecaptcha.reset();
                    }
                } else if (this.readyState == 4) {
                    $.NotificationApp.send('Erreur !', 'Une erreur est survenue...', 'top-right', 'rgba(0,0,0,0.2)', 'error');
                    grecaptcha.reset();
                }
            };
            xhr.send(data);
            
            message.style.display = 'none';
            alert.style.display = 'block';
            alert.innerHTML = '<div class="alert bg-warning text-white"><div class="spinner-border spinner-border-sm"></div> Traitement en cours...</div>';
            
            return false;
        }
    }
});

function password (input) {
    var message = document.getElementById('password_message');
    var reponse = 'Aucun mot de passe rentré';
    var color = '';
    
    var verifs = new Array();
    verifs.push('[a-z]');
    verifs.push('[A-Z]');
    verifs.push('[0-9]');
    verifs.push('[$@$!%*#?&]');
  
    var solidite = 0;
    verifs.forEach(verif => {
        if (new RegExp(verif).test(input.value)) {
            solidite++;
        }
    });
    
    if (solidite == 1) {
        reponse = 'Très faible';
        color = 'red';
    } else if (solidite == 2) {
        reponse = 'Faible';
        color = 'red';
    } else if (solidite == 3) {
        reponse = 'Normal';
        color = 'orange';
    } else if (solidite == 4) {
        reponse = 'Fort';
        color = 'green';
    }
  
    message.innerHTML = reponse;
    message.style.color = color;
}

const custom_files = document.querySelectorAll('.custom-file');

custom_files.forEach(custom_file => {
    const custom_file_label = custom_file.querySelector('.custom-file-label');
    const custom_file_input = custom_file.querySelector('.custom-file-input');
    custom_file_input.onchange = function () {
        custom_file_label.innerHTML = custom_file_input.files[0].name;
    }
});

var notif = document.querySelector('.noti-icon-badge');
                            
notif.parentNode.onclick = function () {
    var date = new Date();
    date.setTime(date.getTime()+1*24*60*60*1000);
    document.cookie = 'notif=1;expires='+date.toUTCString()+';path=/';
    
    notif.style.display = 'none';
}

if (document.cookie.match(/notif=1;/)) {
    notif.style.display = 'none';
}

if (screen.width < 1300){
    const swipez = document.querySelectorAll('.swipez');
    for (var i=0;i<swipez.length; i++) {
        swipez[i].innerHTML = 'Swipez pour générer <i class="mdi mdi-arrow-right-bold"></i>';
    }
}

const passwords = document.querySelectorAll('input[type=password]');

passwords.forEach(password => {
    var input_group = document.createElement('div');
    input_group.className = 'input-group';
    var input_group_append = document.createElement('div');
    input_group_append.className = 'input-group-append';
    var bouton = document.createElement('button');
    bouton.className = 'btn btn-primary';
    bouton.type = 'button';
    bouton.innerHTML = '<i class="mdi mdi-eye"></i>';
    bouton.onclick = function () {
        if (password.type == 'text') {
            password.type = 'password';
            bouton.innerHTML = '<i class="mdi mdi-eye"></i>';
        } else {
            password.type = 'text';
            bouton.innerHTML = '<i class="mdi mdi-eye-off"></i>';
        }
    }
    password.parentNode.appendChild(input_group);
    input_group.appendChild(password);
    input_group.appendChild(input_group_append);
    input_group_append.appendChild(bouton);
});