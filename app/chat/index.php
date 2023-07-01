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

        async function setup() {
            // generate private/public key pair
            // https://developer.mozilla.org/en-US/docs/Web/API/SubtleCrypto/generateKey
            let keyPair = await window.crypto.subtle.generateKey(
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

        function send() {
            text = document.getElementById("text").value;
            p = document.createElement("p");
            p.append('text sent!: '+text);
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
