<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa DJ - IOT</title>
    <link rel="shortcut icon" type="imagex/png" href="./images/dj-mixer.ico">
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: Trebuchet MS, Helvetica, sans-serif;
        background: linear-gradient(135deg, #1a0033 0%, #2d1b4e 50%, #4a148c 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        color: #fff;
    }
    h1 {
        margin: 20px 0;
        font-size: 2.1em;
        text-shadow: 0 0 20px rgba(255, 215, 0, 0.7);
        letter-spacing: 3px;
        background: linear-gradient(45deg, #ffd700, #ff6b6b, #4ecdc4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .dj-mixer {
        background: linear-gradient(145deg, #2a1a4e, #1a0f2e);
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(255, 215, 0, 0.1);
        max-width: 1200px;
        width: 100%;
        border: 2px solid rgba(255, 215, 0, 0.3);
    }
    .deck-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); 
        gap: 30px;
        margin-bottom: 40px;
    }
    .deck {
        background: linear-gradient(145deg, #1a0f2e, #0f0820);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 215, 0, 0.2);
    }
    .deck-title {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.3em;
        color: #ffd700;
        text-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
    }
    .pad-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
        gap: 15px;
        margin-bottom: 20px;
    }
    .pad {
        aspect-ratio: 1;
        border: none;
        border-radius: 15px;
        font-size: 0.9em;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.1s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    .pad:active {
        transform: scale(0.95);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5), inset 0 2px 5px rgba(0, 0, 0, 0.5);
    }
    .pad.playing {
        animation: pulse 0.3s ease;
        box-shadow: 0 0 30px currentColor;
    }

    .button-pare{
            display: flex;
            justify-content: center;
            gap: 50px;
            min-height: 90px;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .kick { background: linear-gradient(180deg, #ff1744, #B22222, #800000); color: white; font-family: Georgia, serif;}
    .snare { background: linear-gradient(180deg, #FFD700,#DAA520, #B8860B); color: white; font-family: Georgia, serif;}
    .hihat { background: linear-gradient(180deg, #00BFFF, #1E90FF, #4169E1); color: white; font-family: Georgia, serif;}
    .clap { background: linear-gradient(180deg,#663399, #9400D3, #9932CC); color: white; font-family: Georgia, serif;}
    .bass { background: linear-gradient(180deg, #483D8B, #6A5ACD, #7B68EE); color: white; font-family: Georgia, serif;}
    .synth { background: linear-gradient(145deg, #00e676, #00b359); color: white; font-family: Georgia, serif;}
    .lead { background: linear-gradient(145deg, #DA70D6, #FF00FF, #FF69B4); color: white; font-family: Georgia, serif;}
    .chord { background: linear-gradient(145deg, #448aff, #3670cc); color: white; font-family: Georgia, serif;}
    .stop { background: linear-gradient(180deg, #ff1744, #B22222, #800000); color: white; font-family: Georgia, serif;}

    @media (min-width: 1024px) {
        body {
           
            overflow: hidden; 
        }
        h1 {
            font-size: 3.5em;
        }

        .dj-mixer {
            padding: 40px;
        }

        .deck-section {
            display: flex; 
            gap: 50px;
            justify-content: space-between;
            grid-template-columns: none; 
        }

        .deck {
            flex: 1;
        }
        
        .deck-title {
            font-size: 1.5em;
        }

        .pad-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .pad {
            font-size: 1em;
            min-height: 200px;
        }

        .button-pare{
            display: flex;
            justify-content: center;
            gap: 50px;
            min-height: 100px;
        }
    }




    </style>
</head>
<body>
    <h1>🎧 MESA DJ - IOT 🎧</h1>
    
    <div class="dj-mixer">
        <div class="deck-section">
           
            <div class="deck">
                <div class="deck-title">🎶 MÚSICAS</div>
                <div class="pad-grid" id="status-message">
                    <button class="pad kick" onclick="sendKey('g')">Música 1</button>
                    <button class="pad snare"onclick="sendKey('b')">Música 2</button>
                    <button class="pad hihat" onclick="sendKey('p')">Música 3</button>
                    <button class="pad clap" onclick="sendKey('n')">Música 4</button>
                    <button class="pad bass" onclick="sendKey('s')">Música 5</button>
                    <button class="pad synth"  onclick="sendKey('v')">Música 6</button>
                    <button class="pad lead"  onclick="sendKey('c')">Música 7</button>
                    <button class="pad chord"  onclick="sendKey('o')">Música 8</button>
                </div>
                <div class="button-pare">
                    <button class="pad stop" onclick="sendKey('x')">PARE</button>
                </div>
            </div>
            
    <script>
        const keyMap = {
            'g': '1', 'b': '2', 'p': '3', 'n': '4',
            's': '5', 'v': '6', 'c': '7', 'o': '8',
            'x': '0'
        }
        function sendKey(key){
            const soundName = keyMap[key];
            if(soundName){
                fetch(`iot.php?nome_som=${soundName}`)
                .then(response =>{
                    if(!response.ok){
                        throw new Error("Não está respondendo");
                    }
                    return response.text();
                })
            }
        }

        document.querySelectorAll('.pad').forEach(pad => {
            pad.addEventListener('click', function() {
                this.classList.add('playing');
                setTimeout(() => this.classList.remove('playing'), 300);
            });
        });
    </script>
</body>
</html>