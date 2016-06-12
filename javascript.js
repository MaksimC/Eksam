'use strict';

/***LOGIN BLOCK SCRIPT */

document.querySelector('#login_form_open button').addEventListener('click',

    function () {
        document.getElementById('login_form').style.display = 'block';
        document.getElementById('login_form_open').style.display = 'none';


        document.getElementById('register_form').style.display = 'none';
        document.getElementById('register_form_open').style.display = 'block';

    });



document.querySelector('#login_form_close button').addEventListener('click',

    function () {
        document.getElementById('login_form').style.display = 'none';
        document.getElementById('login_form_open').style.display = 'block';
    });

/*** REGISTER BLOCK SCRIPT */

document.querySelector('#register_form_open button').addEventListener('click',

    function () {
        document.getElementById('register_form').style.display = 'block';
        document.getElementById('register_form_open').style.display = 'none';

        document.getElementById('login_form').style.display = 'none';
        document.getElementById('login_form_open').style.display = 'block';
    });



document.querySelector('#register_form_close button').addEventListener('click',

    function () {
        document.getElementById('register_form').style.display = 'none';
        document.getElementById('register_form_open').style.display = 'block';
    });


