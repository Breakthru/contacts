const transactions = document.getElementById('transactions');
const children = transactions.childNodes;
// sort them in reverse order
var sorted = document.createElement('div');
sorted.setAttribute("id", "sorted_transactions");
children.forEach(tx => {
    console.log(tx.innerText);
    sorted.insertBefore(tx.cloneNode(true), sorted.firstChild);
});
transactions.parentNode.appendChild(sorted);
const total = document.getElementById('total');
transactions.parentNode.insertBefore(total, transactions.parentNode.firstChild);
transactions.parentNode.removeChild(transactions);

