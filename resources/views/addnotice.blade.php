@extends('master')

@section("app-mid")
<title>Ajout D'avis</title>
<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">

<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<div class="app-main">
    @include('tiles.actions')
    <div class="chat">


        <div class="messages">
            <ul class="message-list">

                <li class="message-item item-primary">
                    <p>{{ auth()->user()->name ?? 'please connect' }}</p>Vous pouvez ajouter un avis D'ici.
                </li>
            </ul>
            <div class="message-input">
                <input type="text" placeholder="Type your message..." />
                <button type="button" class="btn">Send</button>
            </div>
        </div>

    </div>
    <form action="#">
        <h1>choisir la filière</h1>

        <div class="form-group">
            <input class="form-control" id="checkbox-1" type="checkbox">
            <label for="checkbox-1">DUT-GI</label>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-2" type="checkbox">
            <label for="checkbox-2">DUT-GC</label>
            <div class="form-icon"><i class="fab fa-app-store"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-3" type="checkbox">
            <label for="checkbox-3">DUT-IDS</label>
            <div class="form-icon"><i class="fas fa-plane"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-4" type="checkbox">
            <label for="checkbox-4">DUT-GGM</label>
            <div class="form-icon"><i class="fab fa-bluetooth-b"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-5" type="checkbox">
            <label for="checkbox-5">DUT-GM</label>
            <div class="form-icon"><i class="fas fa-unlock unlock"></i><i class="fas fa-lock lock"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-6" type="checkbox">
            <label for="checkbox-6">DUT-AC</label>
            <div class="form-icon"><i class="fas fa-keyboard"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-7" type="checkbox">
            <label for="checkbox-7">DUT-IA</label>
            <div class="form-icon"><i class="fas fa-cogs"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-8" type="checkbox">
            <label for="checkbox-8">DUT-GB</label>
            <div class="form-icon"><i class="fas fa-headphones-alt"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-9" type="checkbox">
            <label for="checkbox-9">DUT-CTA</label>
            <div class="form-icon"><i class="fas fa-headphones-alt"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-10" type="checkbox">
            <label for="checkbox-10">LP-BIG DATA</label>
            <div class="form-icon"><i class="fas fa-headphones-alt"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-11" type="checkbox">
            <label for="checkbox-11">LP-BA</label>
            <div class="form-icon"><i class="fas fa-cogs"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-12" type="checkbox">
            <label for="checkbox-12">LP-SA</label>
            <div class="form-icon"><i class="fas fa-headphones-alt"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-13" type="checkbox">
            <label for="checkbox-13">LP-GC</label>
            <div class="form-icon"><i class="fas fa-headphones-alt"></i></div>
        </div>
        <div class="form-group">
            <input class="form-control" id="checkbox-14" type="checkbox">
            <label for="checkbox-14">LP-TIER</label>
            <div class="form-icon"><i class="fas fa-headphones-alt"></i></div>
        </div>
    </form>
</div>

<script>
    // Variables
    var messages = document.querySelector(".message-list");
    var btn = document.querySelector(".btn");
    var input = document.querySelector("input");

    // Button/Enter Key
    btn.addEventListener("click", sendMessage);
    input.addEventListener("keyup", function(e) {
        if (e.keyCode == 13) sendMessage();
    });

    // Messenger Functions
    function sendMessage() {
        var msg = input.value;
        input.value = "";
        writeLine(msg);
    }

    function addMessage(e) {
        var msg = e.data ? JSON.parse(e.data) : e;
        writeLine(`${msg.FROM}: ${msg.MESSAGE}`);
    }

    function writeLine(text) {
        var message = document.createElement("li");
        message.classList.add("message-item", "item-secondary");
        message.innerHTML = "{{ auth()->user()->name ?? 'please connect' }} : " + text;
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
    }
