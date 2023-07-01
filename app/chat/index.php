<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
        Simple chat app
        </title>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            setup();
        }); // document.addEventListener

        let keyPair = null;
        async function setup() {
            // generate private/public key pair
            // https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/generateKey
            keyPair = await window.crypto.subtle.generateKey(
              {
                name: "RSA-OAEP",
                modulusLength: 4096,
                publicExponent: new Uint8Array([1, 0, 1]),
                hash: "SHA-256",
              },
              true,
              ["encrypt", "decrypt"]
            );

            /*
            Export the given key and write it into the "exported-key" space.
            */
            const exported = await window.crypto.subtle.exportKey("spki", keyPair.publicKey);
            const exportedAsString = String.fromCharCode.apply(null, new Uint8Array(exported));
            const exportedAsBase64 = window.btoa(exportedAsString);
            const pemExported = `-----BEGIN PUBLIC KEY-----\n${exportedAsBase64}\n-----END PUBLIC KEY-----`;

            const exportKeyOutput = document.querySelector(".exported-key");
            exportKeyOutput.textContent = pemExported;
            exportKeyOutput.textContent += "\n key length: " + pemExported.length + "\n";

            // hitting enter on the text clicks the button
            input = document.getElementById("text");
            input.addEventListener("keypress", function(event) {
                // If the user presses the "Enter" key on the keyboard
                if (event.key === "Enter") {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    // Trigger the button element with a click
                    document.getElementById("button").click();
                }
            }); // input.addEventListener
        }

        async function send() {
            message = document.getElementById("text").value;
            enc = new TextEncoder();
            encoded = enc.encode(message);
            message_crypt = await window.crypto.subtle.encrypt(
                {
                    name: "RSA-OAEP",
                },
                keyPair.publicKey,
                encoded
            );
            console.log(message_crypt);
            message_crypt_enc =  window.btoa(message_crypt);
            let p = document.createElement("p");
            p.append('text sent!: '+message);
            document.getElementById("receive").append(p);
            p = document.createElement("p");
            p.append('encypted: '+ message_crypt_enc);
            let encoder = new TextEncoder();
            ciphertext = window.atob(message_crypt_enc);
            console.log(ciphertext);
            document.getElementById("receive").append(p);
            cleartext = await window.crypto.subtle.decrypt(
                { name: "RSA-OAEP" },
                keyPair.privateKey,
                message_crypt
            );
            p = document.createElement("p");
            p.append('decrypted: '+ String.fromCharCode.apply(null, new Uint8Array(cleartext)));
            document.getElementById("receive").append(p);
        }


        </script>
    </head>
    <body>
    <section class="output">
          <pre class="exported-key"></pre>
    </section>
    <div id="send">
        <span>
            <input id="text" type="textarea"  />
            <button id="button" onclick="javascript:send()" type="button">&#9654;</button>
        </span>
    </div>
    <div id="receive">
    </div>
    </body>
</html>
