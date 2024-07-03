@extends('master')
@section("app-mid")
<title>Terminal</title>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700&display=swap">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Source Code Pro', monospace;
        background-color: #001f3f; /* Adjust background color as needed */
        color: #fff;
    }
    .app-main {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
    }
    #terminal {
        background-color: #000;
        color: #0f0;
        padding: 10px;
        border-radius: 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        width: 100%;
        box-sizing: border-box;
    }
    #terminalInput {
        flex: 1; 
        background: #000;  
        color: #0f0;
        border: none;
        outline: none;
        font-family: 'Source Code Pro', monospace; 
        width: 100%;
        box-sizing: border-box;
    }
    #terminalOutput {
        white-space: pre;
        margin-bottom: 10px;
        font-family: 'Source Code Pro', monospace;
    }
    .header {
        font-weight: bold;
        color: grey;
        padding-bottom: 10px;
    }
    .prompt {
        display: flex;
        align-items: center;
        color: blue;
    }
    .prompt span {
        white-space: nowrap;
        font-family: 'Source Code Pro', monospace;
    }
</style>

<div class="app-main">
    @include('tiles.actions')
    <div id="terminal">
        <pre class="header">
___________________________________________________________________________________
|                                                                                 |
|     :::::::   :::::::  :::::::::::         :::::::::  :::::::::      ::::::::   |
|    :*/      :*/           */              */         /*      /**   :*/          |
|   :*:::::  :*:*:*:       */    *******   *:::::::   /*::::::**    :*:*:*:*      |
|  :*/            /*      */              */         /*        **         /*      |
| :**::::  *:*:*:*       */              */         /*:*:*:*:*     *:*:*:*        |
|                                                                                 |
-----------------------------------------------------------------------------------
        </pre>
        <pre class="header">{{ auth()->user()->name }}, welcome to terminal, type help? to get available commands.</pre>
        <div id="terminalOutput"></div>
        <div class="prompt">
            <span id="prompt" data-username="{{ auth()->user()->name }}"></span><input type="text" id="terminalInput" onkeydown="handleInput(event)">
        </div>
    </div>
    <script>
        document.getElementById('terminalInput').focus();

        const username = document.getElementById('prompt').getAttribute('data-username').toLowerCase();
        document.getElementById('prompt').innerText = `$${username} > `;

        const commandHistory = [];
        let historyIndex = -1;

        function handleInput(event) {
            if (event.key === 'Enter') {
                executeCommand();
            } else if (event.key === 'ArrowUp') {
                navigateHistory('up');
            } else if (event.key === 'ArrowDown') {
                navigateHistory('down');
            }
        }

        function navigateHistory(direction) {
            if (direction === 'up') {
                if (historyIndex > 0) {
                    historyIndex--;
                    document.getElementById('terminalInput').value = commandHistory[historyIndex];
                }
            } else if (direction === 'down') {
                if (historyIndex < commandHistory.length - 1) {
                    historyIndex++;
                    document.getElementById('terminalInput').value = commandHistory[historyIndex];
                } else {
                    historyIndex = commandHistory.length;
                    document.getElementById('terminalInput').value = '';
                }
            }
        }

        function checkInternetConnection() {
            return navigator.onLine;
        }

        function executeCommand() {
            const inputElement = document.getElementById('terminalInput');
            const command = inputElement.value.trim();
            const outputElement = document.getElementById('terminalOutput');

            if (command) {
                commandHistory.push(command);
                historyIndex = commandHistory.length;

                if (!checkInternetConnection()) {
                    appendOutput(`$${username} > ${command}\nError: No internet connection. Please connect to the internet and try again.\n`);
                    inputElement.value = '';
                    return;
                }

                if (command.toLowerCase() === 'help?') {
                    appendOutput(`$${username} > ${command}\nAvailable commands:\n- help?: Display this help message\n- clear: Clear the terminal\n- list usr: list all the existing users\n- count usr: count all the existing users\n- count laureats: count all the existing laureats\n- count laureats>year :count all the existing laureats of each year\n- count laureats>diploma: count all laureats of each diploma\n- count laureats>diploma>year :displays the count of all the laureats by year and by diploma at the same time\n- count usr>student :returns all students\n- count usr>student>activity :returns the number of active students and the number of inactive\n- count usr>student>sexe>activity : returns how many active male and how many active female\n- count usr>student>sexe>activity>byyear : returns how many active male and how many active female yearly\n- count student>has_uploaded :returns the count of uploads grouped by type (initiation-technique...)\n- list dip :give an overview about existing diplomas\n- list staff>teacher :lists the informations about teachers\n`);
                } else if (command.toLowerCase() === 'clear') {
                    outputElement.innerText = '';
                } else {
                    axios.post('{{ route('terminal.execute') }}', { command })
                        .then(response => {
                            appendOutput(`$${username} > ${command}\n${JSON.stringify(response.data.result, null, 2)}\n`);
                        })
                        .catch(error => {
                            appendOutput(`$${username} > ${command}\nError: ${error.response.data.result}\n`);
                        });
                }
                inputElement.value = '';
            }

            inputElement.focus();
        }

        function appendOutput(text) {
            const outputElement = document.getElementById('terminalOutput');
            outputElement.innerText += text;
            outputElement.scrollTop = outputElement.scrollHeight;
        }
    </script>
</div>
@endsection