</script>
<style>
    @charset "UTF-8";

    * {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
    }

    body {
        background-color: #f4f4f4;
        font-family: "Roboto", sans-serif;
    }

    ul {
        list-style: none;
    }

    h1 {
        text-transform: uppercase;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
        color: #3c3c3e;
    }

    .chat {
        max-width: 400px;
        min-height: 400px;
        background-color: #fff;
        padding-right: 15px;
        padding-left: 15px;
        margin: 20px auto;
        border-radius: 1rem;
    }

    .messages {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 500px;
    }

    .message-list {
        overflow-y: scroll;
        max-height: 500px;
    }

    .message-item {
        display: flex;
        /* Make the li a flex container */
        align-items: center;
        /* Align items vertically */
        padding: 20px;
        border-radius: 0.75rem;
        margin: 20px 0;
    }

    .profile-text {
        margin-right: 5px;
        margin-top: 10px;
        /* Add some spacing between text and profile name */
    }

    .message-item:last-child {
        margin-bottom: 0;
    }

    .item-primary {
        background-color: #f6f7f8;
        color: #3c3c3e;
    }


    .item-secondary {
        background-color: #5ccad7;
        color: #fff;
    }

    .message-input {
        display: flex;
        padding: 20px 0;
    }

    .message-input input {
        width: 100%;
        padding: 10px;
        border-radius: 2rem;
        border: 1px solid #a5a5a5;
    }

    .message-input button {
        padding: 10px;
        margin-left: 10px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background-image: linear-gradient(to bottom, #973daa, #8b3cb2, #7c3db9, #683fc1, #4d41c9);
        width: 300px;
        color: #999;
        border: 1px solid rgba(0, 0, 0, 0.4);
        border-radius: 10px;
        box-shadow: 0 0 12px 4px rgba(0, 0, 0, 0.5);
    }

    form .form-group {
        padding: 0.7rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #7c3db9;
        position: relative;
        overflow: hidden;
    }

    form .form-group .form-control {
        display: none;
    }

    form .form-group .form-control+label:before {
        content: "✔";
        font-size: 0.8rem;
        border: 2px solid #999;
        border-radius: 0.2em;
        display: inline-block;
        height: 0.7em;
        width: 0.7em;
        padding: 0 0.1rem 0.25rem;
        margin-right: 1rem;
        color: transparent;
        cursor: pointer;
        transition: 0.2s;
        box-shadow: 0 1px 3px;
    }

    form .form-group .form-control+label:after {
        content: "";
        width: 150px;
        height: 100%;
        position: absolute;
        top: 0;
        left: -60%;
        background: rgba(0, 0, 0, 0.09);
        transform: skew(45deg);
        transition: 0.7s all;
    }

    form .form-group .form-control:hover+label:before {
        transform: scale(1.3);
    }

    form .form-group .form-control:checked+label {
        color: #f2f2f2;
    }

    form .form-group .form-control:checked+label:before {
        color: #03A9F4;
        border: 2px solid #03A9F4;
        transform: none;
    }

    form .form-group .form-control:checked+label:after {
        left: 120%;
    }

    form .form-group .form-control:checked~.form-icon {
        color: #03A9F4;
        -webkit-animation: animation 0.3s;
        animation: animation 0.3s;
    }

    form .form-group .form-control:checked~.form-icon .unlock {
        display: none;
    }

    form .form-group .form-control:checked~.form-icon .lock {
        display: inline-block;
    }

    form .form-group label {
        flex-grow: 1;
        transition: 0.2s;
    }

    form .form-group label:hover {
        color: #03A9F4;
    }

    form .form-group .form-icon {
        width: 20px;
        text-align: center;
    }

    form .form-group .form-icon .lock {
        display: none;
    }

    form .form-group:last-child {
        border: none;
    }

    @-webkit-keyframes animation {
        0% {
            opacity: 0;
            transform: rotate(30deg) scale(1.1);
        }

        50% {
            transform: rotate(-10deg);
        }

        75% {
            transform: rotate(20deg);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes animation {
        0% {
            opacity: 0;
            transform: rotate(30deg) scale(1.1);
        }

        50% {
            transform: rotate(-10deg);
        }

        75% {
            transform: rotate(20deg);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
@endsection



