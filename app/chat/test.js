
let encoder = new TextEncoder();
const bytes = encoder.encode("abc");
console.log(bytes);
const message_crypt_enc =  window.btoa(String.fromCharCode.apply(null, new Uint8Array(bytes)));

console.log(message_crypt_enc);

console.log(encoder.encode(window.atob(message_crypt_enc)))
